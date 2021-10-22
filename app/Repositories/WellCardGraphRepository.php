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
       $well_events = $this->well->eventsOfWell($id,$dateFrom);
       if(isset($well_data))
       {
          $data = new \stdClass();
          $data->well_data = $well_data;
          $data->well_events = $well_events;
          $collect_data = $this->collectData($data);
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
           'labels' => [],
           'events'=>[]
       ];

       foreach($data->well_data as $item)
       {
           $dateItem = date('Y-m-d',strtotime($item->date));
           $result['measLiq']['data'][] = $item->liquid;
           $result['measWaterCut']['data'][] = $item->wcut;
           $result['oil']['data'][] = $item->oil;
           $result['ndin']['data'][] = $item->hdin;
           $result['labels'][] = $dateItem;

           foreach($data->well_events as $i=>$event)
           {
               $is_have = false;
               if($event->activity_name==$item->activity_name)
               {
                   $is_have = true;
               }
               $result['events']['event'.$i]['name'] = $event->activity;
               $result['events']['event'.$i]['type'] = 'column';
               $result['events']['event'.$i]['data'][] = $is_have ? (($i==0) ? $i+2 : $i*3) : 0;
               $object = new \stdClass();
              // $object->activity_value = $item->activity_value;
               $object->liquid_telemetry = $item->liquid_telemetry;
               $object->pbuf = $item->pbuf;
               $object->pzat = $item->pzat;
               $object->pbuf_before = $item->pbuf_before;
               $object->pbuf_after = $item->pbuf_after;
               $object->hdin = $item->hdin;
               $object->pzab = $item->pzab;
               $object->hstat = $item->hstat;
               $object->ppl = $item->ppl;
               $object->work_hours = $item->work_hours;
               $object->well_status = $item->well_status;
               $object->well_expl =  $item->well_expl;
               $object->well_category = $item->well_category;
               $object->gdis_conclusion = $item->gdis_conclusion;
               $object->reason_downtime = $item->reason_downtime;
               $object->wcut_telemetry = $item->wcut_telemetry;
               $object->oil_telemetry = $item->oil_telemetry;
               $object->gas_telemetry = $item->gas_telemetry;
               $object->gas_factor_telemetry = $item->gas_factor_telemetry;
               $object->liquid_temp = $item->liquid_temp;
               $object->park_indicator = $item->park_indicator;
               $result['events']['event'.$i]['info'][] = $object;
           }
       }

       return $result;
   }
}