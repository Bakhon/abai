<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DruidController;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Gtm;
use App\Models\BigData\Well;
use App\Services\DruidService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GTMController extends Controller
{

    const ACCUM_OIL_PROD_FACT_DATA_FIELD = 'add_prod_12m';
    const ACCUM_OIL_PROD_PLAN_DATA_FIELD = 'plan_add_prod_12m';

    /**
     * @var DruidController
     */
    private $druidController;

    public function __construct()
    {
        $this->middleware('can:paegtm view main')->only('index');
    }

    public function index()
    {
        return view('gtm.gtm');
    }

    public function getAccumOilProd(DruidService $druidService, Request $request):JsonResponse
    {
        $data = $druidService->getAccumOilProd($request->dateStart, $request->dateEnd);
        $result = [];
        $accumOilProdFactData = 0;
        $accumOilProdPlanData = 0;
        foreach ($data as $item) {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $item["dt"] . "-01 00:00:00", new \DateTimeZone("UTC"));
            $date = trans('paegtm.' . $dateTime->format('M')) . ' ' . $dateTime->format('Y');
            $accumOilProdFactData += $item[self::ACCUM_OIL_PROD_FACT_DATA_FIELD] / 1000;
            $accumOilProdPlanData += $item[self::ACCUM_OIL_PROD_PLAN_DATA_FIELD] / 1000;
            $result[] = [
                'date' => $date,
                'accumOilProdFactData' => $accumOilProdFactData,
                'accumOilProdPlanData' => $accumOilProdPlanData,
            ];
        }
        return response()->json($result);
    }

    public function getComparisonIndicators(DruidService $druidService, Request $request):JsonResponse
    {
        $data = $druidService->getComparisonIndicators($request->dateStart, $request->dateEnd);
        $result = [];
        foreach ($data as $item) {
            $result[] = [
                'gtm_kind' => $item['gtm_kind'],
                'wellsCount' => $item['well_uwi'],
                'avgDebitPlan' => $item['plan_add_prod_12m'] / $item['work_time'],
                'avgDebitFact' => $item['add_prod_12m'] / $item['work_time'],
                'add_prod_12m' => $item['add_prod_12m'] / 1000,
                'plan_add_prod_12m' => $item['plan_add_prod_12m'] / 1000,
                'work_time' => $item['work_time'] / $item['well_uwi'] / 12,
            ];
        }
        return response()->json($result);
    }

    public function getAllGtmByDzo(Request $request)
    {
//        $dateStart = Carbon::createFromTimeString('2019-01-01T00:00:00.000Z');
//        $dateEnd = Carbon::createFromTimeString('2020-12-31T23:59:59.000Z');

        $dateStart = $request->has('dateStart') && $request->filled('dateStart') ?
            $request->dateStart :
            '2020-01-01T00:00:00+00:00';

        $dateEnd = $request->has('dateEnd') && $request->filled('dateEnd') ?
              $request->dateEnd :
              '2020-12-31T23:59:59+00:00';

        $dateStart = Carbon::createFromTimeString($dateStart);
        $dateEnd = Carbon::createFromTimeString($dateEnd);

        $sql = 'with
            recursive
            org_hash as (
                select id, id as parent, 1 as level
                from dict.org
                union all
                select o.id, org_hash.parent, level + 1 as level
                from dict.org o
                         join org_hash on org_hash.id = o.parent
                    and o.dbeg <= now()
                    and o.dend > now()
            ),
            wells as (
                select wo.well as id
                from prod.well_org wo
                where wo.org in (select id from org_hash where parent = :org_id)
                  and wo.dbeg <= now()
                  and wo.dend > now()
            ),
            gtms as (
                select wells.id   as well_id,
                   gt.name_ru as gtm_type,
                   gk.name_ru as gtm_kind,
                   gtm.id     as gtm_id,
                   gtm.dbeg   as gtm_dbeg,
                   gtm.dend   as gtm_dend
                from wells
                     join prod.gtm gtm on gtm.well = wells.id
                         and gtm.dbeg <= :date_end
                        and gtm.dend > :date_start
                     join dict.gtm_type gt on gt.id = gtm.gtm_type
                     left join dict.gtm_kind gk on gk.id = gt.gtm_kind
                where gtm.well in (select id from wells)
            )
        select gtm_kind, 0 as plan, count(*) as fact, 0 as percent_1, 0 as percent_2
        from gtms
        group by gtm_kind
        order by 3 desc';

        $res = new Collection(DB::connection('tbd')->select(DB::raw($sql), ['org_id' => $request->dzoId, 'date_start' => $dateStart, 'date_end' => $dateEnd]));

        return response()->json($res);
    }

    public function getMainTableData(Request $request)
    {
        $tableData = [
           [ 'id' => 3,
             'name_ru' => 'АО "Озенмунайгаз"',
             'col_1' => 231,
             'col_2' => 284,
             'col_3' => 53,
             'col_4' => 384,
             'col_5' => 368,
             'col_6' => -16,
             'col_7' => 4724,
             'col_8' => 4687,
             'col_9' => -37,
             'col_10' => 5341,
             'col_11' => 5341,
             'col_12' => 0,
             'selected' => false
           ],
          [ 'id' => 4,
            'name_ru' => 'АО "ЭмбаМунайГаз"',
            'col_1' => 61,
            'col_2' => 74,
            'col_3' => +13,
            'col_4' => 87,
            'col_5' => 120,
            'col_6' => +33,
            'col_7' => 2453,
            'col_8' => 2407,
            'col_9' => -46,
            'col_10' => 2600,
            'col_11' => 2601,
            'col_12' => 0,
            'selected' => false
          ],
          [ 'id' => 112,
            'name_ru' => 'АО "Мангистаумунайгаз"',
            'col_1' => 348,
            'col_2' => 274,
            'col_3' => -74,
            'col_4' => 283,
            'col_5' => 184,
            'col_6' => -100,
            'col_7' => 5273,
            'col_8' => 5496,
            'col_9' => +223,
            'col_10' => 5922,
            'col_11' => 5954,
            'col_12' => +32,
            'selected' => false
          ],
          [ 'id' => 71,
            'name_ru' => 'АО "Каражанбасмунай"',
            'col_1' => 50,
            'col_2' => 46,
            'col_3' => -3,
            'col_4' => 26,
            'col_5' => 24,
            'col_6' => -2,
            'col_7' => 2077,
            'col_8' => 1930,
            'col_9' => -147,
            'col_10' => 2153,
            'col_11' => 2002,
            'col_12' => -150,
            'selected' => false
          ],
          [ 'id' => 149,
            'name_ru' => 'ТОО "СП "Казгермунай"',
            'col_1' => 15,
            'col_2' => 10,
            'col_3' => -5,
            'col_4' => 58,
            'col_5' => 45,
            'col_6' => -13,
            'col_7' => 1465,
            'col_8' => 1482,
            'col_9' => +17,
            'col_10' => 1538,
            'col_11' => 1555,
            'col_12' => +17,
            'selected' => false
          ],
          [ 'id' => 117,
            'name_ru' => 'ТОО "Казтуркмунай"',
            'col_1' => 9,
            'col_2' => 8,
            'col_3' => -1,
            'col_4' => 26,
            'col_5' => 24,
            'col_6' => -2,
            'col_7' => 396,
            'col_8' => 409,
            'col_9' => +13,
            'col_10' => 425,
            'col_11' => 432,
            'col_12' => +7,
            'selected' => false
          ],
          [ 'id' => 126,
            'name_ru' => 'ТОО "Казахойл Актобе"',
            'col_1' => 0,
            'col_2' => 0,
            'col_3' => 0,
            'col_4' => 3,
            'col_5' => 1,
            'col_6' => -2,
            'col_7' => 586,
            'col_8' => 588,
            'col_9' => +2,
            'col_10' => 588,
            'col_11' => 589,
            'col_12' => +1,
            'selected' => false
          ]
        ];

        if ($request->filled('dzoId')) {
            foreach ($tableData as $key => $dzo) {
                if ($dzo['id'] == $request->dzoId) {
                    $tableData[$key]['selected'] = true;
                }
            }
        }

        return response()->json($tableData);
    }
}
