<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Models\BigData\Dictionaries\WellStatus;
use App\Models\BigData\Gtm;
use App\Models\BigData\WellPerf;
use App\Models\BigData\WellWorkover;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class WellCardChart extends Controller
{
    public function getWellEvents(Request $request)
    {
        $wellId = $request->get('wellId');
        $period = $request->get('period');

        $wellWorkover = WellWorkover::where('well', $wellId);
        $gtms = Gtm::where('well', $wellId);
        $wellStatuses = WellStatus::where('well', $wellId);
        $wellPerfs = WellPerf::where('well', $wellId);

        $dateFrom = Carbon::now(env('APP_TIMEZONE','Asia/Aqtau'));
        if ($period) {
            $dateFrom->subDays($period);
            $wellWorkover->where('dbeg', '>=', $dateFrom);
            $gtms->where('dbeg', '>=', $dateFrom);
            $wellStatuses->where('dbeg', '>=', $dateFrom);
            $wellPerfs->where('perf_date', '>=', $dateFrom);
            
        }
        
        $wellWorkover = $wellWorkover->whereIn('repair_type', [1, 3])->orderBy('dbeg', 'asc')->get();
        $gtms = $gtms->with('gtmType')->orderBy('dbeg', 'asc')->get()->toArray();        
        $wellPerfs = $wellPerfs->with('intervals')->get()->toArray();

        $events['perforations'] = $this->getIntervals($wellPerfs);
        $events['workovers'] = $this->getWorkovers($wellWorkover);
        $events['gtms'] = $this->getGtms($gtms);


        return $events;
    }

    private function getIntervals(array $wellPerfs): array
    {
        $intervals = [];

        foreach ($wellPerfs as $wellPerf) {
            foreach ($wellPerf['intervals'] as $interval) {
                $dend = $this->dateFormat($interval['dend']);

                $intervals[$this->dateFormat($interval['dbeg'])] = [
                    "Кровля ".round($interval['top'])." Подошва ".round($interval['base'])
                ];

                if($dend < date('Y-m-d H:i:sP')){
                    $intervals[$dend] = [
                        "Кровля ".round($interval['top'])." Подошва ".round($interval['base'])
                    ];
                }
            }
        }

        return $intervals;
    }

    private function getWorkovers(object $workovers): array
    {
        $workoversResult = [
            'krs' => [],
            'prs' => [],
        ];

        foreach ($workovers as $workover) {
            $dend = $this->dateFormat($workover->dend);
            if ($workover->repair_type == 1){
                $workoversResult['krs'][$this->dateFormat($workover->dbeg)] = $workover->work_plan;
                if($dend < date('Y-m-d H:i:sP')){
                    $workoversResult['krs'][$dend] = $workover->work_list;
                }
            } elseif ($workover->repair_type == 3) {
                $workoversResult['krs'][$this->dateFormat($workover->dbeg)] = $workover->work_plan;
                if($dend < date('Y-m-d H:i:sP')){
                    $workoversResult['krs'][$dend] = $workover->work_list;
                }
            }
        }

        return $workoversResult;
    }

    private function getGtms(array $gtms): array
    {
        $gtmsResult = [];

        foreach ($gtms as $gtm) {
            foreach ($gtm['gtm_type'] as $type) {
                $dend = $this->dateFormat($gtm['dend']);
                $gtmsResult[][$this->dateFormat($gtm['dbeg'])] = $type['name_ru'];

                if($dend < date('Y-m-d H:i:sP')){
                    $gtmsResult[][$dend] = $type['name_ru'];
                }
            }
            
        }

        return $gtmsResult;
    }

    private function dateFormat($date) 
    {
        return DateTime::createFromFormat('Y-m-d H:i:sP', $date)->format('Y-m-d');
    }
}
