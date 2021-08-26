<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DigitalRatingContoller extends Controller
{
   const WELL_STATUS_TYPE_ID = [3,4];
   const WELL_CATEGORY_TYPE_ID = 1;
   const PARAM_GDIS_HDIN_id = 217;
   const PARAM_GDIS_CONCLUSION_GDM_ID = 5000000587;
   
   public function get_wells(array $neighboring_wells) : object  
   {
         foreach ($neighboring_wells as $item) {
            $well_uwi[] = $item['well'];
         }
         $wells =   DB::connection('tbd')->table('tbdi.well')
               ->whereIn('tbdi.well.uwi',$well_uwi)
               ->join('tbdi.well_status', 'tbdi.well.id', '=', 'tbdi.well_status.well_id')
               ->whereIn('tbdi.well_status.well_status_type_id',  self::WELL_STATUS_TYPE_ID)   
               ->join('tbdi.well_category', 'tbdi.well.id', '=', 'tbdi.well_category.well_id')
               ->where('tbdi.well_category.well_category_type_id', self::WELL_CATEGORY_TYPE_ID)
               ->join('tbdi.liquid_prod', 'tbdi.well_status.well_id', '=', 'tbdi.liquid_prod.well_id')
               ->join('tbdi.bsw_prod', 'tbdi.liquid_prod.well_id', '=', 'tbdi.bsw_prod.well_id')
               ->select('tbdi.well.uwi', 'tbdi.well.id','tbdi.well_category.well_category_type_id','tbdi.well_status.well_status_type_id','tbdi.well_status.well_id')
               ->selectRaw('AVG(tbdi.liquid_prod.liquid_val) as liquid_val_average')
               ->selectRaw('AVG(tbdi.bsw_prod.bsw_val) as bsw_val_average')
                ->whereDate('tbdi.liquid_prod.dend', '>', Carbon::now()->subDays(90))
               ->whereDate('tbdi.bsw_prod.dend', '>', Carbon::now()->subDays(90))
               ->groupBy('well.uwi','well.id','well_category.well_category_type_id','well_status.well_status_type_id','well_status.well_id','tbdi.liquid_prod.well_id','tbdi.bsw_prod.well_id')
               ->get();

         foreach ($wells as $key => $item) {
            if($item->well_status_type_id == 3) {
               $params_gdis = DB::connection('tbd')->select('select * from tbdi.current_gdis_value 
               where well_id = :id AND param_gdis_id IN(:PARAM_GDIS_HDIN_id,:PARAM_GDIS_CONCLUSION_GDM_ID) 
               ORDER BY dbeg DESC LIMIT 2', 
               ['id' => $item->well_id,'PARAM_GDIS_HDIN_id'=>self::PARAM_GDIS_HDIN_id,
               'PARAM_GDIS_CONCLUSION_GDM_ID'=>self::PARAM_GDIS_CONCLUSION_GDM_ID]);

               foreach ($params_gdis as $param) {
                  if($param->param_gdis_id == 217) {
                     $param_gdis_hdin = $param->value_double;
                  }else {
                     $gdis_conclusion = $param->gdis_conclusion;
                  }
                 
               }

               $result = $item->liquid_val_average * (100 - $item->bsw_val_average ) / 100 *0.839;
               $wells[$key]->result = number_format( $result, 2);
               $wells[$key]->liquid_val_average  = number_format( $item->liquid_val_average, 2);
               $wells[$key]->bsw_val_average  = number_format( $item->bsw_val_average, 2);
               $wells[$key]->gdis_conclusion = $gdis_conclusion;
               $wells[$key]->param_gdis_hdin = number_format( $param_gdis_hdin, 2) ;

            }
         }
         return $wells;                
   }

 
   public function search_wells(Request $request):JsonResponse
   {
      $sector = $request->input('sector');
      $horizon = $request->input('horizon');
      $sectors_json_points = file_get_contents(public_path('js/json/digital-rating/sectors_points.json'), 'r');
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
         foreach ($weels_points as $item) {
            if((($item['x'] - $sectorX)*($item['x'] - $sectorX))+(($item['y']-$sectorY)*($item['y']-$sectorY)) <= $radius*$radius){
            if($item['horizon'] == $horizon)
               $neighboring_wells[] = $item;
            }
         };
         $wells = $this->get_wells($neighboring_wells);
         $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
         return response()->json($wells,200,$headers,JSON_UNESCAPED_UNICODE);
   }
};