<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBigdataOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bigdata_orgs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->string('name');
                $table->string('name_short')->nullable();
                $table->timestamp('date_start')->nullable();
                $table->timestamp('date_end')->nullable();
                $table->timestamps();
            }
        );

        $this->seed();

        Schema::table(
            'bigdata_orgs',
            function (Blueprint $table) {

                $table->foreign('parent_id')->references('id')->on('bigdata_orgs');

            }
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bigdata_orgs');
    }

    private function seed()
    {
        $orgs = [
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'АО "НК "КазМунайГаз" (бывш. РД КМГ)',
                'name_short' => 'НК КМГ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'name' => 'АО "Озенмунайгаз"',
                'name_short' => 'АО ОМГ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 3,
                'parent_id' => 1,
                'name' => 'АО "Эмбамунайгаз"',
                'name_short' => 'АО ЭМГ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 4,
                'parent_id' => 2,
                'name' => 'НГДУ-1',
                'name_short' => 'НГДУ-1',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'name' => 'НГДУ-2',
                'name_short' => 'НГДУ-2',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 6,
                'parent_id' => 2,
                'name' => 'НГДУ-3',
                'name_short' => 'НГДУ-3',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 7,
                'parent_id' => 2,
                'name' => 'НГДУ-4',
                'name_short' => 'НГДУ-4',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 8,
                'parent_id' => 3,
                'name' => 'НГДУ-Доссормунайгаз',
                'name_short' => 'Доссормунайгаз',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 9,
                'parent_id' => 3,
                'name' => 'НГДУ-Жылыоймунайгаз',
                'name_short' => 'Жылыоймунайгаз',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10,
                'parent_id' => 3,
                'name' => 'НГДУ-Жайкмунайгаз',
                'name_short' => 'Жайкмунайгаз',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11,
                'parent_id' => 3,
                'name' => 'НГДУ-Кайнармунайгаз',
                'name_short' => 'Кайнармунайгаз',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 12,
                'parent_id' => 6,
                'name' => 'ЦДНГ-10',
                'name_short' => 'ЦДНГ-10',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 21,
                'parent_id' => 4,
                'name' => 'ЦДНГ-2',
                'name_short' => 'ЦДНГ-2',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 47,
                'parent_id' => 10,
                'name' => 'ЦДНГ-1',
                'name_short' => 'ЦДНГ-1',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 48,
                'parent_id' => 10,
                'name' => 'ЦДНГ-2',
                'name_short' => 'ЦДНГ-2',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 49,
                'parent_id' => 10,
                'name' => 'ЦДНГ-3',
                'name_short' => 'ЦДНГ-3',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 50,
                'parent_id' => 10,
                'name' => 'ЦДНГ-4',
                'name_short' => 'ЦДНГ-4',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 1124,
                'parent_id' => 5,
                'name' => 'ЦДНГ-3',
                'name_short' => 'ЦДНГ-3',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 1467,
                'parent_id' => 7,
                'name' => 'ЦДНГ-4',
                'name_short' => 'ЦДНГ-4',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 1791,
                'parent_id' => 5,
                'name' => 'ЦДНГ-12',
                'name_short' => 'ЦДНГ-12',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2085,
                'parent_id' => 4,
                'name' => 'ЦДНГ-8',
                'name_short' => 'ЦДНГ-8',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2355,
                'parent_id' => 4,
                'name' => 'ЦДНГ-11',
                'name_short' => 'ЦДНГ-11',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 3012,
                'parent_id' => 6,
                'name' => 'ЦДНГ-1',
                'name_short' => 'ЦДНГ-1',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 3013,
                'parent_id' => 6,
                'name' => 'ЦДНГ-5',
                'name_short' => 'ЦДНГ-5',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 3681,
                'parent_id' => 7,
                'name' => 'ЦДНГ-6',
                'name_short' => 'ЦДНГ-6',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 3682,
                'parent_id' => 7,
                'name' => 'ЦДНГ-7',
                'name_short' => 'ЦДНГ-7',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 4331,
                'parent_id' => 5,
                'name' => 'ЦДНГ-9',
                'name_short' => 'ЦДНГ-9',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 8822,
                'parent_id' => 4,
                'name' => 'ППД-1',
                'name_short' => 'ППД-1',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 9127,
                'parent_id' => 5,
                'name' => 'ППД-2',
                'name_short' => 'ППД-2',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 9386,
                'parent_id' => 6,
                'name' => 'ППД-3',
                'name_short' => 'ППД-3',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 9708,
                'parent_id' => 7,
                'name' => 'ППД-4',
                'name_short' => 'ППД-4',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 9971,
                'parent_id' => 8,
                'name' => 'ЦДНГ Ботахан',
                'name_short' => 'ЦДНГ Ботахан',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10085,
                'parent_id' => 8,
                'name' => 'ЦДН Карсак',
                'name_short' => 'ЦДН Карсак',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10264,
                'parent_id' => 8,
                'name' => 'УДН Алтыколь',
                'name_short' => 'УДН Алтыколь',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10317,
                'parent_id' => 8,
                'name' => 'УДН Байчунас',
                'name_short' => 'УДН Байчунас',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10384,
                'parent_id' => 8,
                'name' => 'УДН Доссор',
                'name_short' => 'УДН Доссор',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10421,
                'parent_id' => 8,
                'name' => 'УДН Кошкар',
                'name_short' => 'УДН Кошкар',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10468,
                'parent_id' => 8,
                'name' => 'УДН Макат',
                'name_short' => 'УДН Макат',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10502,
                'parent_id' => 8,
                'name' => 'УДН С.Жолдыбай',
                'name_short' => 'УДН С.Жолдыбай',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10536,
                'parent_id' => 8,
                'name' => 'ЦДНГ В.Макат',
                'name_short' => 'ЦДНГ В.Макат',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 10606,
                'parent_id' => 11,
                'name' => 'ЦДНГ-В.Молдабек',
                'name_short' => 'ЦДНГ-В.Молдабек',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11057,
                'parent_id' => 11,
                'name' => 'ЦДНГ-Кондыбай',
                'name_short' => 'ЦДНГ-Кондыбай',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11062,
                'parent_id' => 11,
                'name' => 'ЦДНГ-УАЗ',
                'name_short' => 'ЦДНГ-УАЗ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11069,
                'parent_id' => 11,
                'name' => 'ЦДНГ-Б.Жоламанов',
                'name_short' => 'ЦДНГ-Б.Жоламанов',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11153,
                'parent_id' => 9,
                'name' => 'ЦДНГ-Косчагил',
                'name_short' => 'ЦДНГ-Косчагил',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11249,
                'parent_id' => 9,
                'name' => 'ЦДНГ-Прорва',
                'name_short' => 'ЦДНГ-Прорва',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 11497,
                'parent_id' => 9,
                'name' => 'ЦДНГ-Терень-Узюк',
                'name_short' => 'ЦДНГ-Терень-Узюк',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18557,
                'parent_id' => 8,
                'name' => 'ППД С.Жолдыбай',
                'name_short' => 'ППД С.Жолдыбай',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18568,
                'parent_id' => 8,
                'name' => 'ППД В.Макат',
                'name_short' => 'ППД В.Макат',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18580,
                'parent_id' => 8,
                'name' => 'ППД Ботахан',
                'name_short' => 'ППД Ботахан',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18602,
                'parent_id' => 8,
                'name' => 'ППД Карсак',
                'name_short' => 'ППД Карсак',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18657,
                'parent_id' => 11,
                'name' => 'ППД УАЗ',
                'name_short' => 'ППД УАЗ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18862,
                'parent_id' => 9,
                'name' => 'ППД Косчагил',
                'name_short' => 'ППД Косчагил',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18882,
                'parent_id' => 9,
                'name' => 'ППД Терень-Узюк',
                'name_short' => 'ППД Терень-Узюк',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18943,
                'parent_id' => 8,
                'name' => 'ППД Макат',
                'name_short' => 'ППД Макат',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18945,
                'parent_id' => 8,
                'name' => 'ППД Алтыколь',
                'name_short' => 'ППД Алтыколь',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18947,
                'parent_id' => 8,
                'name' => 'ППД Байчунас',
                'name_short' => 'ППД Байчунас',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18949,
                'parent_id' => 8,
                'name' => 'ППД Бек-Беке',
                'name_short' => 'ППД Бек-Беке',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18962,
                'parent_id' => 8,
                'name' => 'ППД Комсомольское',
                'name_short' => 'ППД Комсомольское',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18966,
                'parent_id' => 8,
                'name' => 'ППД Кошкар',
                'name_short' => 'ППД Кошкар',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18969,
                'parent_id' => 8,
                'name' => 'ППД Доссор',
                'name_short' => 'ППД Доссор',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18982,
                'parent_id' => 9,
                'name' => 'ППД Прорва',
                'name_short' => 'ППД Прорва',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 18994,
                'parent_id' => 10,
                'name' => 'ППД Жайкмунайгаз-1',
                'name_short' => 'ППД Жайкмунайгаз-1',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 60576,
                'parent_id' => 10,
                'name' => 'ППД Жайкмунайгаз-2',
                'name_short' => 'ППД Жайкмунайгаз-2',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 60577,
                'parent_id' => 10,
                'name' => 'ППД Жайкмунайгаз-3',
                'name_short' => 'ППД Жайкмунайгаз-3',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 60578,
                'parent_id' => 10,
                'name' => 'ППД Жайкмунайгаз-4',
                'name_short' => 'ППД Жайкмунайгаз-4',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 3000023928,
                'parent_id' => 8,
                'name' => 'УДН Сагиз',
                'name_short' => 'УДН Сагиз',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000000000,
                'parent_id' => 11,
                'name' => 'ЦДНГ-Бажир',
                'name_short' => 'ЦДНГ-Бажир',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000000020,
                'parent_id' => 8,
                'name' => 'ППД Сагиз',
                'name_short' => 'ППД Сагиз',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001017,
                'parent_id' => 1,
                'name' => 'АО "Каражанбасмунай"',
                'name_short' => 'КБМ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001018,
                'parent_id' => 5000001017,
                'name' => 'ВНС законтурные',
                'name_short' => 'ВНС законтурные',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001019,
                'parent_id' => 5000001018,
                'name' => '10-ый ряд',
                'name_short' => '10-ый ряд',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001020,
                'parent_id' => 5000001018,
                'name' => '20-ый ряд',
                'name_short' => '20-ый ряд',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001021,
                'parent_id' => 5000001018,
                'name' => '30-ый ряд',
                'name_short' => '30-ый ряд',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001022,
                'parent_id' => 5000001018,
                'name' => '50-ый ряд',
                'name_short' => '50-ый ряд',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001023,
                'parent_id' => 5000001018,
                'name' => '51-70-ые ряды',
                'name_short' => '51-70-ые ряды',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001024,
                'parent_id' => 5000001017,
                'name' => 'Цех-1',
                'name_short' => 'Цех-1',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001025,
                'parent_id' => 5000001017,
                'name' => 'Цех-2',
                'name_short' => 'Цех-2',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001026,
                'parent_id' => 5000001024,
                'name' => 'Участок ГЗУ-12',
                'name_short' => 'Участок ГЗУ-12',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001027,
                'parent_id' => 5000001024,
                'name' => 'Участок ГЗУ-34',
                'name_short' => 'Участок ГЗУ-34',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001028,
                'parent_id' => 5000001024,
                'name' => 'Участок ГЗУ-33',
                'name_short' => 'Участок ГЗУ-33',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001029,
                'parent_id' => 5000001025,
                'name' => 'Участок ГЗУ-16',
                'name_short' => 'Участок ГЗУ-16',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001030,
                'parent_id' => 5000001025,
                'name' => 'Участок ГЗУ-27',
                'name_short' => 'Участок ГЗУ-27',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001031,
                'parent_id' => 5000001025,
                'name' => 'Участок ГЗУ-30',
                'name_short' => 'Участок ГЗУ-30',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001032,
                'parent_id' => 5000001025,
                'name' => 'Участок ГЗУ-31',
                'name_short' => 'Участок ГЗУ-31',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000001033,
                'parent_id' => 5000001025,
                'name' => 'Участок ГЗУ-32',
                'name_short' => 'Участок ГЗУ-32',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002001,
                'parent_id' => 5000002025,
                'name' => 'УДНГ (Акшабулак)',
                'name_short' => 'УДНГ (Акшабулак)',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002020,
                'parent_id' => 1,
                'name' => 'КазГерМунай',
                'name_short' => 'КазГерМунай',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002021,
                'parent_id' => 5000002024,
                'name' => 'УДНГ (Нуралы)',
                'name_short' => 'УДНГ (Нуралы)',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002022,
                'parent_id' => 5000002024,
                'name' => 'ППД (Нуралы)',
                'name_short' => 'ППД (Нуралы)',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002023,
                'parent_id' => 5000002025,
                'name' => 'ППД (Акшабулак)',
                'name_short' => 'ППД (Акшабулак)',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002024,
                'parent_id' => 5000002020,
                'name' => 'Нуралы',
                'name_short' => 'Нуралы',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002025,
                'parent_id' => 5000002020,
                'name' => 'Акшабулак',
                'name_short' => 'Акшабулак',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002026,
                'parent_id' => 5000002020,
                'name' => 'Аксай',
                'name_short' => 'Аксай',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002027,
                'parent_id' => 5000002026,
                'name' => 'УДНГ (Аксай)',
                'name_short' => 'УДНГ (Аксай)',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002028,
                'parent_id' => 5000002026,
                'name' => 'ППД (Аксай)',
                'name_short' => 'ППД (Аксай)',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002031,
                'parent_id' => 11,
                'name' => 'ЦДНГ-С.Котыртас',
                'name_short' => 'ЦДНГ-С.Котыртас',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002041,
                'parent_id' => 11,
                'name' => 'ППД С.Котыртас',
                'name_short' => 'ППД С.Котыртас',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002051,
                'parent_id' => 11,
                'name' => 'ППД Кондыбай',
                'name_short' => 'ППД Кондыбай',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002061,
                'parent_id' => 11,
                'name' => 'ППД В.Молдабек',
                'name_short' => 'ППД В.Молдабек',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002071,
                'parent_id' => 11,
                'name' => 'ППД Бажир',
                'name_short' => 'ППД Бажир',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002081,
                'parent_id' => 11,
                'name' => 'ППД Б.Жоламанов',
                'name_short' => 'ППД Б.Жоламанов',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002231,
                'parent_id' => 6,
                'name' => 'ЦДНГ-13',
                'name_short' => 'ЦДНГ-13',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002431,
                'parent_id' => 11,
                'name' => 'ЦДНГ УАЗ Восточный',
                'name_short' => 'ЦДНГ УАЗ Восточный',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002631,
                'parent_id' => 11,
                'name' => 'ЦДНГ Барлыбай Северо-Западный',
                'name_short' => 'ЦДНГ Барлыбай Северо-Западный',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000002831,
                'parent_id' => 10,
                'name' => 'ЦДНГ-5',
                'name_short' => 'ЦДНГ-5',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000003031,
                'parent_id' => 10,
                'name' => 'ППД Жайкмунайгаз-5',
                'name_short' => 'ППД Жайкмунайгаз-5',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000004046,
                'parent_id' => 11,
                'name' => 'ЦДНГ УАЗ Северный',
                'name_short' => 'ЦДНГ УАЗ Северный',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000004246,
                'parent_id' => 11,
                'name' => 'ППД УАЗ Восточный',
                'name_short' => 'ППД УАЗ Восточный',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 5000004446,
                'parent_id' => 11,
                'name' => 'ППД Кайнарский массив',
                'name_short' => 'ППД Кайнарский массив',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000004,
                'parent_id' => null,
                'name' => '"МАНГИСТАУМУНАЙГАЗ"',
                'name_short' => 'ММГ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000024,
                'parent_id' => 2000000000004,
                'name' => 'ПУ  "ЖЕТЫБАЙМУНАЙГАЗ"',
                'name_short' => 'ПУ  "ЖЕТЫБАЙМУНАЙГАЗ"',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000034,
                'parent_id' => 2000000000004,
                'name' => 'ПУ  "КАЛАМКАСМУНАЙГАЗ"',
                'name_short' => 'ПУ  "КАЛАМКАСМУНАЙГАЗ"',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000044,
                'parent_id' => 2000000000024,
                'name' => 'ЦДНГ-01',
                'name_short' => 'ЦДНГ-01',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000054,
                'parent_id' => 2000000000024,
                'name' => 'ЦДНГ-02',
                'name_short' => 'ЦДНГ-02',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000064,
                'parent_id' => 2000000000024,
                'name' => 'ЦДНГ-03',
                'name_short' => 'ЦДНГ-03',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000084,
                'parent_id' => 2000000000024,
                'name' => 'ЦППД',
                'name_short' => 'ЦППД',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000094,
                'parent_id' => 2000000000034,
                'name' => 'ЦДНГ-01',
                'name_short' => 'ЦДНГ-01',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000104,
                'parent_id' => 2000000000034,
                'name' => 'ЦДНГ-02',
                'name_short' => 'ЦДНГ-02',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000114,
                'parent_id' => 2000000000034,
                'name' => 'ЦДНГ-03',
                'name_short' => 'ЦДНГ-03',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000124,
                'parent_id' => 2000000000034,
                'name' => 'ЦДНГ-04',
                'name_short' => 'ЦДНГ-04',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000134,
                'parent_id' => 2000000000034,
                'name' => 'ЦДПиТГ',
                'name_short' => 'ЦДПиТГ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000144,
                'parent_id' => 2000000000034,
                'name' => 'ЦППД',
                'name_short' => 'ЦППД',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ],
            [
                'id' => 2000000000154,
                'parent_id' => 2000000000034,
                'name' => 'ЦПТЖ',
                'name_short' => 'ЦПТЖ',
                'date_start' => '1990-01-01',
                'date_end' => NULL,
            ]
        ];

        foreach($orgs as $org) {
            DB::table('bigdata_orgs')->insert($org);
        }
    }
}
