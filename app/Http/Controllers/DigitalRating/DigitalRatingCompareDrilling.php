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

   const WELL_CATEGORY_TYPE_ID = [1,2,4,6,7];

   public function get_compaer_data(Request $request):JsonResponse 
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
                $data[$key]['actual'] = $act->{"actual__$type"} ;
                $data[$key]['project'] = $prj->{"project__$type"};
                $data[$key]['year'] = $act->year;
                $data[$key]['total'] = $act->{"actual__$type"} - $prj->{"project__$type"};
             }
           
         }
      }
      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($data,200,$headers,JSON_UNESCAPED_UNICODE);
   
   }
   

   public function get_maps(Request $request):JsonResponse 
   {  
      $horizon = $request->input('horizon');
      $data =   DB::connection('tbd')->table('digital_rating.outer_owc_omg_json')
      ->where('digital_rating.outer_owc_omg_json.horizon', $horizon) 
      ->get();

      $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
      return response()->json($data,200,$headers,JSON_UNESCAPED_UNICODE);
   
   }


   public function get_actual_project_points(Request $request):JsonResponse 
   {  
     
     

    $horizon = $request->input('horizon');
    $year = $request->input('year');
    $date_to = $year.'-01-01';
    $date_end = $year.'-12-31';


    $actual_wells_count =   DB::connection('tbd')->table('tbdi.well')
        ->join('tbdi.well_geo', 'tbdi.well.id', '=', 'tbdi.well_geo.well_id')
        ->where('tbdi.well.uwi', 'like', '%UZN%') 
        ->whereDate('tbdi.well_geo.dbeg', '<=',$date_to)
        ->whereDate('tbdi.well_geo.dend', '>', $date_end)
        ->join('tbdi.geo', 'tbdi.well_geo.geo_id', '=', 'tbdi.geo.id')
        ->where('tbdi.geo.name',   $horizon)  
        ->join('tbdi.well_category', 'tbdi.well.id', '=', 'tbdi.well_category.well_id')
        ->whereIn('tbdi.well_category.well_category_type_id', self::WELL_CATEGORY_TYPE_ID)
        ->whereDate('tbdi.well_category.dbeg', '<=',$date_to)
        ->whereDate('tbdi.well_category.dend', '>', $date_end)
        ->select('tbdi.well.uwi','tbdi.well.id','tbdi.geo.name','')
        ->count();

    $project_wells_count =   DB::connection('tbd')->table('digital_rating.project_points')
        ->where('digital_rating.project_points.horizon',   $horizon)  
        ->count();

    $data['actual_wells_count'] = $actual_wells_count;
    $data['project_wells_count'] = $project_wells_count;


    $headers = [ 'Content-Type' => 'application/json; charset=utf-8'];
    return response()->json($data,200,$headers,JSON_UNESCAPED_UNICODE);
   }
 
};
