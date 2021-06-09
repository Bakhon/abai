<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class MonitoringEconomicPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ["monitoring list economical_effect","monitoring list lost_profits"];

        foreach($permissions as $item){
            $permission = new Permission();
            $permission->name = $item;
            $permission->guard_name = "web";
            $permission->save();
        }
    }
}
