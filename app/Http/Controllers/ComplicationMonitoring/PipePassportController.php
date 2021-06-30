<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\PipePassportFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\PipePassportRequest;
use App\Http\Resources\PipePassportListResource;
use App\Models\ComplicationMonitoring\PipePassport;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PipePassportController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'pipe-passport';

    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('pipe-passport.list'),
            ],
            'title' => __('monitoring.pipe_passport.title'),
            'fields' => [
                'field' => [
                    'title' => __('monitoring.pipe_passport.field'),
                    'type' => 'string',
                ],
                'installation_date' => [
                    'title' => __('monitoring.pipe_passport.installation_date'),
                    'type' => 'date',
                ],
                'ngdu' => [
                    'title' => __('monitoring.ngdu'),
                    'type' => 'string',
                ],
                'cdng' => [
                    'title' => __('monitoring.cdng'),
                    'type' => 'string',
                ],
                'gu' => [
                    'title' => __('monitoring.gu.gu'),
                    'type' => 'string',
                ],
                'name' => [
                    'title' => __('monitoring.pipe_passport.name'),
                    'type' => 'string',
                ],
                'main_reserved' => [
                    'title' => __('monitoring.pipe_passport.main_reserved'),
                    'type' => 'string',
                ],
                'from' => [
                    'title' => __('monitoring.pipe_passport.from'),
                    'type' => 'string',
                ],
                'to' => [
                    'title' => __('monitoring.pipe_passport.to'),
                    'type' => 'string',
                ],
                'length' => [
                    'title' => __('monitoring.pipe.fields.length'),
                    'type' => 'string',
                ],
                'diameter' => [
                    'title' => __('monitoring.pipe_passport.diameter'),
                    'type' => 'string',
                ],
                'thickness' => [
                    'title' => __('monitoring.pipe.fields.thickness'),
                    'type' => 'string',
                ],
                'material' => [
                    'title' => __('monitoring.pipe.fields.material'),
                    'type' => 'string',
                ],
                'condition' => [
                    'title' => __('monitoring.pipe_passport.condition'),
                    'type' => 'string',
                ],
                'gusts' => [
                    'title' => __('monitoring.pipe_passport.gusts'),
                    'type' => 'number',
                ],
                'data_sheet' => [
                    'title' => __('monitoring.pipe_passport.data_sheet'),
                    'type' => 'string',
                ],
                'used' => [
                    'title' => __('monitoring.pipe_passport.used'),
                    'type' => 'string',
                ],
                'comment' => [
                    'title' => __('monitoring.pipe_passport.comment'),
                    'type' => 'string',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route('pipe-passport.create');
        }

        $params['model_name'] = $this->modelName;
        $params['filter'] = session($this->modelName.'_filter');

        return view('complicationMonitoring.pipePassport.index', compact('params'));
    }

    public function list(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        parent::list($request);

        $query = PipePassport::query();

        $pipePassports = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(PipePassportListResource::collection($pipePassports)->toJson()));
    }

    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('pipe-passport');
        return view('complicationMonitoring.pipePassport.create', compact('validationParams'));
    }

    public function store(PipePassportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'pipe-passport');
        PipePassport::create($request->validated());
        return redirect()->route('pipe-passport.index')->with('success', __('app.created'));
    }

    public function history(PipePassport $pipe): \Illuminate\View\View
    {
        $pipe->load('history');
        return view('complicationMonitoring.pipePassport.history', compact('pipe'));
    }

    public function edit(PipePassport $pipe_passport): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('pipe-passport');
        return view('complicationMonitoring.pipePassport.edit', compact('pipe_passport', 'validationParams'));
    }

    public function update(PipePassportRequest $request, PipePassport $pipe_passport): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'pipe-passport');

        $pipe_passport->update($request->validated());
        return redirect()->route('pipe-passport.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, PipePassport $pipe_passport)
    {
        $pipe_passport->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('pipe-passport.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null): \Illuminate\Database\Eloquent\Builder
    {
        return (new PipePassportFilter($query, $filter))->filter();
    }
}
