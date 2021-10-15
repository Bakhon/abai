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
               $result['events']['event'.$i]['name'] = $event->activity_name;
               $result['events']['event'.$i]['type'] = 'column';
               $result['events']['event'.$i]['data'][] = $is_have ? (($i==0) ? $i+2 : $i*3) : 0;
               $object = new \stdClass();
               $object->activity_value = $item->activity_value ? $item->activity_value : null;
               $object->liquid_telemetry = $item->liquid_telemetry ? '[Жидкость м3/сут (телеметрия): '.$item->liquid_telemetry.']' : null;
               $object->pbuf = $item->pbuf ? '[P буфф:'.$item->pbuf.']' : null;
               $object->pzat = $item->pzat ? '[Р затр:'.$item->pzat.']' : null;
               $object->pbuf_before = $item->pbuf_before ? '[P буфф до штуцера: '.$item->pbuf_before.']' : null;
               $object->pbuf_after = $item->pbuf_after ? '[P буфф после штуцера: '.$item->pbuf_after.']' : null;
               $object->hdin = $item->hdin ? '[Н дин: '.$item->hdin.']' : null;
               $object->pzab = $item->pzab ? '[Р заб: '.$item->pzab.']' : null;
               $object->hstat = $item->hstat ? '[Н стат: '.$item->hstat.']' : null;
               $object->ppl = $item->ppl ? '[Р пл: '.$item->ppl.']' : $item->ppl;
               $object->work_hours = $item->work_hours ? '[Отработанное время: '.$item->work_hours.' ч.]' : null;
               $object->well_status = $item->well_status ? '[Статус: '.$item->well_status.']' : null;
               $object->well_expl =  $item->well_expl ? '[Способ экстплуатации: '.$item->well_expl.']' : null;
               $object->well_category = $item->well_category ? '[Категория скважины: '.$item->well_category.']' : null;
               $object->gdis_conclusion = $item->gdis_conclusion ? '[Заключение ГДИС: '.$item->gdis_conclusion.']' : null;
               $object->reason_downtime = $item->reason_downtime ? '[Причина простоя:'.$item->reason_downtime.']' : null;
               $object->wcut_telemetry = $item->wcut_telemetry ? '[Обводненность % (телеметрия): '.$item->wcut_telemetry.']' : null;
               $object->oil_telemetry = $item->oil_telemetry ? '[Нефть т/сут (телеметрия): '.$item->oil_telemetry.']' : null;
               $object->gas_telemetry = $item->gas_telemetry ? '[Газ м3/сут (телеметрия): '.$item->gas_telemetry.']' : null;
               $object->gas_factor_telemetry = $item->gas_factor_telemetry ? '[Газовый фактор м3/т (телеметрия): '.$item->gas_factor_telemetry.']' : null;
               $object->liquid_temp = $item->liquid_temp ? '[Температура жидкости % (телеметрия): '.$item->liquid_temp.']' : null;
               $object->park_indicator = $item->park_indicator ? '[Парковые показатели: '.$item->park_indicator.']' : null;
               $result['events']['event'.$i]['info'][] = $object;
           }
       }

       return $result;
   }
}