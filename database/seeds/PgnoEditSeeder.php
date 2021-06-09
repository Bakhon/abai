<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class PGNOEditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $permission = new Permission();
        $permission->name = "podborGno edit main";
        $permission->save();
    }
}
