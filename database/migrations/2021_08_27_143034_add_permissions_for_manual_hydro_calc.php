<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PermissionSection;
use Spatie\Permission\Models\Permission;

class AddPermissionsForManualHydroCalc extends Migration
{
    public $permissions = [
        'monitoring view manual_hydro_calculation',
        'monitoring list manual_hydro_calculation',
        'monitoring create manual_hydro_calculation',
        'monitoring read manual_hydro_calculation',
        'monitoring update manual_hydro_calculation',
        'monitoring delete manual_hydro_calculation',
        'monitoring export manual_hydro_calculation'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        foreach ($this->permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web'
                ]
            );
        }

        PermissionSection::firstOrCreate(
            [
                'code' => 'manual_hydro_calculation',
                'title_trans' => 'monitoring.manual_hydro_calculation.section',
                'module' => 'monitoring'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::whereIn('name', $this->permissions)->delete();
        PermissionSection::where('code', 'manual_hydro_calculation')
            ->where('module', 'monitoring')
            ->delete();
    }
}
