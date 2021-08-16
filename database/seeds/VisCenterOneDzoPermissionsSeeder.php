<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;
use App\Models\PermissionSection;

class VisCenterOneDzoPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = "visualcenter one_dzo main";
        $permission->save();  
        
        $permissionSection = new PermissionSection();
        $permissionSection->code = "one_dzo";
        $permissionSection->module = "visualcenter";
        $permissionSection->save();  
    }
}