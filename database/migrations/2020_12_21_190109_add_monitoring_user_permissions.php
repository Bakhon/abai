<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonitoringUserPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'monitoring view main',
            'monitoring view pipes map',
            'monitoring list oilgas',
            'monitoring create oilgas',
            'monitoring read oilgas',
            'monitoring update oilgas',
            'monitoring delete oilgas',
            'monitoring export oilgas',
            'monitoring view history oilgas',
            'monitoring list watermeasurement',
            'monitoring create watermeasurement',
            'monitoring read watermeasurement',
            'monitoring update watermeasurement',
            'monitoring delete watermeasurement',
            'monitoring export watermeasurement',
            'monitoring view history watermeasurement',
            'monitoring list corrosion',
            'monitoring create corrosion',
            'monitoring read corrosion',
            'monitoring update corrosion',
            'monitoring delete corrosion',
            'monitoring export corrosion',
            'monitoring view history corrosion',
            'monitoring list omgca',
            'monitoring create omgca',
            'monitoring read omgca',
            'monitoring update omgca',
            'monitoring delete omgca',
            'monitoring export omgca',
            'monitoring view history omgca',
            'monitoring list omgngdu',
            'monitoring create omgngdu',
            'monitoring read omgngdu',
            'monitoring update omgngdu',
            'monitoring delete omgngdu',
            'monitoring export omgngdu',
            'monitoring view history omgngdu',
            'monitoring list omguhe',
            'monitoring create omguhe',
            'monitoring read omguhe',
            'monitoring update omguhe',
            'monitoring delete omguhe',
            'monitoring export omguhe',
            'monitoring view history omguhe',
            'monitoring list pipes',
            'monitoring create pipes',
            'monitoring read pipes',
            'monitoring update pipes',
            'monitoring delete pipes',
            'monitoring export pipes',
            'monitoring view history pipes',
            'monitoring list inhibitors',
            'monitoring create inhibitors',
            'monitoring read inhibitors',
            'monitoring update inhibitors',
            'monitoring delete inhibitors',
            'monitoring export inhibitors',
            'monitoring view history inhibitors',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(
                [
                    'name' => $permission,
                    'guard' => 'web'
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
