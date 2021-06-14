<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MapHistoryResource extends JsonResource
{
    protected $modelName = 'omgca';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'fields' => [
                'action' => trans('app.'.$this->description),
                'subject' => $this->getSubjectTranslate($this->subject),
                'user' => $this->causer->username,
                'date' => Carbon::parse($this->created_at)->format('Y-d-m H:i:s'),
            ]
        ];

        $result['links'] = [
            'show' => route('map-history.show', $this->id),
            'restore' => route('map-history.restore', $this->id),
        ];

        return $result;
    }

    public function getSubjectTranslate ($subject) {
        switch (class_basename($subject)) {
            case 'PipeCoord':
                return  trans('monitoring.pipe.coords');
                break;
            case 'PipeType':
                return  trans('monitoring.pipe.type');
                break;
            case 'OilPipe':
                return  trans('monitoring.pipe.pipe');
                break;
            case 'Gu':
                return  trans('monitoring.gu.gu');
                break;
            case 'Zu':
                return  trans('monitoring.zu.zu');
                break;
            case 'Well':
                return  trans('monitoring.well.well');
                break;
        }

        return class_basename($subject);
    }
}
