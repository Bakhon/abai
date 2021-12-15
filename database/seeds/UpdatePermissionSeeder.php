<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \Spatie\Permission\Models\Permission::where('name', 'LIKE', 'mapConstructor%')
        ->update([
            'name' => DB::raw("CONCAT(name, ' main')")
        ]);

    }
}
