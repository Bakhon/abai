<?php

namespace App\Http\Controllers\DigitalRating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DigitalRatingCompareDrilling extends Controller
{

   const WELL_CATEGORY_TYPE_ID = [1];
   const WELL_STATUS_TYPE_ID = [3,4];

   public function getCompareData(Request $request):JsonResponse 
   {  
      $horizon = $request->input('horizon');
      $year = $request->input('year');
      $type = $request->input('type');
      $actual =   DB::connection('tbd')->table('digital_rating.actual_production')
      ->where('digital_rating.actual_production.horizon', $horizon) 
      ->select('digital_rating.actual_production.'.$type.' as actual__'.$type.'','year')
      ->get();
      $project= DB::connection('tbd')->table('digital_rating.development_project')
      ->where('digital_rating.development_project.horizon', $horizon) 
      ->select('digital_rating.development_project.'.$type.' as project__'.$type.'','year')
      ->get();
      $data=[];
      foreach ($actual as $key => $act) {
         foreach ($project as $prj) {
             if($act->year == $prj->year) {
                $data[$key]['actual'] =$act->{"actual__$type"} ;
                $data[$key]['project'] =  $prj->{"project__$type"};
                $data[$key]['year'] = $act->year;
                $data[$key]['total'] = number_format( $act->{"actual__$type"} - $prj->{"project__$type"}, 1);
             }
           
         }
      }
      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($data,200,$headers,JSON_UNESCAPED_UNICODE);
   }
   

   public function getMapCoordinates(Request $request):JsonResponse 
   {  
      $field = $request->input('field');
      $horizon = $request->input('horizon');
      $owc = $request->input('owc');
      if(empty($owc)) {
         $data =   DB::connection('tbd')->table('digital_rating.outer_owc_omg_json')
         ->where('digital_rating.outer_owc_omg_json.field', $field) 
         ->where('digital_rating.outer_owc_omg_json.horizon', $horizon) 
         ->get();
      }else {
         $data =   DB::connection('tbd')->table('digital_rating.outer_owc_omg_json')
         ->where('digital_rating.outer_owc_omg_json.field', $field) 
         ->where('digital_rating.outer_owc_omg_json.horizon', $horizon) 
         ->whereIn('digital_rating.outer_owc_omg_json.owc_id', $owc) 
         ->get();
      }
      foreach ($data as $item) {
         $coordinates = substr( $item->coordinates, 1, -1);
         preg_match_all('#\[(.*?)\]#', $coordinates, $array);
         $item->coordinates= $array[0];
      }
      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($data,200,$headers,JSON_UNESCAPED_UNICODE);
   }

   public function getHorizon(Request $request):JsonResponse 
   {  
      $result =   DB::connection('tbd')->table('digital_rating.horizon')
      ->get()
      ->groupBy('filed')
      ->transform(function($data,$key){
         $result=['title'=>$key];
         $children=[];
         $groupedDataByHorizon = $data->groupBy('horizon');
         foreach ($groupedDataByHorizon as $keyHorizon => $item) {
            $bufferArray=['title'=>$keyHorizon];
            $lastChildren=[];
            $owc_code=[];
            foreach ($item as $keyBlock => $block) {
               if ($block->owc_id_1 != '-') array_push($owc_code, $block->owc_id_1);
               if ($block->owc_id_2 != '-') array_push($owc_code, $block->owc_id_2);
               if ($block->owc_id_3 != '-') array_push($owc_code, $block->owc_id_3);
               $lastChildren[]=[
                  'id'=>$block->id,
                  'title'=>$block->block,
                  'horizon'=>$block->horizon,
                  'filed'=>$block->filed_code,
                  'owc' =>$owc_code
               ];
            }
            
            $bufferArray['children']=$lastChildren;
            $children[] = $bufferArray;
         };
         $result['children'] = $children;
         return $result;
      })->toArray();
      $result = array_values($result);
      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($result,200,$headers,JSON_UNESCAPED_UNICODE);
   }

   public function getActualProjectPoints(Request $request):JsonResponse 
   {  
      $horizon = $request->input('horizon');
      $year = $request->input('year');
      $filed= $request->input('filed');;
      $owc = $request->input('owc');
      $data =   DB::connection('tbd')->table('tbdi.well')
         ->where('tbdi.well.uwi', 'like', '%' . $filed . '%')
         ->join('tbdi.well_geo', 'tbdi.well.id', '=', 'tbdi.well_geo.well_id')
         ->whereYear('tbdi.well.dt', '=',  $year)
         ->join('tbdi.geo', 'tbdi.well_geo.geo_id', '=', 'tbdi.geo.id')
         ->where('tbdi.geo.name',   $horizon)  
         ->join('tbdi.well_category', 'tbdi.well.id', '=', 'tbdi.well_category.well_id')
         ->whereIn('tbdi.well_category.well_category_type_id',self::WELL_CATEGORY_TYPE_ID)
         ->join('digital_rating.wells_fond_omg', 'tbdi.well.uwi', '=', 'digital_rating.wells_fond_omg.well')
         ->whereIn('digital_rating.wells_fond_omg.block', $owc)
         ->select('tbdi.well.uwi','digital_rating.wells_fond_omg.x','digital_rating.wells_fond_omg.y')
         ->groupBy('tbdi.well.uwi','digital_rating.wells_fond_omg.x','digital_rating.wells_fond_omg.y')
         ->get();

      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($data,200,$headers,JSON_UNESCAPED_UNICODE);
   }
 
};
