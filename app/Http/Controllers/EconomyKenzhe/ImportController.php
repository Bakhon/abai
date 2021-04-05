<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\HandbookRepTtTitlesImport;
use App\Imports\HandbookRepTtValueImport;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importRepTtValues(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_reptt');
        } elseif ($request->isMethod('POST')) {
            Excel::import(new HandbookRepTtValueImport($request->importExcelType), $request->select_file);
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function importRepTtTitlesTree(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_reptt_titles');
        } elseif ($request->isMethod('POST')) {
            $type = $request->importExcelType;
            $rows = Excel::toCollection(new HandbookRepTtTitlesImport(), $request->select_file)[0];
            $titles = [];
            foreach ($rows as $row){
                $chapters = explode('.', $row[1]);
                if(count($chapters)>1){
                    $parent_chapter = substr($row[1], 0, -3);
                    $parent_id = $this->handbookParentFinder($parent_chapter, $titles);
                    $data = [
                        'num'=>$row[0],
                        'chapter'=>$row[1],
                        'name'=>$row[2],
                        'parent_chapter'=>$parent_chapter,
                        'parent_id'=>$parent_id,
                        'type'=>$type,
                    ];
                    $titles[] = $data;
                    HandbookRepTt::create($data);
                }else{
                    $data = [
                        'num'=>$row[0],
                        'chapter'=>$row[1],
                        'name'=>$row[2],
                        'parent_chapter'=>substr($row[1], 0, -3),
                        'parent_id'=>0,
                        'type'=>$type,
                    ];
                    $titles[] = $data;
                    HandbookRepTt::create($data);
                }
            }
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }


    public function handbookParentFinder($chapter, $titles){
        foreach($titles as $title){
            if($title['chapter'] == $chapter){
                $handbookItem = HandbookRepTt::whereNum($title['num'])->first();
                return $handbookItem->id;
            }
        }
    }
}
