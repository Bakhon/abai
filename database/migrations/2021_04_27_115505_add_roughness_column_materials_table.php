<?php

use App\Models\Pipes\MapPipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ComplicationMonitoring\Material;

class AddRoughnessColumnMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->float('roughness', 8, 4)->nullable();
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['roughness']);
        });
    }

    public function seed()
    {
        $material = Material::where('name', 'Сталь')->first();
        $material->roughness = 0.2;
        $material->save();

        $material = Material::where('name', 'Полипропилен')->first();
        $material->roughness = 0.005;
        $material->save();

        $material = Material::firstOrCreate(
            [
                'name' => 'mild steel',
            ]
        );
        $material->roughness = 0.05;
        $material->save();
    }
}
