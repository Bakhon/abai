<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('title_trans')->nullable();
            $table->string('module')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('permission_sections');
    }

    private function seed()
    {
        $data = [
            [
                'code' => 'main',
                'title_trans' => 'monitoring.permission.main.title',
                'module' => 'monitoring'
            ],
            [
                'code' => 'report',
                'title_trans' => 'monitoring.permissions.report.title',
                'module' => 'monitoring'
            ],
            [
                'code' => 'lost_profits',
                'title_trans' => 'monitoring.lost_profits_title',
                'module' => 'monitoring'
            ],
            [
                'code' => 'economical_effect',
                'title_trans' => 'monitoring.economic_effect',
                'module' => 'monitoring'
            ],
            [
                'code' => 'oilgas',
                'title_trans' => 'monitoring.oil.title',
                'module' => 'monitoring'
            ],
            [
                'code' => 'watermeasurement',
                'title_trans' => 'monitoring.wm.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'corrosion',
                'title_trans' => 'monitoring.corrosion.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'omgca',
                'omgca' => 'monitoring.omgca.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'omgngdu',
                'title_trans' => 'monitoring.omgngdu.name',
                'module' => 'monitoring'
            ],
            [
                'code' => 'omgngdu_well',
                'title_trans' => 'monitoring.omgngdu_well.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'omguhe',
                'title_trans' => 'monitoring.omguhe.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'pipe',
                'title_trans' => 'monitoring.pipe.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'inhibitors',
                'title_trans' => 'monitoring.inhibitors',
                'module' => 'monitoring'
            ],
            [
                'code' => 'gu',
                'title_trans' => 'monitoring.gu.gu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'zu',
                'title_trans' => 'monitoring.zu.zu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'well',
                'title_trans' => 'monitoring.well.well',
                'module' => 'monitoring'
            ],
            [
                'code' => 'map-history',
                'title_trans' => 'monitoring.map-history.admin.title',
                'module' => 'monitoring'
            ],
            [
                'code' => 'pipe-passport',
                'title_trans' => 'monitoring.pipe_passport.title',
                'module' => 'monitoring'
            ],

            [
                'code' => 'hydro_calculation',
                'title_trans' => 'monitoring.hydro_calculation.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'reverse_calculation',
                'title_trans' => 'monitoring.reverse_calculation.menu',
                'module' => 'monitoring'
            ],
            [
                'code' => 'pipe_types',
                'title_trans' => 'monitoring.pipe_types.title',
                'module' => 'monitoring'
            ],
            [
                'code' => 'pipes map',
                'title_trans' => 'monitoring.tech_map',
                'module' => 'monitoring'
            ],
            [
                'code' => 'pipes',
                'title_trans' => 'monitoring.pipes',
                'module' => 'monitoring'
            ],
        ];

        PermissionSection::insert($data);
    }
}
