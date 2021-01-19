<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class TrPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = "tr view main";
        $permission->save();

           
            
        }  
    
}
