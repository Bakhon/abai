<?php

if (!function_exists('getAllObjectsWithOmgngdu')) {
    function getAllObjectsWithOmgngdu(string $objectName, string $relation = 'omgngdu'): array
    {
        $model_prefix = "App\Models\ComplicationMonitoring";
        $models = [
            $model_prefix . '\\' . $objectName,
            $model_prefix . '\\Manual' . $objectName
        ];

        $result = [];
        foreach ($models as $model) {
            $modelArray = $model::whereHas($relation)
                ->orderBy('name', 'asc')
                ->get()
                ->map(
                    function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                        ];
                    }
                )
                ->toArray();
            $result = array_merge($result, $modelArray);
        }

        return $result;
    }
}