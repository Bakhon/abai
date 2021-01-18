<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class ProtoBDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = "bigdata view main";
        $permission->save();

   
    }
}
