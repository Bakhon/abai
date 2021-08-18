<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DigitalRatingContoller extends Controller
{
    //

   const WELL_STATUS_TYPE_ID = [3,4];
   const WELL_CATEGORY_TYPE_ID = 1;
   const PARAM_GDIS_HDIN_id = 217;
   const PARAM_GDIS_CONCLUSION_GDM_ID = 5000000587;
   public function get_wells($neighboring_wells) {

         foreach ($neighboring_wells as $item) {
            $well_uwi[] = $item['well'];
         }
         $wells =   DB::connection('tbd')->table('tbdi.well')
               ->whereIn('tbdi.well.uwi',$well_uwi)
               ->join('tbdi.well_status', 'tbdi.well.id', '=', 'tbdi.well_status.well_id')
               ->whereIn('tbdi.well_status.well_status_type_id',  self::WELL_STATUS_TYPE_ID)   
               ->join('tbdi.well_category', 'tbdi.well.id', '=', 'tbdi.well_category.well_id')
               ->where('tbdi.well_category.well_category_type_id', self::WELL_CATEGORY_TYPE_ID)
               ->select('tbdi.well.uwi', 'tbdi.well.id','tbdi.well_category.well_category_type_id','tbdi.well_status.well_status_type_id','tbdi.well_status.well_id')
               ->groupBy('well.uwi','well.id','well_category.well_category_type_id','well_status.well_status_type_id','well_status.well_id')
               ->get();

               
         foreach ($wells as $key => $item) {
            if($item->well_status_type_id == 3) {
               $liquid_prod_sum =   DB::connection('tbd')->table('tbdi.liquid_prod')
               ->join('tbdi.bsw_prod', 'tbdi.liquid_prod.well_id', '=', 'tbdi.bsw_prod.well_id')
               ->select([DB::raw('AVG(tbdi.liquid_prod.liquid_val) as liquid_val_average'),DB::raw('AVG(tbdi.bsw_prod.bsw_val) as bsw_val_average'),'tbdi.liquid_prod.well_id','tbdi.bsw_prod.well_id'])
               ->where('tbdi.liquid_prod.well_id',$item->well_id)
               ->whereDate('tbdi.liquid_prod.dend', '>', Carbon::now()->subDays(90))
               ->whereDate('tbdi.bsw_prod.dend', '>', Carbon::now()->subDays(90))
               ->groupBy('tbdi.liquid_prod.well_id','tbdi.bsw_prod.well_id')
               ->first(); 
                  
      
               $param_gdis_hdin =DB::connection('tbd')->table('tbdi.current_gdis_value')
               ->where('tbdi.current_gdis_value.well_id',$item->well_id)
               ->where('tbdi.current_gdis_value.param_gdis_id',self::PARAM_GDIS_HDIN_id)
               ->orderBy('tbdi.current_gdis_value.dbeg','DESC')
               ->first(); 
                $conclusion_gdm =DB::connection('tbd')->table('tbdi.current_gdis_value')
               ->where('tbdi.current_gdis_value.well_id',$item->well_id)
               ->where('tbdi.current_gdis_value.param_gdis_id',self::PARAM_GDIS_CONCLUSION_GDM_ID)
               ->orderBy('tbdi.current_gdis_value.dbeg','DESC')
               ->first();

               $result = $liquid_prod_sum->liquid_val_average * (100 - $liquid_prod_sum->bsw_val_average ) / 100 *0.839;
               $wells[$key]->result = $result;
               $wells[$key]->bsw_val_average = $liquid_prod_sum->bsw_val_average ;
               $wells[$key]->liquid_val_average = $liquid_prod_sum->liquid_val_average;
               $wells[$key]->gdis_conclusion = $conclusion_gdm->gdis_conclusion;
               $wells[$key]->param_gdis_hdin = $param_gdis_hdin->value_double;
            }
         }
         return $wells;                
       
         
   }

 
   public function serach_wells(Request $request){
      $sector = $request->input('sector');
      $horizon = $request->input('horizon');
      $sectors_json_points = file_get_contents(public_path('js/json/digital-rating/sectors_points.json'), 'r');;
         $sectors_points= json_decode($sectors_json_points, true);
         foreach ($sectors_points as $item) {
            if($item['sector'] == $sector) {
               $sector = $item;
            }
         }
         
      $weels_json_points = file_get_contents(public_path('js/json/digital-rating/wells_points.json'), 'r');
      $weels_points= json_decode($weels_json_points, true);


         $sectorX  = $sector['x'];
         $sectorY = $sector['y'];
         $radius =500;
         $neighboring_wells = [];
         // dd($sector);
         foreach ($weels_points as $item) {
            if((($item['x'] - $sectorX)*($item['x'] - $sectorX))+(($item['y']-$sectorY)*($item['y']-$sectorY)) <= $radius*$radius){
            if($item['horizon'] == $horizon)
               $neighboring_wells[] = $item;
            }
         };
         $wells = $this->get_wells($neighboring_wells);
          return response()->json($wells);
   }
};