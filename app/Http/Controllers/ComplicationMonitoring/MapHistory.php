<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\MapHistoryFilter;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\MapHistoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class MapHistory extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('map-history.list'),
            ],
            'title' => __('monitoring.map-history.title'),
            'fields' => [
                'date' => [
                    'title' => __('app.date'),
                    'type' => 'date',
                ],
                'action' => [
                    'title' => __('monitoring.map-history.action'),
                    'type' => 'select',
                    'filter' => [
                        'values' => [
                            [
                                'id' => 'created',
                                'name' => __('app.created')
                            ],
                            [
                                'id' => 'deleted',
                                'name' => __('app.deleted')
                            ],
                            [
                                'id' => 'updated',
                                'name' => __('app.updated')
                            ]
                        ]
                    ]
                ],
                'subject' => [
                    'title' => __('monitoring.map-history.subject'),
                    'type' => 'select',
                    'filter' => [
                        'values' => [
                            [
                                'id' => 'PipeCoord',
                                'name' => __('monitoring.pipe.coords')
                            ],
                            [
                                'id' => 'Gu',
                                'name' => __('monitoring.gu.gu')
                            ],
                            [
                                'id' => 'Zu',
                                'name' => __('monitoring.zu.zu')
                            ],
                            [
                                'id' => 'Well',
                                'name' => __('monitoring.well.well')
                            ],
                            [
                                'id' => 'PipeType',
                                'name' => __('monitoring.pipe.type')
                            ],
                            [
                                'id' => 'OilPipe',
                                'name' => __('monitoring.pipe.pipe')
                            ],
                        ]
                    ]
                ],
                'user' => [
                    'title' => __('profile.username'),
                    'type' => 'number',
                ],
            ]
        ];

        return view('complicationMonitoring.map-history.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Activity::query();

        $activities = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(MapHistoryResource::collection($activities)->toJson()));
    }

    public function show(Activity $activity)
    {
        $changes = [];
        foreach ($activity->changes()['old'] as $key => $value) {
            $changes[$key] = [
                'old' => $value,
                'current' => $activity->changes()['attributes'][$key]
            ];
        }

        return view('complicationMonitoring.map-history.show', compact('changes', 'activity'));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new MapHistoryFilter($query, $filter))->filter();
    }
}
