<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CrudListResource extends JsonResource
{
    protected $modelName;
    protected $routeParentName;

    protected function getLinks(...$actions)
    {
        $routeParentName = $this->routeParentName ?? $this->modelName;

        $links = [];
        if ((empty($actions) || in_array('read', $actions)) && auth()->user()->can('monitoring read ' . $this->modelName)) {
            $links['show'] = route($routeParentName . '.show', $this->id);
        }
        if ((empty($actions) || in_array('update', $actions)) && auth()->user()->can('monitoring update ' . $this->modelName)) {
            $links['edit'] = route($routeParentName . '.edit', $this->id);
        }
        if ((empty($actions) || in_array('history', $actions)) && auth()->user()->can('monitoring view history ' . $this->modelName)) {
            $links['history'] = route($routeParentName . '.history', $this->id);
        }
        if ((empty($actions) || in_array('delete', $actions)) && auth()->user()->can('monitoring delete ' . $this->modelName)) {
            $links['delete'] = route($routeParentName . '.destroy', $this->id);
        }
        return $links;
    }
}
