<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\PipeType;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\Pipes\MapPipe;
use App\Models\Pipes\PipeCoord;
use App\Models\Refs\Cdng;
use App\Models\Refs\HydrocarbonOxidizingBacteria;
use App\Models\Refs\Ngdu;
use App\Models\Refs\OtherObjects;
use App\Models\Refs\SulphateReducingBacteria;
use App\Models\Refs\ThionicBacteria;
use App\Models\Refs\WaterTypeBySulin;
use App\Models\Refs\Zu;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;
use App\Models\Refs\Well;
use App\Models\Refs\Gu;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WaterMeasurementImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const OTHER_OBJECTS = 1;
    const NGDU = 2;
    const CDNG = 3;
    const GU = 4;
    const ZU = 5;
    const WELL = 6;
    const DATE = 7;
    const HYDROCARBONATE_ION = 9;
    const CARBONATE_ION = 10;
    const SULPHATE_ION = 11;
    const CHLORIUM_ION = 12;
    const CALCIUM_ION = 13;
    const MAGNESIUM_ION = 14;
    const POTTASIUM_ION_SODIUM_ION = 15;
    const WATER_DENSITY_20 = 16;
    const PH = 17;
    const MINERALIZATION = 18;
    const TOTAL_HARDNESS = 19;
    const WATER_TYPE_SULIN = 20;
    const CONTENT_PETROLIUM_PRODUCTS = 21;
    const MECHANICAL_IMPURITIES = 22;
    const STRONCIUM_CONTENT = 23;
    const BARUIM_CONTENT = 24;
    const TOTAL_IRON_CONTENT = 25;
    const FERRIC_IRON_CONTENT = 26;
    const FERROUS_IRON_CONTENT = 27;
    const HYDROGEN_SULFIDE_IN_WATER = 28;
    const OXYGEN_IN_WATER = 29;
    const CARBON_DIOXIDE_IN_WATER = 30;
    const SULPHATE_REDUCING_BACTERIA = 39;
    const HYDROCARBON_OXIDIZING_BACTERIA = 40;
    const THIONIC_BACTERIA = 41;

    public function __construct(\App\Console\Commands\Import\WaterMeasurement $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'База_данных') !== false) {
            $this->importMeasurements($collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'База_данных') === false) {
                    throw new \Exception('Success import');
                }

                $this->command->line(' ');
                $this->command->line('----------------------------');
                $this->command->info('sheet name '.$this->sheetName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }
        ];
    }

    public function endColumn(): string
    {
        return 'AQ';
    }

    private function importMeasurements(Collection $collection)
    {
        $collection = $collection->skip(1);

        WaterMeasurement::truncate();

        DB::raw('UPDATE zus SET name = UPPER(name)');

        foreach ($collection as $row) {
            $waterMeasurement = new WaterMeasurement;

            foreach ($row as $index => $value) {
                $row[$index] = str_replace(',','.', $row[$index]);
                $row[$index] = empty($row[$index]) ? null : $row[$index];
            }


            if ($row[self::OTHER_OBJECTS]) {
                $otherObject = OtherObjects::firstOrCreate(
                    [
                        'name' => $row[self::OTHER_OBJECTS]
                    ]
                );
                $waterMeasurement->other_objects_id = $otherObject->id;
            }

            if ($row[self::NGDU]) {
                $ngduName = 'НГДУ-'.str_replace('НГДУ-','', $row[self::NGDU]);
                $this->command->info('NGDU $ngduName '.$ngduName);
                $ngdu = Ngdu::firstWhere('name', $ngduName);
                $waterMeasurement->ngdu_id = $ngdu->id;
            }

            if ($row[self::CDNG]) {
                $this->command->info('CDNG '.$row[self::CDNG]);
                $toRemove = ['ЦДНГ', '-', ' ', '_'];
                $cdngName = 'ЦДНГ-'.str_replace($toRemove,'', $row[self::CDNG]);
                $cdng = Cdng::firstWhere('name', $cdngName);
                if (!$cdng) {
                    dump($cdng);
                    dump($cdngName);
                }
                $waterMeasurement->cdng_id = $cdng->id;
            }

            if ($row[self::GU] && strpos($row[self::GU],'ПС') === false) {
                $this->command->info('GU '.$row[self::GU]);
                $toRemove = ['ГУ', '-'];
                $guName = 'ГУ-'.str_replace($toRemove,'', $row[self::GU]);
                $gu = Gu::firstWhere('name', $guName);
                $waterMeasurement->gu_id = $gu->id;
            }

            if ($row[self::ZU]) {
                $this->command->info('ZU '.$row[self::ZU]);
                $toRemove = ['ZU', '_', '-', 'ЗУ'];
                $zuName = 'ЗУ-'.str_replace($toRemove,'', $row[self::ZU]);

                $zu = Zu::where('gu_id', $gu->id)
                    ->where('ngdu_id', $ngdu->id)
                    ->Where('name', strtoupper($zuName))
                    ->first();

                if ($zu) {
                    $waterMeasurement->zu_id = $zu->id;
                }
            }

            if ($row[self::WELL]) {
                $this->command->info('WELL '.$row[self::WELL]);
                $wellName = $row[self::WELL];
                $toRemove = ['UZN_'];
                if (strpos($row[self::WELL],'KMB_') == -1) {
                    $wellName = 'UZN_'.str_replace($toRemove,'', $row[self::WELL]);
                }

                $well = Well::firstWhere('name', $wellName);
                if ($well) {
                    $waterMeasurement->well_id = $well->id;
                }
            }

            $waterMeasurement->date = Carbon::instance(Date::excelToDateTimeObject($row[self::DATE]))->format('Y-m-d');
            $waterMeasurement->hydrocarbonate_ion = $row[self::HYDROCARBONATE_ION];
            $waterMeasurement->sulphate_ion = $row[self::SULPHATE_ION];
            $waterMeasurement->chlorum_ion = $row[self::CHLORIUM_ION];
            $waterMeasurement->calcium_ion = $row[self::CALCIUM_ION];
            $waterMeasurement->magnesium_ion = $row[self::MAGNESIUM_ION];
            $waterMeasurement->carbonate_ion = $row[self::CARBONATE_ION];
            $waterMeasurement->density = $row[self::WATER_DENSITY_20];
            $waterMeasurement->ph = $row[self::PH];
            $waterMeasurement->mineralization = $row[self::MINERALIZATION];
            $waterMeasurement->total_hardness = $row[self::TOTAL_HARDNESS];

            if ($row[self::WATER_TYPE_SULIN]) {
                $this->command->info('WATER_TYPE_SULIN '.$row[self::WATER_TYPE_SULIN]);
                $waterSulin = WaterTypeBySulin::firstWhere('name', $row[self::WATER_TYPE_SULIN]);
                $waterMeasurement->water_type_by_sulin_id = $waterSulin->id;
            }

            $waterMeasurement->content_of_petrolium_products = $row[self::CONTENT_PETROLIUM_PRODUCTS];
            $waterMeasurement->mechanical_impurities = $row[self::MECHANICAL_IMPURITIES];
            $waterMeasurement->strontium_content = $row[self::STRONCIUM_CONTENT];
            $waterMeasurement->barium_content = $row[self::BARUIM_CONTENT];
            $waterMeasurement->potassium_ion_sodium_ion = $row[self::POTTASIUM_ION_SODIUM_ION];
            $waterMeasurement->total_iron_content = $row[self::TOTAL_IRON_CONTENT];
            $waterMeasurement->ferric_iron_content = $row[self::FERRIC_IRON_CONTENT];
            $waterMeasurement->ferrous_iron_content = $row[self::FERROUS_IRON_CONTENT];
            $waterMeasurement->hydrogen_sulfide = $row[self::HYDROGEN_SULFIDE_IN_WATER];
            $waterMeasurement->oxygen = $row[self::OXYGEN_IN_WATER];
            $waterMeasurement->carbon_dioxide = $row[self::CARBON_DIOXIDE_IN_WATER];

            if ($row[self::SULPHATE_REDUCING_BACTERIA]) {
                $this->command->info('SULPHATE_REDUCING_BACTERIA '.$row[self::SULPHATE_REDUCING_BACTERIA]);
                $sulphateReducingBacteria = SulphateReducingBacteria::firstOrCreate(
                    [
                        'name' => $row[self::SULPHATE_REDUCING_BACTERIA]
                    ]
                );

                $waterMeasurement->sulphate_reducing_bacteria_id = $sulphateReducingBacteria->id;
            }

            if ($row[self::HYDROCARBON_OXIDIZING_BACTERIA]) {
                $this->command->info('HYDROCARBON_OXIDIZING_BACTERIA '.$row[self::HYDROCARBON_OXIDIZING_BACTERIA]);
                $hydrocarbonOxidizingBacteria = HydrocarbonOxidizingBacteria::firstOrCreate(
                    [
                        'name' => $row[self::HYDROCARBON_OXIDIZING_BACTERIA]
                    ]
                );
                $waterMeasurement->hydrocarbon_oxidizing_bacteria_id = $hydrocarbonOxidizingBacteria->id;
            }

            if ($row[self::THIONIC_BACTERIA]) {
                $this->command->info('THIONIC_BACTERIA '.$row[self::THIONIC_BACTERIA]);
                $thionicBacteria = ThionicBacteria::firstOrCreate(
                    [
                        'name' => $row[self::THIONIC_BACTERIA]
                    ]
                );

                $waterMeasurement->thionic_bacteria_id = $thionicBacteria->id;
            }

            $waterMeasurement->cruser_id = 0;
            $waterMeasurement->save();
        }
    }


    public function startRow(): int
    {
        return 8;
    }
}
