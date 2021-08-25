<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\AbaiprotZu;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ParseOmgNgduWellData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse_omg_ngdu_well_data';

    public $translateLetters = [
        'a' => 'а',
        'b' => 'б',
        'v' => 'в',
        'g' => 'г',
        'd' => 'д',
        'e' => 'е',
        'j' => 'ж'
    ];

    public $guData = [
        'ГУ-107' => [
            'gas' => 106,
            'bsw' => 79
        ],
        'ГУ-22' => [
            'gas' => 120,
            'bsw' => 86
        ],
        'ГУ-24' => [
            'gas' => 101,
            'bsw' => 83
        ],
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse data from abaiprot scheme cmon table zu to omg_ngdu_well table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->title('Starting parse');

        $abaiprotZus = AbaiprotZu::get();
        foreach ($abaiprotZus as $row) {
            $letter = preg_replace('/[^a-zA-Z]/', '', $row->zuid);
            $number = preg_replace('/[^0-9]/', '', $row->zuid);
            $zuName = 'ЗУ-'.$number.$this->translateLetters[$letter];

            $zu = Zu::where('name', $zuName)->first();

            if (!$zu) {
                $message = 'Не найден Zu ' . $row->zuid . ', ЗУ ' .$zuName;
                $this->error($message);

                continue;
            }

            $well = Well::where('otvod', $row->otvod)
                ->where('zu_id', $zu->id)->first();

            if ($well) {
                $gu = Gu::find($well->gu_id);
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->__time)->format('Y-m-d');
                $omgngdu = OmgNGDUWell::firstOrNew([
                    'well_id' => $well->id,
                    'zu_id' => $zu->id,
                    'date' => $date
                ]);

                $omgngdu->daily_fluid_production = $row->debet;
                $omgngdu->daily_water_production = $row->debet_t;
                $omgngdu->daily_oil_production = $row->neft_t;
                $omgngdu->bsw = isset($guData[$gu->name]) ? $guData[$gu->name]['bsw'] : $row->vlash;
                $omgngdu->gas_factor = isset($guData[$gu->name]) ? $guData[$gu->name]['gas'] : $row->gaz;
                $omgngdu->temperature = $row->tempn;
                $omgngdu->sg_oil = 0.86;
                $omgngdu->sg_gas = 0.75;
                $omgngdu->sg_water = 1.03;
                $omgngdu->save();
            }
        }
        $this->info('Parse finished');
    }
}
