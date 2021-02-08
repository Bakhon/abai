<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBigdataWellTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bigdata_well_types',
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
        Schema::dropIfExists('bigdata_well_types');
    }

    private function seed()
    {
        $types = [
            "Горизонтальная",
            "Вертикальная",
            "Наклонно-направленная"
        ];

        foreach($types as $type) {
            DB::table('bigdata_well_types')->insert([
                'name' => $type
            ]);
        }
    }
}
