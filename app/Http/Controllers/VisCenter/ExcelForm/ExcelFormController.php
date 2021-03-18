<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use App\Models\VisCenter\ExcelForm\DzoImportDecreaseReason;
use App\Models\VisCenter\ExcelForm\DzoImportField;
use Carbon\Carbon;

class ExcelFormController extends Controller
{
    public function store(Request $request)
    {
        $dzoSummaryData = new DzoImportData;
        $dzoData = $request->request->all();
        foreach ($dzoData as $key => $item) {
            if ($key == 'downtimeReason') {
                continue;
            }
            $dzoSummaryData->$key = $dzoData[$key];
        }
        dd($dzoSummaryData);

        $dzoSummaryData->save();
        $dzoSummary = DzoImportData::latest('id')->first();

        $dzoDowntimeReasons = new DzoImportDowntimeReason;
        $downtimeData = $request->request->get('downtimeReason');
        $dzoDowntimeReasons->importData()->associate($dzoSummary);
        foreach ($downtimeData as $key => $item) {
            $dzoDowntimeReasons->$key = $downtimeData[$key];
        }

        $dzoDowntimeReasons->save();

        $dzoDecreaseReasons = new DzoImportDecreaseReason;
        $decreaseData = $request->request->get('decreaseReason');
        $dzoDecreaseReasons->importData()->associate($dzoSummary);
        foreach ($decreaseData as $key => $item) {
            $dzoDecreaseReasons->$key = $decreaseData[$key];
        }

        $dzoDecreaseReasons->save();

        $dzoImportFields = new DzoImportField;
        $fieldsData = $request->request->get('importField');
        $dzoImportFields->importData()->associate($dzoSummary);
        foreach ($fieldsData as $key => $item) {
            $dzoImportFields->$key = $fieldsData[$key];
        }

        $dzoImportFields->save();
        return redirect('ru/excelform')->withStatus(__('Данные успешно сохранены!'));
    }
}
