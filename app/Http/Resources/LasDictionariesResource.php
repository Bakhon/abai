<?php

namespace App\Http\Resources;

class LasDictionariesResource extends CrudListResource
{
    protected $modelName = '';
    protected $link = '';

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
                'name' => $this->name_ru
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }

    protected function getLinks(...$actions)
    {
        $link = $this->link ?? $this->modelName;

        $links = [];
        if ((empty($actions) || in_array('read', $actions)) && auth()->user()->can('bigdata read ' . $this->modelName)) {
            $links['show'] = route($link . '.show', $this->id);
        }
        if ((empty($actions) || in_array('update', $actions)) && auth()->user()->can('bigdata update ' . $this->modelName)) {
            $links['edit'] = route($link . '.edit', $this->id);
        }
        if ((empty($actions) || in_array('history', $actions)) && auth()->user()->can('bigdata view history ' . $this->modelName)) {
            $links['history'] = route($link . '.history', $this->id);
        }
        if ((empty($actions) || in_array('delete', $actions)) && auth()->user()->can('bigdata delete ' . $this->modelName)) {
            $links['delete'] = route($link . '.destroy', $this->id);
        }
        return $links;
    }
}
