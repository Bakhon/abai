<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexFieldRequest;
use App\Http\Resources\FieldResource;
use App\Models\Refs\Field;
use App\Models\Refs\Org;
use Illuminate\Support\Collection;

class FieldController extends Controller
{
    public function index(IndexFieldRequest $request): array
    {
        $organizations = auth()->user()->getOrganizations();

        $fields = self::getFields($request, $organizations);

        return [
            'fields' => FieldResource::collection($fields)
        ];
    }

    static function getFields(IndexFieldRequest $request, Collection $organizations): Collection
    {
        if (!$organizations->count()) {
            return collect();
        }

        if ($request->org_id) {
            /** @var Org $org */
            $org = $organizations->firstWhere('id', $request->org_id);

            return $org ? $org->fields()->get() : collect();
        }

        return Field::query()
            ->whereIn('org_id', $organizations->pluck('id'))
            ->get();
    }
}
