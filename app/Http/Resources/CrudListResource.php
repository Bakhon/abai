<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CrudListResource extends JsonResource
{
    protected $modelName;
    protected $routeParentName;

    protected function getLinks()
    {
        $routeParentName = $this->routeParentName ?? $this->modelName;

        $links = [];
        if (auth()->user()->can('monitoring read ' . $this->modelName)) {
            $links['show'] = route($routeParentName . '.show', $this->id);
        }
        if (auth()->user()->can('monitoring update ' . $this->modelName)) {
            $links['edit'] = route($routeParentName . '.edit', $this->id);
        }
        if (auth()->user()->can('monitoring view history ' . $this->modelName)) {
            $links['history'] = route($routeParentName . '.history', $this->id);
        }
        if (auth()->user()->can('monitoring delete ' . $this->modelName)) {
            $links['delete'] = route($routeParentName . '.destroy', $this->id);
        }
        return $links;
    }
}
