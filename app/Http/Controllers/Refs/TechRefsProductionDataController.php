<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Refs\TechProductionDataRequest;
use App\Http\Resources\TechRefsResource;
use App\Models\Refs\TechRefsProductionData;
use App\Models\Refs\TechRefsGu;
use App\Models\Refs\TechRefsSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Response;


class TechRefsProductionDataController extends Controller
{

    public function index(): View
    {
        $techRefsProductionData = TechRefsProductionData::latest()->paginate(12);
//        $techRefsProductionData = [];
        return view('tech_refs.productionData.index',compact('techRefsProductionData'));
    }

    public function tech_refs_data_json(): JsonResponse
    {
        $tech_data = TechRefsResource::collection(TechRefsProductionData::all());

        $tech_data_array = [];
        $column_names = ['Источник данных', 'ГУ', 'Скважина', 'Месяц-Год', 'Добыча нефти тыс.т',
                         'Добыча жидкости тыс.т', 'Отработанные дни', 'ПРС', 'Комментарий', 'Добавлено: дата / автор',
                         'Изменение: дата / автор', 'Редактировать', 'Удалить'];
        array_push($tech_data_array, $column_names);

        foreach ($tech_data as $item) {
            $well = [];

            $edit_url = route("techrefsproductiondata.edit", $item->id);
            $delete_url = route("techrefsproductiondata.destroy", $item->id);

            array_push($well, $item['source_id']);
            array_push($well, $item['gu_id']);

            array_push($well, $item['well_id']);
            array_push($well, date('m-Y', strtotime($item['date'])));
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['days_worked']);
            array_push($well, $item['prs']);
            array_push($well, $item['comment']);
            array_push($well, "{$item['created_at']} {$item['author_id']}");
            array_push($well, "{$item['updated_at']} {$item['editor_id']}");
            array_push($well, $edit_url);
            array_push($well, $delete_url);
            array_push($tech_data_array, $well);
        }

        return response()->json([
            'tech_data' => $tech_data_array
        ]);
    }

    public function create(): View
    {
        $source = TechRefsSource::get();
        $gu = TechRefsGu::get();
        return view('tech_refs.productionData.create', compact('source', 'gu'));
    }

    public function store(TechProductionDataRequest $request): RedirectResponse
    {
        $dataArray = $request->all();
        $dataArray['author_id'] = auth()->user()->id;
        TechRefsProductionData::create($dataArray);

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsProductionData = TechRefsProductionData::find($id);
        $gu = TechRefsGu::get();
        $source = TechRefsSource::get();
        return view('tech_refs.productionData.edit',
            compact('source', 'techRefsProductionData', 'gu'));
    }

    public function update(TechProductionDataRequest $request, int $id): RedirectResponse
    {
        $techRefsProductionData=TechRefsProductionData::find($id);
        $dataArray = $request->all();
        $dataArray['editor_id'] = auth()->user()->id;
        $techRefsProductionData->update($dataArray);

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsProductionData = TechRefsProductionData::find($id);
        $techRefsProductionData->delete();

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.deleted'));
    }

}
