<?php

namespace App\Http\Controllers\DigitalRating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DigitalRatingContoller extends Controller
{
   const WELL_STATUS_TYPE_ID = [3,4];
   const WELL_ENVIRONMENY_CATEGORY_TYPE_ID = 1;
   const WELL_INJECTION_CATEGORY_TYPE_ID = 2;
   const PARAM_GDIS_HDIN_ID= [217,5000000587];
   const PARAM_GDIS_CONCLUSION_GDM_ID = 5000000587;

   public function get_environment_data(Request $request):JsonResponse
   {

         $sector_number = $request->input('sector');
         $horizon = $request->input('horizon');

         $neighboring_wells = $this->search_wells($sector_number,$horizon,self::WELL_ENVIRONMENY_CATEGORY_TYPE_ID);

         if(is_null($neighboring_wells)) {
            return response()->json(['message' => 'Well not found']);
         }
         foreach ($neighboring_wells as $item) {
            $well_id[] = $item->well_id;
         }
         $wells =   DB::connection('tbd')->table('tbdi.well')
               ->whereIn('tbdi.well.id',$well_id)
               ->join('tbdi.liquid_prod', 'tbdi.well.id', '=', 'tbdi.liquid_prod.well_id')
               ->join('tbdi.bsw_prod', 'tbdi.liquid_prod.well_id', '=', 'tbdi.bsw_prod.well_id')
               ->selectRaw('AVG(tbdi.liquid_prod.liquid_val) as liquid_val_average,tbdi.liquid_prod.well_id,AVG(tbdi.bsw_prod.bsw_val) as bsw_val_average,well.uwi')
               ->whereDate('tbdi.liquid_prod.dend', '>', Carbon::now()->subDays(90))
               ->whereDate('tbdi.bsw_prod.dend', '>', Carbon::now()->subDays(90))
               ->groupBy('tbdi.liquid_prod.well_id','tbdi.bsw_prod.well_id','well.uwi')
               ->get();

                
         $params_gdis = DB::connection('tbd')->
         select("SELECT *
         FROM tbdi.current_gdis_value cgv
         INNER JOIN (
            SELECT well_id, param_gdis_id, max( dbeg)
            FROM tbdi.current_gdis_value 
            where 1=1
            and param_gdis_id in (5000000587, 217)
            and well_id in (".implode(',',$well_id).")
            GROUP BY well_id, param_gdis_id
         ) b ON cgv.well_id = b.well_id AND cgv.param_gdis_id = b.param_gdis_id AND cgv.dbeg = b.max
         ");
           
         foreach ($wells as $key => $item) {
            foreach ($params_gdis as $param) {
               if($param->well_id == $item->well_id) {
                  if($param->param_gdis_id == 217) {
                       $wells[$key]->param_value_double  = number_format( $param->value_double);
                  }else {
                     $wells[$key]->param_gdis_conclusion  = $param->gdis_conclusion;
                  }
               }
            }

            $result = $item->liquid_val_average * (100 - $item->bsw_val_average ) / 100 * 0.839;
            $wells[$key]->result = number_format( $result, 1);
            $wells[$key]->liquid_val_average  = number_format( $item->liquid_val_average);
            $wells[$key]->bsw_val_average  = number_format( $item->bsw_val_average);
        
         }
         $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
         return response()->json($wells,200,$headers,JSON_UNESCAPED_UNICODE);
          
   }

 
   public function search_wells(int $sector_number,int  $horizon,int $category_id) : ?object  
   {  
     
      if(file_exists(public_path('js/json/digital-rating/horizon/grid_'.$horizon.'.json'))){
         $sectors_json_points = file_get_contents(public_path('js/json/digital-rating/horizon/grid_'.$horizon.'.json'), 'r');
      } else {  
         return null;
      }
     
      $sectors_points= json_decode($sectors_json_points, true);

      foreach ($sectors_points as $item) {
         if($item['sector'] == $sector_number) {
            $sector = $item;
         }
      }
      if(empty($sector)){
         return null;
      }
      $weels_json_points = file_get_contents(public_path('js/json/digital-rating/wells_points.json'), 'r');
      $weels_points= json_decode($weels_json_points, true);
      $sectorX  = $sector['x1']+100;
      $sectorY = $sector['y1']+100;
      $radius = 500;
      $neighboring_wells = [];

      foreach ($weels_points as $item) {
         if((($item['x'] - $sectorX)*($item['x'] - $sectorX))+(($item['y']-$sectorY)*($item['y']-$sectorY)) <= $radius*$radius){
            if($item['horizon'] == $horizon){
               $neighboring_wells_uwi[] = $item['well'];
            }
         }
      };

      $neighboring_wells =   DB::connection('tbd')->table('tbdi.well')
         ->whereIn('tbdi.well.uwi',$neighboring_wells_uwi)
         ->join('tbdi.well_geo', 'tbdi.well.id', '=', 'tbdi.well_geo.well_id')
         ->whereDate('tbdi.well_geo.dend', '>', Carbon::now())
         ->join('tbdi.geo', 'tbdi.well_geo.geo_id', '=', 'tbdi.geo.id')
         ->where('tbdi.geo.name',   $horizon)  
         ->join('tbdi.well_status', 'tbdi.well.id', '=', 'tbdi.well_status.well_id')
         ->whereDate('tbdi.well_status.dend', '>', Carbon::now())
         ->where('tbdi.well_status.well_status_type_id',  self::WELL_STATUS_TYPE_ID)   
         ->join('tbdi.well_category', 'tbdi.well.id', '=', 'tbdi.well_category.well_id')
         ->whereDate('tbdi.well_category.dend', '>', Carbon::now())
         ->where('tbdi.well_category.well_category_type_id', $category_id)
         ->select('tbdi.well.uwi', 'tbdi.well.id','tbdi.well_category.well_category_type_id','tbdi.well_status.well_status_type_id','tbdi.well_status.well_id','tbdi.well_geo.geo_id','tbdi.geo.name')
         ->groupBy('well.uwi','well.id','well_category.well_category_type_id','well_status.well_status_type_id','well_status.well_id','tbdi.well_geo.geo_id','tbdi.geo.name')
         ->get();
        
         return $neighboring_wells;
         
        
   }

  
  
   public function get_injection_wells(Request $request):JsonResponse 
   {  
     
      $sector_number = $request->input('sector');
      $horizon = $request->input('horizon');

      $neighboring_wells = $this->search_wells($sector_number,$horizon,self::WELL_INJECTION_CATEGORY_TYPE_ID);

      if(is_null($neighboring_wells)) {
         return response()->json(['message' => 'Well not found']);
      }
      foreach ($neighboring_wells as $item) {
         $well_id[] = $item->well_id;
      }
      $injection_wells =   DB::connection('tbd')->table('tbdi.well')
               ->whereIn('tbdi.well.id',$well_id)
               ->join('tbdi.water_inj', 'tbdi.water_inj.well_id', '=', 'tbdi.well.id')
               ->whereIn('tbdi.water_inj.well_id',$well_id)
               ->selectRaw("SUM(tbdi.water_inj.water_inj_val) as waterinj_val,tbdi.water_inj.well_id,tbdi.well.id,tbdi.well.uwi")
               ->whereDate('tbdi.water_inj.dbeg', '>', Carbon::now()->subDays(90))
               ->groupBy('tbdi.water_inj.well_id','tbdi.well.uwi','tbdi.well.id')
               ->get();
      $injection_wells_status =   DB::connection('tbd')->table('tbdi.well_status')
               ->whereIn('tbdi.well_status.well_id',$well_id)
               ->whereDate('tbdi.well_status.dend', '>', Carbon::now()->subDays(90))
               ->selectRaw("well_id,SUM(DATE_PART('day', tbdi.well_status.dend::date) - DATE_PART('day', tbdi.well_status.dbeg::date) ) AS not_work_days ")
               ->where('tbdi.well_status.well_status_type_id', 4) 
               ->groupBy('well_status.well_id')
               ->get();      
             
      foreach ($injection_wells as $key => $item) {
         foreach ($injection_wells_status as $iws) {
            if($item->well_id == $iws->well_id ) { 
               $injection_wells[$key]->avg_waterinj = number_format( $item->waterinj_val / (90 -  abs($iws->not_work_days)), 2) ;
            }
         }
      }

      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($injection_wells,200,$headers,JSON_UNESCAPED_UNICODE);
   
   }
  
};