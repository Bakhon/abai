<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\MapHistoryFilter;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\MapHistoryResource;
use App\Models\ComplicationMonitoring\PipeCoord;
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

        switch ($activity->description) {
            case 'created':
                foreach ($activity->changes()['attributes'] as $key => $value) {
                    $changes[$key] = [
                        'old' => null,
                        'current' => $value
                    ];
                }
                break;
            case 'deleted':
                foreach ($activity->changes()['attributes'] as $key => $value) {
                    $changes[$key] = [
                        'old' => $value,
                        'current' => null
                    ];
                }
                break;
            case 'updated':
                foreach ($activity->changes()['old'] as $key => $value) {
                    $changes[$key] = [
                        'old' => $value,
                        'current' => $activity->changes()['attributes'][$key]
                    ];
                }
                break;

        }

        $params = [
            'subject' => $this->getSubjectTranslate($activity->subject_type),
            'changes' => $changes,
            'activity' => $activity
        ];

        return view('complicationMonitoring.map-history.show', compact('params'));
    }

    public function restore (Activity $activity) {
        activity()->disableLogging();

        switch ($activity->description) {
            case 'created':
                return $this->deleteCreated($activity);
            case 'deleted':
                return $this->restoreDeleted($activity);
            case 'updated':
                return $this->rollBackChanges($activity);

        }
    }

    protected function getSubjectTranslate(string $subject): string
    {
        switch (basename($subject)) {
            case 'PipeCoord':
                return trans('monitoring.pipe.coords');
            case 'PipeType':
                return trans('monitoring.pipe.type');
            case 'OilPipe':
                return trans('monitoring.pipe.pipe');
            case 'Gu':
                return trans('monitoring.gu.gu');
            case 'Zu':
                return trans('monitoring.zu.zu');
            case 'Well':
                return trans('monitoring.well.well');
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new MapHistoryFilter($query, $filter))->filter();
    }

    protected function rollBackChanges (Activity $activity)
    {
        $subject = $activity->subject;
        foreach ($activity->changes()['old'] as $key => $value) {
            $subject->$key = $value;
        }

        $result = $subject->save();

        if ($result) {
            Session::flash('success', __('app.restored'));
            $activity->delete();
        }

        return response()->json(
            [
                'status' => $result ? config('response.status.success') : config('response.status.error'),
            ]
        );
    }

    protected function restoreDeleted (Activity $activity)
    {
        $subject = $activity->subject;
        $result = $subject->restore();

        if (basename($activity->subject_type) == 'OilPipe') {
            PipeCoord::where('oil_pipe_id', $subject->id)->restore();
        }

        if ($result) {
            Session::flash('success', __('app.restored'));
            $activity->delete();
        }

        return response()->json(
            [
                'status' => $result ? config('response.status.success') : config('response.status.error'),
            ]
        );
    }

    protected function deleteCreated (Activity $activity)
    {
        $result = $activity->subject->delete();

        if ($result) {
            Session::flash('success', __('app.deleted'));
            $activity->delete();
        }

        return response()->json(
            [
                'status' => $result ? config('response.status.success') : config('response.status.error'),
            ]
        );
    }
}
