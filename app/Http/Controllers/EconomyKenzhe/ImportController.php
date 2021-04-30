<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\HandbookRepTtTitlesImport;
use App\Imports\HandbookRepTtValueImport;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Http\Controllers\Controller;
use App\Models\EconomyKenzhe\SubholdingCompany;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public $type = null;

    public function importRepTtValues(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_reptt');
        }
        if ($request->isMethod('POST')) {
            Excel::import(new HandbookRepTtValueImport($request->importExcelType), $request->select_file);
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function importRepTtTitlesTree(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_reptt_titles');
        }
        if ($request->isMethod('POST')) {
            $this->type = $request->importExcelType;
            $rows = Excel::toCollection(new HandbookRepTtTitlesImport(), $request->select_file)[0];
            $titles = [];

            foreach ($rows as $row) {
                $parent_id = $this->getHandbookParentId($row[1], $titles);
                if(!$parent_id){
                    $parent_id = 0;
                }
                $data = [
                    'num' => $row[0],
                    'chapter' => $row[1],
                    'name' => $row[2],
                    'parent_chapter' => substr($row[1], 0, -3),
                    'level' => count(explode('.', $row[1])),
                    'parent_id' => $parent_id,
                    'type' => $this->type,
                ];
                $titles[] = $data;
                if($request->importExcelType == 'companies'){
                    SubholdingCompany::create($data);
                }else{
                    HandbookRepTt::create($data);
                }
            }
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }


    public function getHandbookParentId($row, $titles)
    {
        $chapters = explode('.', $row);
        if (count($chapters) <= 0) {
            return 0;
        }
        $parent_chapter = substr($row, 0, -3);
        foreach ($titles as $title) {
            if ($title['chapter'] == $parent_chapter) {
                if($this->type == 'companies'){
                    $handbookItem = SubholdingCompany::whereNum($title['num'])->first();
                }else{
                    $handbookItem = HandbookRepTt::whereNum($title['num'])->first();
                }
                if($handbookItem){
                    return $handbookItem->id;
                }

            }
        }
    }
}
