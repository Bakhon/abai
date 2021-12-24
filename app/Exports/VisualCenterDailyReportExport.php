<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisualCenterDailyReportExport implements FromView,WithStyles
{
    private $dailyParams = array();
    private $monthlyParams = array();
    private $yearlyParams = array();
    private $summary = array();
    private $monthMapping = array(
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь'
    );
    private $missing = array();

    function __construct($dailyParams,$monthlyParams,$yearlyParams,$summary,$missing)
    {
        $this->dailyParams = $dailyParams;
        $this->monthlyParams = $monthlyParams;
        $this->yearlyParams = $yearlyParams;
        $this->summary = $summary;
        $this->missing = $missing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H60')->getFont()->setName('Arial');
        $sheet->setTitle("С учетом доли участия КМГ");
        $sheet->getStyle('A2:H60')->getFont()->setSize(18);
        $sheet->getStyle('A3:H1')->getFont()->setSize(22);
        $sheet->getStyle('A5:H60')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:A60')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H60')->getAlignment()->setIndent(10);
<<<<<<< HEAD
=======
        foreach(array('B10','B30','B49') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setIndent(25);
        }
>>>>>>> 4c3bcc48205fd498b39f4ee143c591950bef1a34
        foreach(array('A4','A23','A43') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setHorizontal('right');
        }
        $sheet->getColumnDimension('A')->setWidth(9.29);
        $sheet->getColumnDimension('B')->setWidth(69.29);
        $sheet->getColumnDimension('C')->setWidth(14.57);
        $sheet->getColumnDimension('D')->setWidth(19.86);
        $sheet->getColumnDimension('E')->setWidth(19.86);
        $sheet->getColumnDimension('F')->setWidth(19.86);
        $sheet->getColumnDimension('G')->setWidth(19.86);
        $sheet->getColumnDimension('H')->setWidth(162);
        $sheet->getPageSetup()->setFitToPage(true);
        foreach(array('A5:H6','A24:H26','A44:H45') as $cell) {
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        $thinBorderStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'black'],
                ],
            ],
        ];

        $sheet->getStyle('A5:H60')->applyFromArray($thinBorderStyleArray);

        $noneBorderStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                    'color' => ['argb' => 'white'],
                ],
            ],
        ];

        foreach(array('A22:H23','A42:H43') as $cell) {
            $sheet->getStyle($cell)->applyFromArray($noneBorderStyleArray);
        }
    }

    public function view(): View
    {
        return view('visualcenter.daily_report_export', [
            'daily' => $this->dailyParams,
            'monthly' => $this->monthlyParams,
            'yearly' => $this->yearlyParams,
            'date' => Carbon::now()->format('d.m.Y'),
            'monthName' => $this->monthMapping[Carbon::now()->month],
            'monthId' => Carbon::now()->month-1,
            'yearId' => Carbon::now()->year,
            'summary' => $this->summary,
            'missing' => $this->missing
        ]);
    }
}
