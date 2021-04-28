<?php

use App\Models\ComplicationMonitoring\Material;
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
            $table->integer('yield_point')->nullable();
        });

        $material = Material::firstOrCreate(
            [
                'name' => 'Ст.20'
            ]
        );
        $material->yield_point = 245;
        $material->save();

        $material = Material::firstOrCreate(
            [
                'name' => 'СПТ'
            ]
        );
        $material->yield_point = 27;
        $material->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['yield_point']);
        });
    }
}
