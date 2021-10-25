<?php

namespace App\Repositories;
use App\Models\BigData\Well;
use App\Repositories\Interfaces\WellRepositoryInterface;

class WellCardGraphRepository  implements WellRepositoryInterface
{
   private $well;
   public function __construct(Well $well)
   {
        $this->well = $well;
   }

   public function wellItems(int $id, ?int $period): ?array
   {
       $collect_data = new \stdClass();
       $dateFrom = date('Y-m-d');
       $dateFrom =  ($period) ? date('Y-m-d',strtotime($dateFrom.'-'.$period.' day')) : null;

       $well_data = $this->well->wellData($id,$dateFrom);
       if(isset($well_data))
       {
          $collect_data = $this->collectData($well_data);
       }
       return $collect_data;
   }

   public function collectData(object $data):array
   {
       $result = [
           'measLiq' => ['name' => trans('app.liquid'),'type' => 'area','data'=>[]],
           'measWaterCut' => ['name' => trans('app.waterCut'),'type' => 'line','data'=>[]],
           'oil' => ['name' => trans('app.oil'),'type' => 'area','data'=>[]],
           'ndin' => ['name' => trans('app.ndin'),'type' => 'line','data'=>[]],
           'labels' => []
       ];

       foreach($data as $item)
       {
           $result['measLiq']['data'][] = $item->liquid;
           $result['measWaterCut']['data'][] = $item->wcut;
           $result['oil']['data'][] = $item->oil;
           $result['ndin']['data'][] = $item->hdin;
           $result['labels'][] = date('Y-m-d',strtotime($item->date));
       }
       return $result;
   }
}