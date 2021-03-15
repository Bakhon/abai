<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class TechnicalStructureController extends Controller
{
    protected $paginate_num = 12;
    protected $model = "";

    protected $view_path = 'technical_forecast';
    protected $controller_name = "";
    protected $index_route = "";

    public function index(): View
    {
        $technicalForecast = $this->model::latest()->paginate($this->paginate_num);

        $view = "{$this->view_path}.{$this->controller_name}.index";

        return view($view,compact('technicalForecast'));
    }

    public function create(): View
    {
        $view = "{$this->view_path}.{$this->controller_name}.create";
        return view($view);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()-> id;
        $this->model::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalForecast = $this->model::find($id);
        $view = "{$this->view_path}.{$this->controller_name}.edit";
        return view($view, compact('technicalForecast'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $technicalForecast=$this->model::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $technicalForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $technicalForecast = $this->model::find($id);
        $technicalForecast->delete();

        return redirect()->route($this->index_route)->with('success',__('app.deleted'));
    }

}
