<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBigdataGeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bigdata_geos',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('name_short')->nullable();
                $table->unsignedBigInteger('geo_type')->nullable();
                $table->string('field_code')->nullable();
                $table->timestamps();
            }
        );

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bigdata_geos');
    }

    private function seed()
    {
        $geos = [
            [
                'id' => 2000000307,
                'name' => '15',
                'name_short' => '15',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000309,
                'name' => '16',
                'name_short' => '16',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000311,
                'name' => '13',
                'name_short' => '13',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000313,
                'name' => '14',
                'name_short' => '14',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000329,
                'name' => '17',
                'name_short' => '17',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000331,
                'name' => 'SZ',
                'name_short' => 'SZ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000332,
                'name' => '15',
                'name_short' => '15',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000336,
                'name' => 'PARS',
                'name_short' => 'PARS',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000337,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000338,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000339,
                'name' => '15',
                'name_short' => '15',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000340,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000343,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000344,
                'name' => '17',
                'name_short' => '17',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000351,
                'name' => 'HUM',
                'name_short' => 'HUM',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000352,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000363,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000367,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000369,
                'name' => '23',
                'name_short' => '23',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000395,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000396,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000397,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000400,
                'name' => '14',
                'name_short' => '14',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000401,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000402,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000403,
                'name' => '14',
                'name_short' => '14',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000404,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000422,
                'name' => '23',
                'name_short' => '23',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000424,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000425,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000427,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000434,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000443,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000445,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000449,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000450,
                'name' => '17',
                'name_short' => '17',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000451,
                'name' => 'Восточный кар',
                'name_short' => 'Восточный кар',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000452,
                'name' => '13',
                'name_short' => '13',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000453,
                'name' => '14',
                'name_short' => '14',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000454,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000455,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000456,
                'name' => '15',
                'name_short' => '15',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000457,
                'name' => '23',
                'name_short' => '23',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000458,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000459,
                'name' => '25',
                'name_short' => '25',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000461,
                'name' => '17',
                'name_short' => '17',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000462,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000464,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000465,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000002496,
                'name' => 'Карамандыбас',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KMB'
            ],
            [
                'id' => 2000002521,
                'name' => 'Узень',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UZN'
            ],
            [
                'id' => 2000003402,
                'name' => 'Западный Кар',
                'name_short' => 'ZAP KAR',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000003403,
                'name' => '13',
                'name_short' => '13',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003404,
                'name' => '14',
                'name_short' => '14',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003405,
                'name' => '15',
                'name_short' => '15',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003406,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003407,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003408,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003409,
                'name' => '23',
                'name_short' => '23',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003410,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000003411,
                'name' => '25',
                'name_short' => '25',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000760,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000761,
                'name' => 'J3_I-CE',
                'name_short' => 'J3_I-CE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000764,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000765,
                'name' => 'J3_II-CE-1',
                'name_short' => 'J3_II-CE-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000766,
                'name' => 'J3_II-CE-2',
                'name_short' => 'J3_II-CE-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000768,
                'name' => 'J3_I+II',
                'name_short' => 'J3_I+II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000769,
                'name' => 'J3_aL.h',
                'name_short' => 'J3_aL.h',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000780,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000782,
                'name' => 'J3_III-CE',
                'name_short' => 'J3_III-CE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000783,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000785,
                'name' => 'J2_IV',
                'name_short' => 'J2_IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000786,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000787,
                'name' => 'J2_V',
                'name_short' => 'J2_V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000794,
                'name' => 'VI+VII',
                'name_short' => 'VI+VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000795,
                'name' => 'T_4',
                'name_short' => 'T_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000820,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000826,
                'name' => 'I alb+sen',
                'name_short' => 'I alb+sen',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000827,
                'name' => 'VI apt',
                'name_short' => 'VI apt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000828,
                'name' => 'V alb',
                'name_short' => 'V alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000829,
                'name' => 'III alb+sen',
                'name_short' => 'III alb+sen',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000830,
                'name' => 'II alb+sen',
                'name_short' => 'II alb+sen',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000831,
                'name' => 'II промежуточный',
                'name_short' => 'II промежуточный',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000832,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000833,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000836,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000838,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000839,
                'name' => 'apt_ne',
                'name_short' => 'apt_ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000840,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000842,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000848,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000849,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000850,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000851,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000852,
                'name' => 'J2+3',
                'name_short' => 'J2+3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000853,
                'name' => 'IXJ2',
                'name_short' => 'IXJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000855,
                'name' => 'J2+1',
                'name_short' => 'J2+1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000860,
                'name' => 'I ne',
                'name_short' => 'I ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000861,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000866,
                'name' => 'J1+2',
                'name_short' => 'J1+2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000867,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000870,
                'name' => 'p',
                'name_short' => 'p',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000871,
                'name' => 'Возвратный',
                'name_short' => 'Возвратный',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000873,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000877,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000878,
                'name' => 'IIIaI',
                'name_short' => 'IIIaI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000879,
                'name' => 'IIIapt',
                'name_short' => 'IIIapt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000880,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000882,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000883,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000885,
                'name' => 'pt',
                'name_short' => 'pt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000886,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000887,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000888,
                'name' => 'J1+2',
                'name_short' => 'J1+2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000907,
                'name' => 'pt',
                'name_short' => 'pt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000908,
                'name' => 'J3+2',
                'name_short' => 'J3+2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000911,
                'name' => 'XJ',
                'name_short' => 'XJ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000915,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000916,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000918,
                'name' => 'pt',
                'name_short' => 'pt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000929,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000938,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000940,
                'name' => 'I промежуточный',
                'name_short' => 'I промежуточный',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000941,
                'name' => 'J1_185',
                'name_short' => 'J1_185',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000942,
                'name' => 'graben',
                'name_short' => 'graben',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000943,
                'name' => 'II ne',
                'name_short' => 'II ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000958,
                'name' => 'alb+sen',
                'name_short' => 'alb+sen',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000959,
                'name' => 'apt',
                'name_short' => 'apt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000960,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000000962,
                'name' => 'XJ2',
                'name_short' => 'XJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000963,
                'name' => 'p',
                'name_short' => 'p',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000964,
                'name' => 'pt',
                'name_short' => 'pt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000967,
                'name' => 'XIJ',
                'name_short' => 'XIJ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000977,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000000981,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000001001,
                'name' => 'K1al',
                'name_short' => 'K1al',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000002481,
                'name' => 'Аккудук',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKD'
            ],
            [
                'id' => 3000002482,
                'name' => 'Акингень',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKG'
            ],
            [
                'id' => 3000002483,
                'name' => 'Актюбе',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ATB'
            ],
            [
                'id' => 3000002484,
                'name' => 'Алтыколь',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ATK'
            ],
            [
                'id' => 3000002485,
                'name' => 'Бек-Беке',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BBK'
            ],
            [
                'id' => 3000002486,
                'name' => 'С.Балгимбаев',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BLG'
            ],
            [
                'id' => 3000002487,
                'name' => 'Байчунас',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BNS'
            ],
            [
                'id' => 3000002488,
                'name' => 'Ботахан',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BTN'
            ],
            [
                'id' => 3000002489,
                'name' => 'Досмухамбетовское',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'DMB'
            ],
            [
                'id' => 3000002490,
                'name' => 'Доссор',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'DSR'
            ],
            [
                'id' => 3000002491,
                'name' => 'Гран',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'GRN'
            ],
            [
                'id' => 3000002492,
                'name' => 'Искине',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'IKN'
            ],
            [
                'id' => 3000002493,
                'name' => 'Б.Жоламанов',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'JLM'
            ],
            [
                'id' => 3000002494,
                'name' => 'Кошкар',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KKR'
            ],
            [
                'id' => 3000002495,
                'name' => 'Кульсары',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KLR'
            ],
            [
                'id' => 3000002497,
                'name' => 'Кенбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KNB'
            ],
            [
                'id' => 3000002498,
                'name' => 'Карачаганак',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KNK'
            ],
            [
                'id' => 3000002499,
                'name' => 'Кондыбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KON'
            ],
            [
                'id' => 3000002500,
                'name' => 'Карсак',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KRK'
            ],
            [
                'id' => 3000002501,
                'name' => 'Каратон',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KRT'
            ],
            [
                'id' => 3000002502,
                'name' => 'Кисимбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KSB'
            ],
            [
                'id' => 3000002503,
                'name' => 'Косшагил',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KSG'
            ],
            [
                'id' => 3000002504,
                'name' => 'Кошкимбет',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KSH'
            ],
            [
                'id' => 3000002505,
                'name' => 'Комсомольск',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KSM'
            ],
            [
                'id' => 3000002506,
                'name' => 'Макат',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'MKT'
            ],
            [
                'id' => 3000002507,
                'name' => 'С.Нуржанов',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'NRG'
            ],
            [
                'id' => 3000002508,
                'name' => 'Ровное',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'RVN'
            ],
            [
                'id' => 3000002509,
                'name' => 'Сагиз',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SGZ'
            ],
            [
                'id' => 3000002510,
                'name' => 'С.Жолдыбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SJB'
            ],
            [
                'id' => 3000002511,
                'name' => 'Северный Котыртас',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SKS'
            ],
            [
                'id' => 3000002512,
                'name' => 'Толес',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'TLS'
            ],
            [
                'id' => 3000002513,
                'name' => 'Терен-Узек',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'TNU'
            ],
            [
                'id' => 3000002514,
                'name' => 'Блок Тайсоган',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'TSG'
            ],
            [
                'id' => 3000002515,
                'name' => 'Танатар Южный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'TTR'
            ],
            [
                'id' => 3000002516,
                'name' => 'Тажигали',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'TZH'
            ],
            [
                'id' => 3000002517,
                'name' => 'УАЗ',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UAZ'
            ],
            [
                'id' => 3000002518,
                'name' => 'Ю-В Камышитовое',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UVK'
            ],
            [
                'id' => 3000002519,
                'name' => 'Новобогатинск Ю-В',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UVN'
            ],
            [
                'id' => 3000002520,
                'name' => 'Ю-З Камышитовое',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UZK'
            ],
            [
                'id' => 3000002522,
                'name' => 'Восточный Молдабек',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'VMB'
            ],
            [
                'id' => 3000002523,
                'name' => 'В.Макат',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'VMT'
            ],
            [
                'id' => 3000002524,
                'name' => 'Забурунье',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ZBN'
            ],
            [
                'id' => 3000002525,
                'name' => 'Жанаталап',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ZHT'
            ],
            [
                'id' => 3000002526,
                'name' => 'Западная Прорва',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ZPV'
            ],
            [
                'id' => 3000014229,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014232,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014236,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014237,
                'name' => 'J-II',
                'name_short' => 'J-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014253,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014255,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014258,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014260,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014269,
                'name' => 'apt_ne_2',
                'name_short' => 'apt_ne_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014277,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014280,
                'name' => 'II NE',
                'name_short' => 'II NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014281,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014283,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014286,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014289,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014290,
                'name' => 'apt_ne',
                'name_short' => 'apt_ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014292,
                'name' => 'neogen',
                'name_short' => 'neogen',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014294,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014298,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014302,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014304,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014305,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014309,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014313,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014314,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014318,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014321,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014322,
                'name' => 'III PT',
                'name_short' => 'III PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014323,
                'name' => 'II  PT',
                'name_short' => 'II  PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014331,
                'name' => 'I NE',
                'name_short' => 'I NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014332,
                'name' => 'neogen',
                'name_short' => 'neogen',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014339,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014353,
                'name' => 'apt_ne',
                'name_short' => 'apt_ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014356,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014359,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014360,
                'name' => 'VIII J2',
                'name_short' => 'VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014373,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014374,
                'name' => 'APT',
                'name_short' => 'APT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014375,
                'name' => 'Alb2  пл.1',
                'name_short' => 'Alb2  пл.1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014405,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014406,
                'name' => 'I alb',
                'name_short' => 'I alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014407,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014408,
                'name' => 'II_apt_ne',
                'name_short' => 'II_apt_ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014409,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014411,
                'name' => 'VIII',
                'name_short' => 'VIII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014412,
                'name' => 'XII_J2',
                'name_short' => 'XII_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014413,
                'name' => 'IX',
                'name_short' => 'IX',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014415,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014416,
                'name' => 'VIII_J2',
                'name_short' => 'VIII_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014431,
                'name' => 'SAN_OP',
                'name_short' => 'SAN_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014432,
                'name' => 'SAN_CZP',
                'name_short' => 'SAN_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014466,
                'name' => 'III_J2',
                'name_short' => 'III_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014483,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014484,
                'name' => 'XI_J2',
                'name_short' => 'XI_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014494,
                'name' => 'XVI_PT',
                'name_short' => 'XVI_PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014503,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014509,
                'name' => 'VII_J2',
                'name_short' => 'VII_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014512,
                'name' => 'X_J2',
                'name_short' => 'X_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014513,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014514,
                'name' => 'V PT',
                'name_short' => 'V PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014515,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014516,
                'name' => 'III J2',
                'name_short' => 'III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014517,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014518,
                'name' => 'II J2',
                'name_short' => 'II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014519,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014520,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014521,
                'name' => 'II J2',
                'name_short' => 'II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014522,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014527,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014528,
                'name' => 'Ne',
                'name_short' => 'Ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014533,
                'name' => 'VII-VIII',
                'name_short' => 'VII-VIII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014534,
                'name' => 'T_3',
                'name_short' => 'T_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014536,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014537,
                'name' => 'J3_VIII_3',
                'name_short' => 'J3_VIII_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014544,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014545,
                'name' => 'J3_VIII_2',
                'name_short' => 'J3_VIII_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014549,
                'name' => 'T_2',
                'name_short' => 'T_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014551,
                'name' => 'T_6',
                'name_short' => 'T_6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014833,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014835,
                'name' => 'VII J2',
                'name_short' => 'VIIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014837,
                'name' => 'IV в/п',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014839,
                'name' => 'apt_ne',
                'name_short' => 'apt-neok',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014841,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014843,
                'name' => 'IV J2 (западное поле)',
                'name_short' => 'IVJ2-зап.поле',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014845,
                'name' => 'V+VI J2',
                'name_short' => 'V+VIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014847,
                'name' => 'VIII+IX J2',
                'name_short' => 'VIII+IXJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014857,
                'name' => 'III alb',
                'name_short' => 'III-alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014859,
                'name' => 'I alb',
                'name_short' => 'I-alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014861,
                'name' => 'II ',
                'name_short' => 'II ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014863,
                'name' => 'II J2',
                'name_short' => 'J2-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014873,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014875,
                'name' => 'J1 (северо-западное поле)',
                'name_short' => 'J1-сев-запполе',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014877,
                'name' => 'I ',
                'name_short' => 'I ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014879,
                'name' => 'J1(юго-западное поле)',
                'name_short' => 'J1-юго-запполе',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014881,
                'name' => 'J2 (юго-западное поле)',
                'name_short' => 'J2-юго-запполе',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014883,
                'name' => 'J3 (юго-западное поле)',
                'name_short' => 'J3-юго-запполе',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014885,
                'name' => 'II ',
                'name_short' => 'II ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014887,
                'name' => 'alb+sen (северо-западное поле)',
                'name_short' => 'a+c',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014895,
                'name' => 'IV alb (восточное поле)',
                'name_short' => 'IV-alb-в/п',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014897,
                'name' => 'IV alb (западное поле)',
                'name_short' => 'IV-alb-з/п',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014909,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014911,
                'name' => 'k1 II nc',
                'name_short' => 'K1 II nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014917,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014919,
                'name' => 'VII J2 пласт 2',
                'name_short' => 'VIIJ2пл.2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014921,
                'name' => 'VІІІ J2',
                'name_short' => 'VІІІJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014923,
                'name' => 'II NE пл."А+Б"',
                'name_short' => 'II nc пл."А+Б"',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014925,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014927,
                'name' => 'VІІІ+ІХ J2',
                'name_short' => 'VІІІ+ІХJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014929,
                'name' => 'VІІІ J2',
                'name_short' => 'VІІІJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014935,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014937,
                'name' => 'J3_VIII_2',
                'name_short' => 'J3YIII2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014939,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014941,
                'name' => 'J3_VIII_5',
                'name_short' => 'J3YIII5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014943,
                'name' => 'J3_VIII_3',
                'name_short' => 'J3YIII3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014945,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000014947,
                'name' => 'VLG',
                'name_short' => 'K1-валанж',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000014992,
                'name' => 'Дюсеке',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'DSK'
            ],
            [
                'id' => 3000014994,
                'name' => 'Койкара',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KRA'
            ],
            [
                'id' => 3000014995,
                'name' => 'Северный Дюсеке',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SDK'
            ],
            [
                'id' => 3000014996,
                'name' => 'Северно-Западный Кульсары',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SZK'
            ],
            [
                'id' => 3000015015,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015035,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015037,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015039,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015055,
                'name' => 'M-III+J-1',
                'name_short' => 'M-III+J-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015077,
                'name' => 'J-IV+V',
                'name_short' => 'J-IV+V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015095,
                'name' => 'J-VI+VII',
                'name_short' => 'J-VI+VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015115,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015117,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015135,
                'name' => 'J-I-II',
                'name_short' => 'J-I-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015155,
                'name' => 'J-III',
                'name_short' => 'J-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015176,
                'name' => 'J2',
                'name_short' => 'J2_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015181,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015182,
                'name' => 'M-I',
                'name_short' => 'K1_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015183,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015184,
                'name' => 'М-II',
                'name_short' => 'М-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015194,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015214,
                'name' => 'возвратный',
                'name_short' => 'ВОЗВРАТНЫЙ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015215,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015217,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015218,
                'name' => 'возвратный',
                'name_short' => 'ВОЗВРАТНЫЙ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015221,
                'name' => 'T_IV',
                'name_short' => 'T_IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015222,
                'name' => 'T_I',
                'name_short' => 'T_I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015223,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015224,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015225,
                'name' => 'J_III',
                'name_short' => 'J_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015226,
                'name' => 'J_4',
                'name_short' => 'J_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015234,
                'name' => 'J2_IX_1',
                'name_short' => 'J2_IX_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015235,
                'name' => 'J3_VIII_4',
                'name_short' => 'J3_VIII_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015236,
                'name' => 'J3_VIII_1',
                'name_short' => 'J3_VIII_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015238,
                'name' => 'J3_VIII_1+2 ',
                'name_short' => 'J3_VIII_1+2 ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015239,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015240,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015241,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015242,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015243,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015244,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015245,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015247,
                'name' => 'APT_NE_2',
                'name_short' => 'APT_NE_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015248,
                'name' => 'APT_NE_5',
                'name_short' => 'APT_NE_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015249,
                'name' => 'J_V',
                'name_short' => 'J_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015251,
                'name' => 'SR_ALB_5',
                'name_short' => 'SR_ALB_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015252,
                'name' => 'BH_ALB_5',
                'name_short' => 'BH_ALB_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015253,
                'name' => 'NZ_ALB_5',
                'name_short' => 'NZ_ALB_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015254,
                'name' => 'J3_VIII_1',
                'name_short' => 'J3_VIII_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015255,
                'name' => 'J3_VIII_2',
                'name_short' => 'J3_VIII_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015256,
                'name' => 'J3_VIII_3',
                'name_short' => 'J3_VIII_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015257,
                'name' => 'J3_VIII_1+2',
                'name_short' => 'J3_VIII_1+2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015258,
                'name' => 'J2_IX_2',
                'name_short' => 'J2_IX_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015259,
                'name' => 'J2_XIV',
                'name_short' => 'J2_XIV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015274,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015275,
                'name' => 'I alb',
                'name_short' => '1ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015276,
                'name' => 'II alb',
                'name_short' => '2ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015277,
                'name' => 'промежуточный',
                'name_short' => 'PROM',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015278,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015279,
                'name' => 'ne I',
                'name_short' => 'NE I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015280,
                'name' => 'III ne',
                'name_short' => 'NE3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015281,
                'name' => 'II ne пласт 2',
                'name_short' => 'NEII_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015294,
                'name' => 'II ne пласт 1',
                'name_short' => 'NEII_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015295,
                'name' => 'apt_ne',
                'name_short' => 'APT_NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015314,
                'name' => 'T-3',
                'name_short' => 'T-3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015315,
                'name' => 'T_2',
                'name_short' => 'T_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015316,
                'name' => 'T_5',
                'name_short' => 'T_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015317,
                'name' => 'I (Западное поле)',
                'name_short' => '(ЗАПАДНОЕ ПОЛЕ)',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015318,
                'name' => 'II (западное поле)',
                'name_short' => 'II (ЗАПАДНОЕ ПОЛЕ)',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015319,
                'name' => 'J2_V',
                'name_short' => 'J2_V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015320,
                'name' => 'T_2',
                'name_short' => 'T_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015321,
                'name' => 'T_4',
                'name_short' => 'T_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015322,
                'name' => 'T_5',
                'name_short' => 'T_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015326,
                'name' => 'J-I-II-III',
                'name_short' => 'J-I-II-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015327,
                'name' => 'J-IV-VI',
                'name_short' => 'J-IV-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015328,
                'name' => 'T-I',
                'name_short' => 'T-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015332,
                'name' => 'k1 пром.',
                'name_short' => 'K1 ПРОМ.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015334,
                'name' => 'k1 a-nc',
                'name_short' => 'K1 A-NC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015336,
                'name' => 'k1 I nc',
                'name_short' => 'K1 I NC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015339,
                'name' => 'k1 a-nc+Inc',
                'name_short' => 'K1 A-NC+INC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015340,
                'name' => ' I+II',
                'name_short' => 'БЛОК I+II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015341,
                'name' => 'I-ОП',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015342,
                'name' => 'ICEN_OP',
                'name_short' => 'ICEN_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015343,
                'name' => 'II-ОП',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015344,
                'name' => 'IICEN_OP',
                'name_short' => 'IICEN_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015345,
                'name' => 'III-ОП',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015346,
                'name' => 'III ALB_OP',
                'name_short' => 'III ALB_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015347,
                'name' => 'k1 пром.+II nc',
                'name_short' => 'K1 ПРОМ.+ II NC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015348,
                'name' => 'IV-ОП',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015349,
                'name' => 'k1 a nc+I nc+IInc',
                'name_short' => 'K1 ANC+INC+IINC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015350,
                'name' => 'IV ALB_OP',
                'name_short' => 'IV ALB_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015351,
                'name' => 'k1 nc+I nc+пром.',
                'name_short' => 'K1 NC+I NC+ПРОМ.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015352,
                'name' => 'k1 I nc+пром.',
                'name_short' => 'K1 I NC+ ПРОМ.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015353,
                'name' => 'k1 nc+II nc',
                'name_short' => 'K1 NC+II NC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015354,
                'name' => 'V-ОП',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015358,
                'name' => 'I-СЗП',
                'name_short' => 'I-СЗП',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015359,
                'name' => 'I CEN_CZP',
                'name_short' => 'I CEN_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015360,
                'name' => 'II-СЗП',
                'name_short' => 'II-СЗП',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015361,
                'name' => 'II CEN_CZP',
                'name_short' => 'II CEN_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015362,
                'name' => 'III-СЗП',
                'name_short' => 'III-СЗП ',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015364,
                'name' => 'III ALB_CZP',
                'name_short' => 'III ALB_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015365,
                'name' => 'IV ALB_CZP',
                'name_short' => 'IV ALB_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015366,
                'name' => 'IV-СЗП',
                'name_short' => 'IV-СЗП',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015367,
                'name' => 'V NZ_ALB_CZP',
                'name_short' => 'V NZ_ALB_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015368,
                'name' => 'V-СЗП',
                'name_short' => 'V-СЗП',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015369,
                'name' => 'VII NZ_NE_CZP',
                'name_short' => 'VIINZ_NE_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015370,
                'name' => 'APT_OP',
                'name_short' => 'APT_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015373,
                'name' => 'K1-VLG',
                'name_short' => 'K1-VLG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015374,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015378,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015379,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015380,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015381,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015382,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015383,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015384,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015385,
                'name' => 'VIII',
                'name_short' => 'VIII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015386,
                'name' => 'IX',
                'name_short' => 'IX',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015387,
                'name' => 'alb',
                'name_short' => 'АЛЬБ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015388,
                'name' => 'I ne',
                'name_short' => 'НЕОКОМ-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015389,
                'name' => 'II ne',
                'name_short' => 'НЕОКОМ-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015390,
                'name' => 'lit',
                'name_short' => 'ЛИТЕРНЫЙ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015391,
                'name' => 'I J2',
                'name_short' => '1J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015392,
                'name' => 'II J2',
                'name_short' => '2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015393,
                'name' => 'ne_czp',
                'name_short' => 'NE_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015394,
                'name' => 'J_czp',
                'name_short' => 'J_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015395,
                'name' => 'pt_czp',
                'name_short' => 'РТ_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015396,
                'name' => 'k1 nc+II nc',
                'name_short' => 'K1 NC+II NC',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015397,
                'name' => 'Х',
                'name_short' => 'Х',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015398,
                'name' => '1J',
                'name_short' => '1J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015401,
                'name' => '2J',
                'name_short' => '2J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015402,
                'name' => 'J_BP',
                'name_short' => 'J_BP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015404,
                'name' => 'I',
                'name_short' => 'IF',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015405,
                'name' => 'T_III',
                'name_short' => 'T_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015406,
                'name' => 'T_II',
                'name_short' => 'T_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015407,
                'name' => 'ALB_2',
                'name_short' => 'ALB_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015408,
                'name' => 'NZ_NE_CZP',
                'name_short' => 'NZ_NE_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015409,
                'name' => 'APT_CZP',
                'name_short' => 'APT_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015410,
                'name' => 'NZ_ALB_CZP',
                'name_short' => 'NZ_ALB_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015414,
                'name' => 'T-V',
                'name_short' => 'T-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015415,
                'name' => 'T-IV-V',
                'name_short' => 'T-IV-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015416,
                'name' => 'T-VI',
                'name_short' => 'T-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015417,
                'name' => 'J-I',
                'name_short' => 'J-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015418,
                'name' => 'T-V-VII',
                'name_short' => 'T-V-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015419,
                'name' => 'apt_ne (сев.поле)',
                'name_short' => 'АПТ-НЕОК (СЕВ.П)',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015420,
                'name' => 'apt_ne (юж.поле)',
                'name_short' => 'APT_NE (ЮЖ.П)',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015423,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015424,
                'name' => 'V+VI+VII PT',
                'name_short' => 'V+VI+VII PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015425,
                'name' => 'V+VI PT',
                'name_short' => 'V+VI PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015426,
                'name' => 'IV PT',
                'name_short' => 'IV PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015427,
                'name' => 'VII+VIII PT',
                'name_short' => 'VII+VIII PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015429,
                'name' => 'J-II',
                'name_short' => 'J-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015430,
                'name' => 'J-I',
                'name_short' => 'J-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015431,
                'name' => 'VI PT',
                'name_short' => 'VI PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015432,
                'name' => 'J-I+II',
                'name_short' => 'J-I+II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015433,
                'name' => 'J-V',
                'name_short' => 'J-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015434,
                'name' => 'J-VI',
                'name_short' => 'J-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015435,
                'name' => 'J-VII',
                'name_short' => 'J-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015437,
                'name' => 'I+II NE',
                'name_short' => 'I+II NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015438,
                'name' => 'J-IV',
                'name_short' => 'J-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015439,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015440,
                'name' => 'IV+III',
                'name_short' => 'III+IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015441,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015442,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015443,
                'name' => 'II+IV J2',
                'name_short' => 'II+IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015444,
                'name' => 'I+II J2',
                'name_short' => 'I+II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015445,
                'name' => 'I+II+VI J2',
                'name_short' => 'I+II+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015446,
                'name' => 'II+VI J2',
                'name_short' => 'II+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015447,
                'name' => 'II+III+IV+VI J2',
                'name_short' => 'II+III+IV+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015449,
                'name' => 'VI J2',
                'name_short' => 'VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015450,
                'name' => 'V+VI J2',
                'name_short' => 'V+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015451,
                'name' => 'VI+VIa J2',
                'name_short' => 'VI+VIA J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015452,
                'name' => 'VI+VII J2',
                'name_short' => 'VI+VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015453,
                'name' => 'VII J2',
                'name_short' => 'VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015454,
                'name' => 'VIII J2',
                'name_short' => 'VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015455,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015456,
                'name' => 'II+III',
                'name_short' => 'II+III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015457,
                'name' => 'II+IV',
                'name_short' => 'II+IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015458,
                'name' => 'III+IV',
                'name_short' => 'III+IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015459,
                'name' => 'III+V',
                'name_short' => 'III+V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015460,
                'name' => 'IV+V',
                'name_short' => 'IV+V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015461,
                'name' => 'IV+VI',
                'name_short' => 'IV+VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015462,
                'name' => 'V+VI',
                'name_short' => 'V+VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015463,
                'name' => 'alb 3',
                'name_short' => 'ALB3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015465,
                'name' => 'alb 2',
                'name_short' => 'ALB2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015466,
                'name' => 'alb 3+alb 2',
                'name_short' => 'ALB3+ALB2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015468,
                'name' => 'I+II',
                'name_short' => 'I+II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015469,
                'name' => 'III+I',
                'name_short' => 'III+I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015470,
                'name' => 'II+III',
                'name_short' => 'II+III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015474,
                'name' => 'II ALB пласт1',
                'name_short' => 'II ALB ПЛ.1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015475,
                'name' => 'II ALB пласт2',
                'name_short' => 'II ALB ПЛ.2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015478,
                'name' => 'II ALB пласт1+2',
                'name_short' => 'II ALB ПЛ.1+2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015479,
                'name' => 'III ALB',
                'name_short' => 'III ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015480,
                'name' => 'II ALB пласт1+III ALB',
                'name_short' => 'II ALB ПЛ.1+III ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015481,
                'name' => 'II ALB пласт2+III ALB',
                'name_short' => 'II ALB ПЛ.2+III ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015482,
                'name' => 'II ALB пласт1+2+III ALB',
                'name_short' => 'II ALB ПЛ.1+2 + III ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015483,
                'name' => 'III ALB+II+III J2',
                'name_short' => 'III ALB+II+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015484,
                'name' => 'III ALB+VI J2 ',
                'name_short' => 'III ALB+VI J2 ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015486,
                'name' => 'V+VI J2+III ALB',
                'name_short' => 'V + VI J2 + III ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015487,
                'name' => 'IV ne+I1 J2 ',
                'name_short' => 'IV NE + I1 J2 ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015494,
                'name' => 'III ne',
                'name_short' => 'III NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015495,
                'name' => 'IV ne',
                'name_short' => 'IV NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015496,
                'name' => 'apt_ne+IV ne',
                'name_short' => 'APT_NE+IV NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015497,
                'name' => 'apt_ne+III ne',
                'name_short' => 'APT_NE+III NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015498,
                'name' => 'III+IV ne',
                'name_short' => 'III NE+IV NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015499,
                'name' => 'apt_ne+III ne+I1+I2 J2',
                'name_short' => 'APT_NE+III NE+I1+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015500,
                'name' => 'apt_ne+IV ne+I1+I2 J2',
                'name_short' => 'APT_NE+IV NE+I1+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015501,
                'name' => 'III+IV ne+I1 J2',
                'name_short' => 'III NE+IV NE+I1J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015502,
                'name' => 'apt_ne+IV ne+I1 J2',
                'name_short' => 'APT_NE+IV NE+I1J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015503,
                'name' => 'IV ne+I1+I2 J2',
                'name_short' => 'IV NE + I1+  I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015504,
                'name' => 'IV ne+I2 J2',
                'name_short' => 'IV NE+ I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015505,
                'name' => 'I1 J2',
                'name_short' => 'I1J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015506,
                'name' => 'I2 J2',
                'name_short' => 'I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015507,
                'name' => 'I3 J2',
                'name_short' => 'I3J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015508,
                'name' => 'I1+I2 J2',
                'name_short' => 'I1+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015509,
                'name' => 'I1+I2+I3 J2',
                'name_short' => 'I1+I2+I3J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015510,
                'name' => 'I2+I3 J2',
                'name_short' => 'I2+I3J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015512,
                'name' => 'apt_ne+I4 J2',
                'name_short' => 'APT_NE+I4J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015513,
                'name' => 'II J2',
                'name_short' => 'IIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015514,
                'name' => 'III J2',
                'name_short' => 'IIIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015515,
                'name' => 'II+III J2',
                'name_short' => 'II+IIIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015516,
                'name' => 'I1+I2+III J2',
                'name_short' => 'I1+I2+IIIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015518,
                'name' => 'I5 J2+V J2',
                'name_short' => 'I5+J2+VJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015519,
                'name' => 'I2+I3+I4 J2',
                'name_short' => 'I2+I3+I4J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015520,
                'name' => 'I3+I4 J2',
                'name_short' => 'I3+I4J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015523,
                'name' => 'I2+I4 J2',
                'name_short' => 'I2+I4J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015524,
                'name' => 'I3+I5 J2',
                'name_short' => 'I3+I5J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015525,
                'name' => 'I4 J2',
                'name_short' => 'I4J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015526,
                'name' => 'I5 J2',
                'name_short' => 'I5J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015527,
                'name' => 'I4+I5 J2',
                'name_short' => 'I4+I5J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015528,
                'name' => 'I+II J2',
                'name_short' => 'I+IIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015529,
                'name' => 'IV+V J2',
                'name_short' => 'IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015530,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015531,
                'name' => 'V+VI J2',
                'name_short' => 'V+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015532,
                'name' => 'I+III J2',
                'name_short' => 'I+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015533,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015534,
                'name' => 'apt',
                'name_short' => 'APT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015535,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015536,
                'name' => 'I5+II J2',
                'name_short' => 'I5+IIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015537,
                'name' => 'IV+VI J2',
                'name_short' => 'IV+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015538,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015539,
                'name' => 'IX J2',
                'name_short' => 'IX J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015540,
                'name' => 'VIII',
                'name_short' => 'VIII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015541,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015542,
                'name' => 'III+IV J2',
                'name_short' => 'III+IVJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015543,
                'name' => 'I+II+IV+V J2',
                'name_short' => 'I+II+IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015544,
                'name' => 'II J2',
                'name_short' => 'II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015545,
                'name' => 'III+IV+V J2',
                'name_short' => 'III+IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015546,
                'name' => 'I+III+IV+V J2',
                'name_short' => 'I+III+IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015547,
                'name' => 'III+V+VI J2',
                'name_short' => 'III+V+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015548,
                'name' => 'II+IV J2',
                'name_short' => 'II+IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015549,
                'name' => 'I+III J2',
                'name_short' => 'I+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015550,
                'name' => 'II J2',
                'name_short' => 'II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015551,
                'name' => 'I+V J2',
                'name_short' => 'I+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015552,
                'name' => 'II+V J2',
                'name_short' => 'II+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015553,
                'name' => 'ne',
                'name_short' => 'NEO',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015554,
                'name' => 'VI J2',
                'name_short' => 'VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015555,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015556,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015557,
                'name' => 'VI+VII J2',
                'name_short' => 'VI+VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015558,
                'name' => 'I+II+V J2',
                'name_short' => 'I+II+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015559,
                'name' => 'I+II J2',
                'name_short' => 'I+II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015560,
                'name' => 'II+III+IV J2',
                'name_short' => 'II+III+IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015561,
                'name' => 'I+II+III J2',
                'name_short' => 'I+II+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015562,
                'name' => 'II+III J2',
                'name_short' => 'II+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015574,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015575,
                'name' => 'II J2',
                'name_short' => 'II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015576,
                'name' => 'III J2',
                'name_short' => 'III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015577,
                'name' => 'I+II J2',
                'name_short' => 'I+II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015578,
                'name' => 'II+III J2',
                'name_short' => 'II+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015579,
                'name' => 'III+IV J2',
                'name_short' => 'III+IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015580,
                'name' => 'III+IV+V J2',
                'name_short' => 'III+IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015581,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015582,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015583,
                'name' => 'VI J2',
                'name_short' => 'VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015584,
                'name' => 'VII J2',
                'name_short' => 'VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015585,
                'name' => 'IV+V J2',
                'name_short' => 'IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015586,
                'name' => 'IV+V+VI J2',
                'name_short' => 'IV+V+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015587,
                'name' => 'V+VI J2',
                'name_short' => 'V+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015588,
                'name' => 'V+VI+VII J2',
                'name_short' => 'V+VI+VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015589,
                'name' => 'VI+VII J2',
                'name_short' => 'VI+VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015590,
                'name' => 'VII J2 пласт 1',
                'name_short' => 'VII J2 ПЛ.1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015591,
                'name' => 'VII J2 пласт1+2',
                'name_short' => 'VII J2 ПЛ.1+2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015592,
                'name' => 'VII J2 пласт1+VIII J2',
                'name_short' => 'VII J2 ПЛ.1+VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015593,
                'name' => 'VII J2 пласт2+VIII J2',
                'name_short' => 'VII J2 ПЛ.2+VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015594,
                'name' => 'VII J2 пласт1+2 +VIII J2',
                'name_short' => 'VII J2 ПЛ.1+2 +VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015595,
                'name' => 'K1a',
                'name_short' => 'K1A',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015596,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015597,
                'name' => 'II+III J2',
                'name_short' => 'II+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015598,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015599,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015600,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015601,
                'name' => 'J-V',
                'name_short' => 'J-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015603,
                'name' => 'neogen',
                'name_short' => 'NEO',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015604,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015605,
                'name' => 'J--I-II',
                'name_short' => 'J--I-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015606,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015607,
                'name' => 'J-II-II',
                'name_short' => 'J-II-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015608,
                'name' => 'T-III',
                'name_short' => 'T-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015609,
                'name' => 'T-IV',
                'name_short' => 'T-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015610,
                'name' => 'T-VII',
                'name_short' => 'T-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015611,
                'name' => 'J-II-III',
                'name_short' => 'J-II-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015612,
                'name' => 'T-V',
                'name_short' => 'T-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015613,
                'name' => 'III ne+I2 J2',
                'name_short' => 'IIINE+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015614,
                'name' => 'J-II-I-II',
                'name_short' => 'J-II-I-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015634,
                'name' => 'J2',
                'name_short' => 'J-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015635,
                'name' => 'T',
                'name_short' => 'T',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015636,
                'name' => 'P1',
                'name_short' => 'P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015637,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015640,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015641,
                'name' => 'P1',
                'name_short' => 'P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015642,
                'name' => 'J2-IV',
                'name_short' => 'J-II-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015643,
                'name' => 'I-J2',
                'name_short' => 'I-J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015644,
                'name' => 'J2-V',
                'name_short' => 'J2-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015645,
                'name' => 'J-II',
                'name_short' => 'J-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015646,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015655,
                'name' => 'apt_ne',
                'name_short' => 'APT_NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015656,
                'name' => 'apt_ne+I ne',
                'name_short' => 'APT_NE+I NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015657,
                'name' => 'al',
                'name_short' => 'AL',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015659,
                'name' => 'neogen',
                'name_short' => 'NEO',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015660,
                'name' => 'I3',
                'name_short' => 'I3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015674,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015675,
                'name' => 'I PT',
                'name_short' => 'I PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015676,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015694,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015695,
                'name' => 'V_J2',
                'name_short' => '5J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015696,
                'name' => 'IX_J2',
                'name_short' => '9J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015697,
                'name' => 'XIV_PT+XV_PT',
                'name_short' => '14PT+15PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015701,
                'name' => 'apt_ne+III+IVne+I1 J2',
                'name_short' => 'APT_NE+III+IVNE+I1 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015702,
                'name' => 'alb_1',
                'name_short' => 'ALB_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015703,
                'name' => 'apt_ne+III+IV ne',
                'name_short' => 'APT NE+III+IVNE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015704,
                'name' => 'apt_I',
                'name_short' => 'APT_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015705,
                'name' => 'apt_ne',
                'name_short' => 'APT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015708,
                'name' => 'PT_7',
                'name_short' => 'PT_7',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015709,
                'name' => 'J_III',
                'name_short' => 'J_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015710,
                'name' => 'alb_3',
                'name_short' => 'ALB_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015711,
                'name' => 'pt',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015713,
                'name' => 'n_ne_6',
                'name_short' => 'N_NE_6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015714,
                'name' => 'ne_6',
                'name_short' => 'NE_6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015715,
                'name' => 'I2+I5 J2',
                'name_short' => 'I2+I5 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015716,
                'name' => 'I3+I4+I5 J2',
                'name_short' => 'I3+I4+I5 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015717,
                'name' => 'XIV_PT',
                'name_short' => '14PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015718,
                'name' => 'XV_PT',
                'name_short' => '15PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015720,
                'name' => 'XIV_J2',
                'name_short' => '14J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015734,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015735,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015736,
                'name' => 'alb',
                'name_short' => 'ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015737,
                'name' => 'I J2',
                'name_short' => 'I J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015738,
                'name' => 'I PT',
                'name_short' => 'I PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015739,
                'name' => 'IV+V PT',
                'name_short' => 'IV+V PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015740,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015742,
                'name' => 'alb+sen',
                'name_short' => 'ALB+SEN',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015743,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015754,
                'name' => 'I ne',
                'name_short' => 'I NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015755,
                'name' => 'K1 apt.ne',
                'name_short' => 'K1 APT.NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015756,
                'name' => 'apt_ne',
                'name_short' => 'APT_NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015757,
                'name' => 'alb+sen',
                'name_short' => 'ALB+SEN',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015758,
                'name' => 'pt',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015759,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015760,
                'name' => 'pt',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015761,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015762,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015763,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015774,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015775,
                'name' => 'P',
                'name_short' => 'P',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015776,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015777,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015778,
                'name' => 'IV+V J2',
                'name_short' => 'IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015779,
                'name' => 'VII+IX J2',
                'name_short' => 'VII+IX J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015780,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015781,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015782,
                'name' => 'VI J2',
                'name_short' => 'VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015783,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015784,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015785,
                'name' => 'APT_UZ',
                'name_short' => 'APT_UZ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015786,
                'name' => 'APT_SB',
                'name_short' => 'APT_SB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015787,
                'name' => 'NE_UZ',
                'name_short' => 'NE_UZ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015788,
                'name' => 'ALB_SB',
                'name_short' => 'ALB_SB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015789,
                'name' => 'ALB_UZ',
                'name_short' => 'ALB_UZ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015790,
                'name' => 'sol',
                'name_short' => 'SOL',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015791,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015792,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015793,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015794,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015795,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015796,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015797,
                'name' => 'J_UZ',
                'name_short' => 'J_UZ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015798,
                'name' => 'pt',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015799,
                'name' => 'PT_SB',
                'name_short' => 'PT_SB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015800,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015801,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015802,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015803,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015804,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015805,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015806,
                'name' => 'ALB_ZK',
                'name_short' => 'ALB_ZK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015807,
                'name' => 'CEN_BK',
                'name_short' => 'CEN_BK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015808,
                'name' => 'J_ZK',
                'name_short' => 'J_ZK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015809,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015810,
                'name' => 'NE_BK',
                'name_short' => 'NE_BK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015811,
                'name' => 'PT_BK',
                'name_short' => 'PT_BK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015812,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015813,
                'name' => 'J_BK',
                'name_short' => 'J_BK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015814,
                'name' => 'PT_ZK',
                'name_short' => 'PT_ZK',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015815,
                'name' => 'J1',
                'name_short' => 'H_J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015816,
                'name' => 'J3',
                'name_short' => 'B_J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015817,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015818,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015819,
                'name' => 'pt',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015820,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015821,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015822,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015823,
                'name' => 'K-1',
                'name_short' => 'K-1',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015824,
                'name' => 'К1а1',
                'name_short' => 'К1А1',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015825,
                'name' => 'J-I',
                'name_short' => 'J-I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015826,
                'name' => 'K1',
                'name_short' => 'K1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015827,
                'name' => 'J-I',
                'name_short' => 'J-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015828,
                'name' => 'К1а1',
                'name_short' => 'К1А1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015829,
                'name' => 'K1al',
                'name_short' => 'K1AL',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015830,
                'name' => 'apt_ne',
                'name_short' => 'APT_NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015831,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015832,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015833,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015834,
                'name' => 'J2+3',
                'name_short' => 'J2+3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015835,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015836,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015837,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015839,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015854,
                'name' => 'pt',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015855,
                'name' => 'alb',
                'name_short' => 'AIB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015856,
                'name' => 'alb+sen',
                'name_short' => 'ALB+SEN',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015857,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015858,
                'name' => 'IV alb+sen',
                'name_short' => 'IV ALB+SEN',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015860,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015861,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015862,
                'name' => 's+t',
                'name_short' => 'S+T',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015863,
                'name' => 'sen',
                'name_short' => 'SEN',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015865,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000015866,
                'name' => 'ne',
                'name_short' => 'NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015867,
                'name' => 'apt',
                'name_short' => 'APT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015874,
                'name' => 'VII_NE OP',
                'name_short' => 'VII_NE OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015894,
                'name' => 'VII+VIII J2',
                'name_short' => 'VII+VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015914,
                'name' => 'T-II-III',
                'name_short' => 'T-II-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015934,
                'name' => 'IV+V J2',
                'name_short' => 'IV+V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015935,
                'name' => 'VII J2',
                'name_short' => 'VII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015936,
                'name' => 'VIII J2',
                'name_short' => 'VIII J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000015937,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000016514,
                'name' => '-III J2',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000017914,
                'name' => 'РТ',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000017934,
                'name' => 'PT',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000017974,
                'name' => 'Карашунгуль',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KSC'
            ],
            [
                'id' => 3000017975,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000017976,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 3000017977,
                'name' => 'Pkg',
                'name_short' => 'PKG',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 3000017994,
                'name' => 'J2_XV',
                'name_short' => 'J2_XV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000000,
                'name' => 'ne',
                'name_short' => 'ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000020,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000021,
                'name' => 'III J2',
                'name_short' => 'III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000040,
                'name' => 'a-nc',
                'name_short' => 'a-nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000041,
                'name' => 'М2',
                'name_short' => 'М2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000042,
                'name' => 'M3+J1',
                'name_short' => 'M3+J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000065,
                'name' => 'IIIJ2',
                'name_short' => 'IIIJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000101,
                'name' => 'J-IV',
                'name_short' => 'J-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000102,
                'name' => 'Бодрай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BDR'
            ],
            [
                'id' => 5000000103,
                'name' => 'Нижний триас',
                'name_short' => 'НТ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000122,
                'name' => 'Новобагатинск Западный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'NBZ'
            ],
            [
                'id' => 5000000123,
                'name' => 'Триас',
                'name_short' => 'триас',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000126,
                'name' => 'Пермотриас',
                'name_short' => 'PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000144,
                'name' => 'Кызыл-Кала',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KKL'
            ],
            [
                'id' => 5000000146,
                'name' => 'P1K',
                'name_short' => 'P1K',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000149,
                'name' => 'Есболай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ESB'
            ],
            [
                'id' => 5000000150,
                'name' => 'P1K',
                'name_short' => 'P1K',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000151,
                'name' => 'Масабай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'MSB'
            ],
            [
                'id' => 5000000152,
                'name' => 'P1K',
                'name_short' => 'P1K',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000153,
                'name' => 'Южный Камыскуль',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UKM'
            ],
            [
                'id' => 5000000154,
                'name' => 'P1K',
                'name_short' => 'P1K',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000155,
                'name' => 'Северный Камыскуль',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SKM'
            ],
            [
                'id' => 5000000156,
                'name' => 'P1K',
                'name_short' => 'P1K',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000165,
                'name' => 'T-III-IV-VI',
                'name_short' => 'T-III-IV-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000166,
                'name' => 'J-I-II',
                'name_short' => 'J-I-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000168,
                'name' => 'Ne A',
                'name_short' => 'Ne A',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000169,
                'name' => 'T-II-III-IV',
                'name_short' => 'T-II-III-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000184,
                'name' => 'J-VI-VII',
                'name_short' => 'J-VI-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000204,
                'name' => 'K2',
                'name_short' => 'K2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000205,
                'name' => 'III J2',
                'name_short' => 'III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000206,
                'name' => 'nc',
                'name_short' => 'nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000226,
                'name' => 'IVJ2',
                'name_short' => 'IVJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000244,
                'name' => 'IV J2',
                'name_short' => 'IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000245,
                'name' => 'III J3',
                'name_short' => 'III J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000246,
                'name' => 'III J2+VI J2',
                'name_short' => 'III J2+VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000247,
                'name' => 'II+III+IV J2',
                'name_short' => 'II+III+IV J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000248,
                'name' => 'apt_ne',
                'name_short' => 'apt_ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000249,
                'name' => 'V PT',
                'name_short' => 'V PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000250,
                'name' => 'II J2',
                'name_short' => 'II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000251,
                'name' => 'a',
                'name_short' => 'a',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000253,
                'name' => 'APT_NE+III NE+I1J 2',
                'name_short' => 'APT_NE+III NE+I1J 2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000254,
                'name' => 'IV-РТ',
                'name_short' => 'IV-РТ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000264,
                'name' => 'a',
                'name_short' => 'a',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000284,
                'name' => 'T-I-III',
                'name_short' => 'T-I-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000286,
                'name' => 'J-VI',
                'name_short' => 'J-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000287,
                'name' => 'J-VII',
                'name_short' => 'J-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000288,
                'name' => 'I2 J3',
                'name_short' => 'I2 J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000289,
                'name' => 'V-PT',
                'name_short' => 'V-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000304,
                'name' => 'ALB',
                'name_short' => 'ALB',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000305,
                'name' => 'III J2',
                'name_short' => 'III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000324,
                'name' => 'J 3 VIII2+3',
                'name_short' => 'J 3 VIII2+3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000325,
                'name' => 'J 3VIII5 +J 2 IX',
                'name_short' => 'J 3VIII5 +J 2 IX',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000328,
                'name' => 'J 3VIII 2+3',
                'name_short' => 'J 3VIII 2+3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000329,
                'name' => 'T 2+3',
                'name_short' => 'T 2+3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000344,
                'name' => 'I+II J2',
                'name_short' => 'I+II J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000367,
                'name' => 'T_4',
                'name_short' => 'T_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000384,
                'name' => 'J-IV',
                'name_short' => 'J-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000404,
                'name' => 'Бажир',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BJR'
            ],
            [
                'id' => 5000000405,
                'name' => 'P1kg',
                'name_short' => 'P1kg',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000424,
                'name' => 'J2_IV',
                'name_short' => 'J2_IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000444,
                'name' => 'III J2',
                'name_short' => 'III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000476,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 5000000524,
                'name' => 'Основной свод',
                'name_short' => 'ОС',
                'geo_type' => 5000000040,
                'field_code' => null
            ],
            [
                'id' => 5000000544,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000564,
                'name' => 'V J2',
                'name_short' => 'V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000584,
                'name' => 'apt_ne',
                'name_short' => 'apt_ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000605,
                'name' => 'Лиман',
                'name_short' => 'Лиман',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 5000000684,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000685,
                'name' => 'T-III',
                'name_short' => 'T-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000686,
                'name' => 'T-IV',
                'name_short' => 'T-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000704,
                'name' => 'альбский ярус нижнего мела',
                'name_short' => 'альбский ярус нижнего мела',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000744,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000000768,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000000776,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000000777,
                'name' => 'III PT',
                'name_short' => 'III PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001001,
                'name' => 'Каражанбас',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KZH'
            ],
            [
                'id' => 5000001002,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000001003,
                'name' => 'A1',
                'name_short' => 'A1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001004,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001005,
                'name' => 'B',
                'name_short' => 'B',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001006,
                'name' => 'A2',
                'name_short' => 'A2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001007,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000001008,
                'name' => 'G',
                'name_short' => 'G',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001009,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000001010,
                'name' => 'J1',
                'name_short' => 'J1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001011,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001012,
                'name' => 'D2',
                'name_short' => 'D2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001013,
                'name' => 'Not specified',
                'name_short' => 'NotSpecifi',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000001014,
                'name' => 'Not Specified',
                'name_short' => 'Not Specified',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000001015,
                'name' => 'D',
                'name_short' => 'D',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002001,
                'name' => 'Акшабулак Центральный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKH'
            ],
            [
                'id' => 5000002002,
                'name' => 'M-II',
                'name_short' => 'M-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002003,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002004,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002005,
                'name' => 'Ю-III',
                'name_short' => 'Ю-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002006,
                'name' => 'Акшабулак Восточный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKH'
            ],
            [
                'id' => 5000002007,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002008,
                'name' => 'Ю-III',
                'name_short' => 'Ю-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002009,
                'name' => 'Акшабулак Южный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKH'
            ],
            [
                'id' => 5000002010,
                'name' => 'M-II',
                'name_short' => 'M-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002011,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002012,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002013,
                'name' => 'Ю-III',
                'name_short' => 'Ю-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002014,
                'name' => 'Нуралы Центральный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'NUR'
            ],
            [
                'id' => 5000002015,
                'name' => 'M-II',
                'name_short' => 'M-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002016,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002017,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002018,
                'name' => 'Ю-III',
                'name_short' => 'Ю-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002019,
                'name' => 'Нуралы Западный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'NUR'
            ],
            [
                'id' => 5000002020,
                'name' => 'M-II',
                'name_short' => 'M-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002021,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002022,
                'name' => 'Нуралы Восточный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'NUR'
            ],
            [
                'id' => 5000002023,
                'name' => 'Ю-IV',
                'name_short' => 'Ю-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002024,
                'name' => 'Аксай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKS'
            ],
            [
                'id' => 5000002025,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002026,
                'name' => 'M-II-4',
                'name_short' => 'M-II-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002027,
                'name' => 'M-II-5',
                'name_short' => 'M-II-5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002028,
                'name' => 'Южный',
                'name_short' => 'Южный',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000002029,
                'name' => 'Ю-IIIt',
                'name_short' => 'Ю-IIIt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002030,
                'name' => 'Ю-0-2',
                'name_short' => 'Ю-0-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002031,
                'name' => 'Ю-0-1',
                'name_short' => 'Ю-0-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002032,
                'name' => 'M-II-1',
                'name_short' => 'M-II-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002033,
                'name' => 'Север',
                'name_short' => 'Север',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000002034,
                'name' => 'M-II-1',
                'name_short' => 'M-II-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002035,
                'name' => 'Ю-0-2рус.',
                'name_short' => 'Ю-0-2рус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002036,
                'name' => 'Ю-0-2',
                'name_short' => 'Ю-0-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002037,
                'name' => 'Ю-III',
                'name_short' => 'Ю-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002038,
                'name' => 'Ю-III',
                'name_short' => 'Ю-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002039,
                'name' => 'Ю-0-1b рус.',
                'name_short' => 'Ю-0-1b рус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002040,
                'name' => 'Ю-0-1b нерус.',
                'name_short' => 'Ю-0-1b нерус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002041,
                'name' => 'Ю-IIIa',
                'name_short' => 'Ю-IIIa',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002042,
                'name' => 'M-II-2',
                'name_short' => 'M-II-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002043,
                'name' => 'M-II-1/2',
                'name_short' => 'M-II-1/2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002044,
                'name' => 'M-II-1d',
                'name_short' => 'M-II-1d',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002045,
                'name' => 'Ю-0-1b',
                'name_short' => 'Ю-0-1b',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002046,
                'name' => 'Нуралы',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'NUR'
            ],
            [
                'id' => 5000002047,
                'name' => 'Запад',
                'name_short' => 'Запад',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000002048,
                'name' => 'Центр',
                'name_short' => 'Центр',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 5000002049,
                'name' => 'M-II-3',
                'name_short' => 'M-II-3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002050,
                'name' => 'M-II-4',
                'name_short' => 'M-II-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002051,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002052,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002053,
                'name' => 'M-II-1',
                'name_short' => 'M-II-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002054,
                'name' => 'M-II-2',
                'name_short' => 'M-II-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002055,
                'name' => 'Ю-III-1',
                'name_short' => 'Ю-III-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002056,
                'name' => 'M-II',
                'name_short' => 'M-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002057,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002058,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002059,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002060,
                'name' => 'M-II-3',
                'name_short' => 'M-II-3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002061,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002062,
                'name' => 'M-II-1c',
                'name_short' => 'M-II-1c',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002063,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002064,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002065,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002066,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002067,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002068,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002069,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002070,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002071,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002072,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002073,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002074,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002075,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002076,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002077,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002078,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002079,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002080,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002081,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002082,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002083,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002084,
                'name' => 'K2sn-P1',
                'name_short' => 'K2sn-P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002085,
                'name' => 'K2t',
                'name_short' => 'K2t',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002086,
                'name' => 'Q-N2/3',
                'name_short' => 'Q-N2/3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002087,
                'name' => 'Ю-IVd',
                'name_short' => 'Ю-IVd',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002088,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002089,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002090,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002091,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002092,
                'name' => 'M-II-3',
                'name_short' => 'M-II-3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002093,
                'name' => 'M-II-4',
                'name_short' => 'M-II-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002094,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002095,
                'name' => 'M-II-2',
                'name_short' => 'M-II-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002096,
                'name' => 'Ю-II',
                'name_short' => 'Ю-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002097,
                'name' => 'Ю-I',
                'name_short' => 'Ю-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002098,
                'name' => 'M-II-1',
                'name_short' => 'M-II-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002099,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 5000002100,
                'name' => 'Ю-III-2',
                'name_short' => 'Ю-III-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 21474836471,
                'name' => '4',
                'name_short' => '4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 21474836481,
                'name' => '6',
                'name_short' => '6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 21474836491,
                'name' => '8',
                'name_short' => '8',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 21474836501,
                'name' => '10',
                'name_short' => '10',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 21474836691,
                'name' => 'Триас',
                'name_short' => 'Триас',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 21474836701,
                'name' => 'T-I-II-III',
                'name_short' => 'T-I-II-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000001,
                'name' => 'VII  J2',
                'name_short' => 'VII  J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000003,
                'name' => 'M-II-1',
                'name_short' => 'M-II-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000004,
                'name' => 'Т2',
                'name_short' => 'Т2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000011,
                'name' => 'K1a-nc',
                'name_short' => 'K1a-nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000014,
                'name' => 'АЛБ',
                'name_short' => 'АЛБ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000021,
                'name' => 'II Ne',
                'name_short' => 'II Ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000023,
                'name' => 'Ю-0-2b',
                'name_short' => 'Ю-0-2b',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000024,
                'name' => '09Б',
                'name_short' => '09Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000034,
                'name' => '2',
                'name_short' => '2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000044,
                'name' => '10А',
                'name_short' => '10А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000054,
                'name' => 'Г',
                'name_short' => 'Г',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000064,
                'name' => 'Т2',
                'name_short' => 'Т2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000074,
                'name' => '11',
                'name_short' => '11',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000084,
                'name' => '5',
                'name_short' => '5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000094,
                'name' => 'Ю1',
                'name_short' => 'Ю1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000104,
                'name' => 'Ап2',
                'name_short' => 'Ап2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000114,
                'name' => '1',
                'name_short' => '1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000124,
                'name' => '10В',
                'name_short' => '10В',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000134,
                'name' => '10',
                'name_short' => '10',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000144,
                'name' => 'Ап1',
                'name_short' => 'Ап1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000154,
                'name' => '4',
                'name_short' => '4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000164,
                'name' => '07А',
                'name_short' => '07А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000174,
                'name' => '3',
                'name_short' => '3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000184,
                'name' => '7',
                'name_short' => '7',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000194,
                'name' => 'ОЛ',
                'name_short' => 'ОЛ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000204,
                'name' => '3',
                'name_short' => '3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000214,
                'name' => 'Т3',
                'name_short' => 'Т3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000221,
                'name' => 'T-I',
                'name_short' => 'T-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000224,
                'name' => '7',
                'name_short' => '7',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000233,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000234,
                'name' => '3',
                'name_short' => '3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000243,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000244,
                'name' => '11',
                'name_short' => '11',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000253,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000254,
                'name' => 'Ю',
                'name_short' => 'Ю',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000264,
                'name' => '10',
                'name_short' => '10',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000274,
                'name' => '03Б',
                'name_short' => '03Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000284,
                'name' => '07Б',
                'name_short' => '07Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000294,
                'name' => '1',
                'name_short' => '1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000304,
                'name' => '12',
                'name_short' => '12',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000314,
                'name' => 'Т2В',
                'name_short' => 'Т2В',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000324,
                'name' => 'Ю5',
                'name_short' => 'Ю5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000334,
                'name' => '6',
                'name_short' => '6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000344,
                'name' => '02Б',
                'name_short' => '02Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000354,
                'name' => '9',
                'name_short' => '9',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000364,
                'name' => '9',
                'name_short' => '9',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000374,
                'name' => '11',
                'name_short' => '11',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000384,
                'name' => '09А',
                'name_short' => '09А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000394,
                'name' => '10Б',
                'name_short' => '10Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000404,
                'name' => 'Ю4',
                'name_short' => 'Ю4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000414,
                'name' => '8',
                'name_short' => '8',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000421,
                'name' => 'J-V',
                'name_short' => 'J-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000424,
                'name' => 'Т3',
                'name_short' => 'Т3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000431,
                'name' => 'J-VI',
                'name_short' => 'J-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000434,
                'name' => 'Т3',
                'name_short' => 'Т3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000444,
                'name' => 'С3',
                'name_short' => 'С3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000454,
                'name' => '2',
                'name_short' => '2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000464,
                'name' => '4',
                'name_short' => '4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000474,
                'name' => '10',
                'name_short' => '10',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000484,
                'name' => 'С2',
                'name_short' => 'С2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000494,
                'name' => '11',
                'name_short' => '11',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000504,
                'name' => '03А',
                'name_short' => '03А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000514,
                'name' => '06Б',
                'name_short' => '06Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000524,
                'name' => 'Апт',
                'name_short' => 'Апт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000534,
                'name' => '2',
                'name_short' => '2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000544,
                'name' => 'В',
                'name_short' => 'В',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000554,
                'name' => 'С5',
                'name_short' => 'С5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000564,
                'name' => 'С1',
                'name_short' => 'С1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000574,
                'name' => 'Ю2',
                'name_short' => 'Ю2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000584,
                'name' => 'Д2',
                'name_short' => 'Д2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000594,
                'name' => '12',
                'name_short' => '12',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000604,
                'name' => '05В',
                'name_short' => '05В',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000614,
                'name' => '9',
                'name_short' => '9',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000621,
                'name' => 'J-II(4-ый пласт)',
                'name_short' => 'J-II(4-ый пласт)',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000624,
                'name' => 'Т2',
                'name_short' => 'Т2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000634,
                'name' => 'ГР',
                'name_short' => 'ГР',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000644,
                'name' => 'Т2',
                'name_short' => 'Т2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000654,
                'name' => 'А',
                'name_short' => 'А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000664,
                'name' => '11',
                'name_short' => '11',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000674,
                'name' => 'Д',
                'name_short' => 'Д',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000684,
                'name' => 'Д1',
                'name_short' => 'Д1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000694,
                'name' => 'Е',
                'name_short' => 'Е',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000704,
                'name' => 'Ю-05Б',
                'name_short' => 'Ю-05Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000714,
                'name' => 'ХА1',
                'name_short' => 'ХА1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000724,
                'name' => '3',
                'name_short' => '3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000734,
                'name' => '05А',
                'name_short' => '05А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000744,
                'name' => '10Б',
                'name_short' => '10Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000754,
                'name' => 'Т2',
                'name_short' => 'Т2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000764,
                'name' => '8',
                'name_short' => '8',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000774,
                'name' => '2',
                'name_short' => '2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000784,
                'name' => '13',
                'name_short' => '13',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000794,
                'name' => '04А',
                'name_short' => '04А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000804,
                'name' => 'Ю6',
                'name_short' => 'Ю6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000814,
                'name' => '06Б',
                'name_short' => '06Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000821,
                'name' => 'Альбский ярус нижнего мела',
                'name_short' => 'Альбский ярус нижнего мела',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000824,
                'name' => '5',
                'name_short' => '5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000834,
                'name' => '08А',
                'name_short' => '08А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000844,
                'name' => 'С4',
                'name_short' => 'С4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000854,
                'name' => 'Ю0',
                'name_short' => 'Ю0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000864,
                'name' => 'Т2',
                'name_short' => 'Т2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000874,
                'name' => 'Б',
                'name_short' => 'Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000884,
                'name' => 'Ю3',
                'name_short' => 'Ю3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000894,
                'name' => '02А',
                'name_short' => '02А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000904,
                'name' => 'ЧТВ',
                'name_short' => 'ЧТВ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000914,
                'name' => '06А',
                'name_short' => '06А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000924,
                'name' => '4',
                'name_short' => '4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000934,
                'name' => 'Т3',
                'name_short' => 'Т3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000000974,
                'name' => 'Жетыбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'JET'
            ],
            [
                'id' => 2000000000984,
                'name' => 'Асар',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ASA'
            ],
            [
                'id' => 2000000000994,
                'name' => 'Ю.Жетыбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UJE'
            ],
            [
                'id' => 2000000001004,
                'name' => 'Бектурлы',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BEK'
            ],
            [
                'id' => 2000000001014,
                'name' => 'Восточный Жетыбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'VOS'
            ],
            [
                'id' => 2000000001021,
                'name' => 'III PT',
                'name_short' => 'III PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001024,
                'name' => 'Атанбай',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ATA'
            ],
            [
                'id' => 2000000001031,
                'name' => 'II PT',
                'name_short' => 'II PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001034,
                'name' => 'Ашиагар',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ASH'
            ],
            [
                'id' => 2000000001044,
                'name' => 'Айрантакыр',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AIR'
            ],
            [
                'id' => 2000000001054,
                'name' => 'Сев.Аккар',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SAK'
            ],
            [
                'id' => 2000000001074,
                'name' => 'Оймаша',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'OIM'
            ],
            [
                'id' => 2000000001084,
                'name' => 'Придорожное',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'PRI'
            ],
            [
                'id' => 2000000001094,
                'name' => 'Сев.Карагие',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'SKA'
            ],
            [
                'id' => 2000000001104,
                'name' => 'Ала-Тюбе',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ALA'
            ],
            [
                'id' => 2000000001144,
                'name' => 'Бурмаша',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BUR'
            ],
            [
                'id' => 2000000001154,
                'name' => 'Каламкас',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KAL'
            ],
            [
                'id' => 2000000001184,
                'name' => 'Аксын-Каламкас',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKK'
            ],
            [
                'id' => 2000000001194,
                'name' => 'Кызылкум',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KYZ'
            ],
            [
                'id' => 2000000001204,
                'name' => 'Т3',
                'name_short' => 'Т3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001221,
                'name' => 'J-III',
                'name_short' => 'J-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001414,
                'name' => 'T1',
                'name_short' => 'T1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001421,
                'name' => 'Аpt - ne',
                'name_short' => 'Аpt - ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001431,
                'name' => 'II-J2',
                'name_short' => 'II-J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001441,
                'name' => 'III-j2',
                'name_short' => 'III-J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001461,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000001471,
                'name' => 'V-PT',
                'name_short' => 'V-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001481,
                'name' => 'III-PT',
                'name_short' => 'III-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001491,
                'name' => 'IV-PT',
                'name_short' => 'IV-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001501,
                'name' => 'IV+V-PT',
                'name_short' => 'IV+V-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001614,
                'name' => '12',
                'name_short' => '12',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001621,
                'name' => 'J-II',
                'name_short' => 'J-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001624,
                'name' => '10A',
                'name_short' => '10A',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001631,
                'name' => 'J-IV',
                'name_short' => 'J-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001634,
                'name' => '10',
                'name_short' => '10',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001641,
                'name' => 'J-I',
                'name_short' => 'J-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001651,
                'name' => 'J-III',
                'name_short' => 'J-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001661,
                'name' => 'J-IV',
                'name_short' => 'J-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001691,
                'name' => 'M-III',
                'name_short' => 'M-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001814,
                'name' => '05Б',
                'name_short' => '05Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001821,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000001824,
                'name' => '8В',
                'name_short' => '8В',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001831,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001834,
                'name' => '5',
                'name_short' => '5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001841,
                'name' => 'T-IV',
                'name_short' => 'T-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000001851,
                'name' => 'T- III- IV',
                'name_short' => 'T- III- IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002014,
                'name' => '8А',
                'name_short' => '8А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002021,
                'name' => 'УАЗ Восточный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UZV'
            ],
            [
                'id' => 2000000002024,
                'name' => '8Б',
                'name_short' => '8Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002031,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2000000002034,
                'name' => '12А',
                'name_short' => '12А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002041,
                'name' => 'I Ne',
                'name_short' => 'I Ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002044,
                'name' => '9',
                'name_short' => '9',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002051,
                'name' => 'II Ne',
                'name_short' => 'II Ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002061,
                'name' => 'J',
                'name_short' => 'J',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002071,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000002204,
                'name' => 'K1al',
                'name_short' => 'K1al',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002311,
                'name' => '20А',
                'name_short' => '20А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002321,
                'name' => '20А',
                'name_short' => '20А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002331,
                'name' => '20А',
                'name_short' => '20А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002341,
                'name' => '20А',
                'name_short' => '20А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002404,
                'name' => 'Q 3-4',
                'name_short' => 'Q 3-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002471,
                'name' => 'Барлыбай Северо-Западный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BSZ'
            ],
            [
                'id' => 2000000002604,
                'name' => '9',
                'name_short' => '9',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002671,
                'name' => 'VI J2',
                'name_short' => 'VI J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002871,
                'name' => 'Триас',
                'name_short' => 'Триас',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2000000002881,
                'name' => 'T-I',
                'name_short' => 'T-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002891,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000002901,
                'name' => 'T-III',
                'name_short' => 'T-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003004,
                'name' => 'P1',
                'name_short' => 'P1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003014,
                'name' => 'P2',
                'name_short' => 'P2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003071,
                'name' => 'ALB1',
                'name_short' => 'ALB1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003081,
                'name' => 'I1',
                'name_short' => 'I1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003091,
                'name' => 'I2',
                'name_short' => 'I2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003101,
                'name' => 'J2',
                'name_short' => 'J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003121,
                'name' => 'apt_ne_1',
                'name_short' => 'apt_ne_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003271,
                'name' => 'J2_1',
                'name_short' => 'J2_1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003281,
                'name' => 'J2_2',
                'name_short' => 'J2_2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003291,
                'name' => 'J2_3',
                'name_short' => 'J2_3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003301,
                'name' => 'J2_4',
                'name_short' => 'J2_4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003311,
                'name' => 'J2_5',
                'name_short' => 'J2_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003321,
                'name' => 'J2_6',
                'name_short' => 'J2_6',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003331,
                'name' => 'J2_7',
                'name_short' => 'J2_7',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003341,
                'name' => 'J2_8',
                'name_short' => 'J2_8',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003471,
                'name' => 'an+L nc',
                'name_short' => 'an+L nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003481,
                'name' => 'a-nc',
                'name_short' => 'a-nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003491,
                'name' => 'I nc+II nc пл. "А+Б"',
                'name_short' => 'I nc+II nc пл. "А+Б"',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003501,
                'name' => 'I nc пл. "А+Б"',
                'name_short' => 'I nc пл. "А+Б"',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003671,
                'name' => 'II A',
                'name_short' => 'II A',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003681,
                'name' => 'IX PT',
                'name_short' => 'IX PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003871,
                'name' => 'Turon_OP',
                'name_short' => 'Turon_OP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000003881,
                'name' => 'Turon_CZP',
                'name_short' => 'Turon_CZP',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004071,
                'name' => 'РТ-IV',
                'name_short' => 'РТ-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004081,
                'name' => 'РТ-V',
                'name_short' => 'РТ-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004091,
                'name' => 'РТ-VI-A',
                'name_short' => 'РТ-VI-A',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004101,
                'name' => 'РТ-VI-Б',
                'name_short' => 'РТ-VI-Б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004111,
                'name' => 'РТ-VII',
                'name_short' => 'РТ-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004121,
                'name' => 'РТ-VIII',
                'name_short' => 'РТ-VIII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004131,
                'name' => 'РТ-IX',
                'name_short' => 'РТ-IX',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004141,
                'name' => 'РТ-X',
                'name_short' => 'РТ-X',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004151,
                'name' => 'Т-I',
                'name_short' => 'Т-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004161,
                'name' => 'Т-II',
                'name_short' => 'Т-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004171,
                'name' => 'Т-III-1',
                'name_short' => 'Т-III-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004181,
                'name' => 'Т-III-2',
                'name_short' => 'Т-III-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004191,
                'name' => 'Т-IV-1',
                'name_short' => 'Т-IV-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004201,
                'name' => 'Т-IV-2',
                'name_short' => 'Т-IV-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004211,
                'name' => 'Т-V',
                'name_short' => 'Т-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004271,
                'name' => 'Западная переклиналь',
                'name_short' => 'Западная переклиналь',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000004281,
                'name' => '13',
                'name_short' => '13',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004291,
                'name' => '14',
                'name_short' => '14',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004301,
                'name' => '15',
                'name_short' => '15',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004311,
                'name' => '21',
                'name_short' => '21',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004321,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004331,
                'name' => 'Восточный Парсмурун',
                'name_short' => 'VOS_PARS',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000004341,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004351,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004361,
                'name' => '22',
                'name_short' => '22',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004371,
                'name' => '16',
                'name_short' => '16',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004381,
                'name' => '17',
                'name_short' => '17',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004391,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004401,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004411,
                'name' => '20',
                'name_short' => '20',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004421,
                'name' => '23',
                'name_short' => '23',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004431,
                'name' => '24',
                'name_short' => '24',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004441,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004471,
                'name' => 'nc',
                'name_short' => 'nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004481,
                'name' => 'nc + IV nc',
                'name_short' => 'nc + IV nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004491,
                'name' => 'a+nc+IIInc+IVnc+I1+I2 J2',
                'name_short' => 'a+nc+IIInc+IVnc+I1+I2 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004501,
                'name' => 'I1+I2+I4',
                'name_short' => 'I1+I2+I4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004511,
                'name' => 'III+IV+VJ2',
                'name_short' => 'III+IV+VJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000004521,
                'name' => 'IIJ2 IIпл+III+IVJ2',
                'name_short' => 'IIJ2 IIпл+III+IVJ2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005536,
                'name' => 'J – II',
                'name_short' => 'J – II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005546,
                'name' => 'J – III',
                'name_short' => 'J – III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005556,
                'name' => 'K1 A',
                'name_short' => 'K1 A',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005566,
                'name' => 'І al',
                'name_short' => 'І al',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005576,
                'name' => 'ІІ al',
                'name_short' => 'ІІ al',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005586,
                'name' => 'І al + ІІal',
                'name_short' => 'І al + ІІal',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005596,
                'name' => 'Іal + ІІal+ІІal-Іпл',
                'name_short' => 'Іal + ІІal+ІІal-Іпл',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005606,
                'name' => 'ІІ al+a+nc',
                'name_short' => 'ІІ al+a+nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005616,
                'name' => 'ІІ al-ІІпл+a+nc',
                'name_short' => 'ІІ al-ІІпл+a+nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005626,
                'name' => 'а',
                'name_short' => 'а',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005636,
                'name' => 'a+nc',
                'name_short' => 'a+nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005646,
                'name' => 'III nc',
                'name_short' => 'III nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005656,
                'name' => 'IV -nc',
                'name_short' => 'IV -nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005666,
                'name' => 'a+nc + III nc',
                'name_short' => 'a+nc + III nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005676,
                'name' => 'a+nc + IV nc',
                'name_short' => 'a+nc + IV nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005686,
                'name' => 'a+nc + IV nc',
                'name_short' => 'a+nc + IV nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005696,
                'name' => 'III nc + IV nc',
                'name_short' => 'III nc + IV nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005706,
                'name' => 'а+nc+IIInc+IVnc+I1 J2',
                'name_short' => 'а+nc+IIInc+IVnc+I1 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005716,
                'name' => 'III-nc+IVnc+I1 J2',
                'name_short' => 'III-nc+IVnc+I1 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005726,
                'name' => 'III-nc+I1 J2',
                'name_short' => 'III-nc+I1 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005735,
                'name' => '18',
                'name_short' => '18',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005736,
                'name' => 'III-nc+I1 J2',
                'name_short' => 'III-nc+I1 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005746,
                'name' => 'IVnc+ I2 J2',
                'name_short' => 'IVnc+ I2 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005756,
                'name' => 'nc+ I2 J2',
                'name_short' => 'nc+ I2 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005776,
                'name' => 'I1  + I3 J2',
                'name_short' => 'I1  + I3 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005786,
                'name' => 'I5 J2 + II J2 Іпл',
                'name_short' => 'I5 J2 + II J2 Іпл',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005796,
                'name' => 'I5 J2 + IIJ2 Іпл+IIJ2 ІІ пл',
                'name_short' => 'I5 J2 + IIJ2 Іпл+IIJ2 ІІ пл',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005806,
                'name' => 'I5 J2 + III J2',
                'name_short' => 'I5 J2 + III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005846,
                'name' => 'I2 + I3  + I4',
                'name_short' => 'I2 + I3  + I4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005856,
                'name' => 'I2+I4+I5 J2',
                'name_short' => 'I2+I4+I5 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005866,
                'name' => 'I2J2 + III J2',
                'name_short' => 'I2J2 + III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005876,
                'name' => 'I1J2+I2J2 +III J2',
                'name_short' => 'I1J2+I2J2 +III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005886,
                'name' => 'I3  + I4',
                'name_short' => 'I3  + I4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005906,
                'name' => 'IIJ2 IІпл',
                'name_short' => 'IIJ2 IІпл',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005916,
                'name' => 'IIJ2 ІІпл+III J2',
                'name_short' => 'IIJ2 ІІпл+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005926,
                'name' => 'IV + V J2',
                'name_short' => 'IV + V J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005935,
                'name' => '23',
                'name_short' => '23',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005936,
                'name' => 'II РТ',
                'name_short' => 'II РТ',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005946,
                'name' => 'III + IV nc',
                'name_short' => 'III + IV nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005956,
                'name' => 'III nc+I1 + I 2 J2',
                'name_short' => 'III nc+I1 + I 2 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005966,
                'name' => 'III+I2J2',
                'name_short' => 'III+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005976,
                'name' => 'III nc +I1J2+I2 J2',
                'name_short' => 'III nc +I1J2+I2 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005986,
                'name' => 'nc+I1+I2 J2',
                'name_short' => 'nc+I1+I2 J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000005996,
                'name' => 'IIJ2Іпл+III J2',
                'name_short' => 'IIJ2Іпл+III J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006006,
                'name' => 'IIJ2 Іпл',
                'name_short' => 'IIJ2 Іпл',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006016,
                'name' => 'УАЗ Северный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'UZS'
            ],
            [
                'id' => 2000000006026,
                'name' => 'Т пласт 1',
                'name_short' => 'Т пласт 1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006036,
                'name' => 'Т пласт 2',
                'name_short' => 'Т пласт 2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006046,
                'name' => 'T-I',
                'name_short' => 'T-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006056,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006066,
                'name' => 'T-III',
                'name_short' => 'T-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006135,
                'name' => '20А',
                'name_short' => '20А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006136,
                'name' => 'IIInc+I2J2',
                'name_short' => 'IIInc+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006145,
                'name' => '20А',
                'name_short' => '20А',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006146,
                'name' => 'IIInc+IVnc+I2J2',
                'name_short' => 'IIInc+IVnc+I2J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006156,
                'name' => 'ІІ al-ІІпл+a',
                'name_short' => 'ІІ al-ІІпл+a',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006166,
                'name' => 'Ne-I',
                'name_short' => 'Ne-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006176,
                'name' => 'J-I',
                'name_short' => 'J-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006186,
                'name' => 'Триас, возвратный',
                'name_short' => 'Триас, возвратный',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006196,
                'name' => 'Т-1 пласт',
                'name_short' => 'Т-1 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006206,
                'name' => 'Т-2 пласт',
                'name_short' => 'Т-2 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006216,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006226,
                'name' => 'T-III',
                'name_short' => 'T-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006236,
                'name' => 'J-IV',
                'name_short' => 'J-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006246,
                'name' => 'J-V',
                'name_short' => 'J-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006256,
                'name' => 'J-VI',
                'name_short' => 'J-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006266,
                'name' => 'Триас, возвратный',
                'name_short' => 'Триас, возвратный',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006276,
                'name' => 'Т-1 пласт',
                'name_short' => 'Т-1 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006286,
                'name' => 'Т-2 пласт',
                'name_short' => 'Т-2 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006296,
                'name' => 'Триас',
                'name_short' => 'Триас',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006306,
                'name' => 'Т',
                'name_short' => 'Т',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006335,
                'name' => '19',
                'name_short' => '19',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006336,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006345,
                'name' => '3',
                'name_short' => '3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006346,
                'name' => 'Возвратные',
                'name_short' => 'Возвратные',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006356,
                'name' => 'III-J2',
                'name_short' => 'III-J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006366,
                'name' => 'I-PT',
                'name_short' => 'I-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006376,
                'name' => 'II-PT',
                'name_short' => 'II-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006386,
                'name' => 'III-PT',
                'name_short' => 'III-PT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006416,
                'name' => 'J2-III',
                'name_short' => 'J2-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006426,
                'name' => 'J2-IV',
                'name_short' => 'J2-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006436,
                'name' => 'J2-V',
                'name_short' => 'J2-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006446,
                'name' => 'J2-VI',
                'name_short' => 'J2-VI',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006456,
                'name' => 'J2-VII',
                'name_short' => 'J2-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006466,
                'name' => 'J2-IX',
                'name_short' => 'J2-IX',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006476,
                'name' => 'nc+a+nc',
                'name_short' => 'nc+a+nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006486,
                'name' => 'nc+a+nc',
                'name_short' => 'nc+a+nc',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006535,
                'name' => '18б',
                'name_short' => '18б',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006536,
                'name' => 'Байтобетарал',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'BTA'
            ],
            [
                'id' => 2000000006735,
                'name' => '25',
                'name_short' => '25',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006746,
                'name' => 'Карасор Западный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'ZKS'
            ],
            [
                'id' => 2000000006756,
                'name' => 'K1-alb',
                'name_short' => 'K1-alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006766,
                'name' => 'K1-apt',
                'name_short' => 'K1-apt',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006776,
                'name' => 'K1-ne',
                'name_short' => 'K1-ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006936,
                'name' => 'K1-VLG-I',
                'name_short' => 'K1-VLG-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006946,
                'name' => 'K1-VLG-III',
                'name_short' => 'K1-VLG-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006956,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006966,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006976,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000006986,
                'name' => 'J2_IX2',
                'name_short' => 'J2_IX2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000006996,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007006,
                'name' => 'J3_VIII-4a',
                'name_short' => 'J3_VIII-4a',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007016,
                'name' => 'J3_VIII-4b',
                'name_short' => 'J3_VIII-4b',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007026,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007036,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007046,
                'name' => 'J2_IX3',
                'name_short' => 'J2_IX3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007056,
                'name' => 'J2_XIII',
                'name_short' => 'J2_XIII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007066,
                'name' => 'APT',
                'name_short' => 'APT',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007076,
                'name' => 'Ne',
                'name_short' => 'Ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007086,
                'name' => 'Возвратный',
                'name_short' => 'Возврат',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007096,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007106,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007116,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007126,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007136,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007146,
                'name' => 'J2-1 пласт',
                'name_short' => 'J2-1 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007156,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007166,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007176,
                'name' => 'J2-2 пласт',
                'name_short' => 'J2-2 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007186,
                'name' => 'J3',
                'name_short' => 'J3',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007196,
                'name' => 'J4-1 пласт',
                'name_short' => 'J4-1 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007206,
                'name' => 'J4-2 пласт',
                'name_short' => 'J4-2 пласт',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007216,
                'name' => 'K1-VLG-I',
                'name_short' => 'K1-VLG-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007226,
                'name' => 'K1-VLG-II',
                'name_short' => 'K1-VLG-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007236,
                'name' => 'T_5',
                'name_short' => 'T_5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007336,
                'name' => 'Вост. Б-с. I-Alb',
                'name_short' => 'Вост. Б-с. I-Alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007346,
                'name' => 'Вост. Б-с. III-Alb',
                'name_short' => 'Вост. Б-с. III-Alb',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007356,
                'name' => 'Вост. Б-с. Apt-ne',
                'name_short' => 'Вост. Б-с. Apt-ne',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007366,
                'name' => 'Юж. Б-с. J2',
                'name_short' => 'Юж. Б-с. J2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007376,
                'name' => 'Юж. Б-с. NE',
                'name_short' => 'Юж. Б-с. NE',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007386,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007396,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007406,
                'name' => 'II',
                'name_short' => 'II',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007416,
                'name' => 'III',
                'name_short' => 'III',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007426,
                'name' => 'IV',
                'name_short' => 'IV',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007436,
                'name' => 'VI',
                'name_short' => 'VI',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007446,
                'name' => 'VII',
                'name_short' => 'VII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007456,
                'name' => 'VIII',
                'name_short' => 'VIII',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007466,
                'name' => 'V',
                'name_short' => 'V',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007536,
                'name' => 'Лиман',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'LMN'
            ],
            [
                'id' => 2000000007546,
                'name' => 'T-I',
                'name_short' => 'T-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007556,
                'name' => 'T-II',
                'name_short' => 'T-II',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007566,
                'name' => 'T-III',
                'name_short' => 'T-III',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007576,
                'name' => 'T-IV',
                'name_short' => 'T-IV',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007586,
                'name' => 'T-V',
                'name_short' => 'T-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007596,
                'name' => 'T-III-1',
                'name_short' => 'T-III-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007606,
                'name' => 'T-III-2',
                'name_short' => 'T-III-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007616,
                'name' => 'T-IV-1',
                'name_short' => 'T-IV-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007626,
                'name' => 'T-IV-2',
                'name_short' => 'T-IV-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007736,
                'name' => 'J-V',
                'name_short' => 'J-V',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007746,
                'name' => 'J-VII',
                'name_short' => 'J-VII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007756,
                'name' => 'J-VIII',
                'name_short' => 'J-VIII',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2000000007936,
                'name' => 'Кайнарский массив',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'KNM'
            ],
            [
                'id' => 2000000007946,
                'name' => 'I',
                'name_short' => 'I',
                'geo_type' => 2,
                'field_code' => null
            ],
            [
                'id' => 2000000007956,
                'name' => 'K1al+K2s',
                'name_short' => 'K1al+K2s',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000000403,
                'name' => 'Ю-0-1',
                'name_short' => 'Ю-0-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000000603,
                'name' => 'Ю-0-1нерус.',
                'name_short' => 'Ю-0-1нерус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000000803,
                'name' => 'Ю-IIIa',
                'name_short' => 'Ю-IIIa',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000000813,
                'name' => 'М-II-1b',
                'name_short' => 'М-II-1b',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000000823,
                'name' => 'Ю-0-1',
                'name_short' => 'Ю-0-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000000833,
                'name' => 'Ю-IIIa',
                'name_short' => 'Ю-IIIa',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001003,
                'name' => 'Ю-IVd',
                'name_short' => 'Ю-IVd',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001203,
                'name' => 'Ю-0-1',
                'name_short' => 'Ю-0-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001403,
                'name' => 'Ю-0-1',
                'name_short' => 'Ю-0-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001413,
                'name' => 'Ю-0-2',
                'name_short' => 'Ю-0-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001423,
                'name' => 'Ю-0-1b рус.',
                'name_short' => 'Ю-0-1b рус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001433,
                'name' => 'Ю-0-1рус.',
                'name_short' => 'Ю-0-1рус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001443,
                'name' => 'Ю-0-2нерус.',
                'name_short' => 'Ю-0-2нерус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001453,
                'name' => 'Ю-0-1b нерус.',
                'name_short' => 'Ю-0-1b нерус.',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001603,
                'name' => 'Аксай Южный',
                'name_short' => null,
                'geo_type' => 1,
                'field_code' => 'AKS'
            ],
            [
                'id' => 2100000001613,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001623,
                'name' => 'M-II-4',
                'name_short' => 'M-II-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001633,
                'name' => 'M-II-5',
                'name_short' => 'M-II-5',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001643,
                'name' => 'Возвратный объект',
                'name_short' => 'Возвратный объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001653,
                'name' => 'I объект',
                'name_short' => 'I объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001663,
                'name' => 'II объект',
                'name_short' => 'II объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001673,
                'name' => 'I объект',
                'name_short' => 'I объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001683,
                'name' => 'II объект',
                'name_short' => 'II объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001693,
                'name' => 'III объект',
                'name_short' => 'III объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001703,
                'name' => 'Северный свод (I)',
                'name_short' => 'Северный свод (I)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001713,
                'name' => 'Северный свод (II)',
                'name_short' => 'Северный свод (II)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001723,
                'name' => 'Центральный свод (III)',
                'name_short' => 'Центральный свод (III)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001733,
                'name' => 'Центральный свод (IV)',
                'name_short' => 'Центральный свод (IV)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001743,
                'name' => 'Центральный свод (V)',
                'name_short' => 'Центральный свод (V)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001753,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001763,
                'name' => 'M-II-4',
                'name_short' => 'M-II-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001773,
                'name' => 'M-II-4',
                'name_short' => 'M-II-4',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001783,
                'name' => 'I объект',
                'name_short' => 'I объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001793,
                'name' => 'II объект',
                'name_short' => 'II объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001803,
                'name' => 'III объект',
                'name_short' => 'III объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001813,
                'name' => 'Ю-IVk',
                'name_short' => 'Ю-IVk',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001823,
                'name' => 'I объект',
                'name_short' => 'I объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001833,
                'name' => 'IV объект',
                'name_short' => 'IV объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001843,
                'name' => 'VIII объект',
                'name_short' => 'VIII объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001853,
                'name' => 'Ю-0-1',
                'name_short' => 'Ю-0-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001863,
                'name' => 'Ю-0-2',
                'name_short' => 'Ю-0-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001873,
                'name' => 'II объект',
                'name_short' => 'II объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001883,
                'name' => 'III объект',
                'name_short' => 'III объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001893,
                'name' => 'V объект',
                'name_short' => 'V объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001903,
                'name' => 'VI объект',
                'name_short' => 'VI объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001913,
                'name' => 'VII объект',
                'name_short' => 'VII объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001923,
                'name' => 'Ю-0-2',
                'name_short' => 'Ю-0-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001933,
                'name' => 'Ю-III-1',
                'name_short' => 'Ю-III-1',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000001943,
                'name' => 'I объект',
                'name_short' => 'I объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001953,
                'name' => 'II объект (русл.отлож.)',
                'name_short' => 'II объект (русл.отлож.)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001963,
                'name' => 'III объект',
                'name_short' => 'III объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001973,
                'name' => 'IV объект (нерусл. отлож.)',
                'name_short' => 'IV объект (нерусл. отлож.)',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000001983,
                'name' => 'V объект',
                'name_short' => 'V объект',
                'geo_type' => 3,
                'field_code' => null
            ],
            [
                'id' => 2100000002003,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000002013,
                'name' => 'Ю-III-2',
                'name_short' => 'Ю-III-2',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000002023,
                'name' => 'Ю-0',
                'name_short' => 'Ю-0',
                'geo_type' => 4,
                'field_code' => null
            ],
            [
                'id' => 2100000002203,
                'name' => 'M-I',
                'name_short' => 'M-I',
                'geo_type' => 4,
                'field_code' => null
            ]
        ];

        foreach($geos as $geo) {
            DB::table('bigdata_geos')->insert($geo);
        }
    }
}
