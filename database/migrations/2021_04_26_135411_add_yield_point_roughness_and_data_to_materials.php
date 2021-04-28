<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYieldPointRoughnessAndDataToMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            Schema::table('materials', function (Blueprint $table) {
                $table->integer('yield_point');
                $table->float('roughness');
            });
    
            DB::Table('materials') -> insert(array(
                'name' => 'Ст.20',
                'yield_point' => '245',
                'roughness' => '0.2'
            ));
    
            DB::Table('materials') -> insert(array(
                'name' => 'СПТ',
                'yield_point' => '27',
                'roughness' => '0.05'
            ));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['yield_point', 'roughness']);
            DB::table('materials')->where('name','=','СТ.20')->delete();
            DB::table('materials')->where('name','=','СПТ')->delete();

        });
    }
}
