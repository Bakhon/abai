<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBigdataWellCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bigdata_well_categories',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
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
        Schema::dropIfExists('bigdata_well_categories');
    }

    private function seed()
    {
        $categories = [
            "Нефтяная",
            "Нагнетательная",
            "Водозаборная",
            "Контрольная",
            "Поглощающая",
            "Разведочная",
            "Неизвестно",
            "Поисковая",
            "Оценочная",
            "Газовая",
            "Паронагнетательная",
            "Утилизационная",
            "Наблюдательная",
        ];

        foreach ($categories as $id => $category) {
            DB::table('bigdata_well_categories')->insert(
                [
                    'name' => $category
                ]
            );
        }
    }
}
