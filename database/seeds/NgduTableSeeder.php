<?php

use Illuminate\Database\Seeder;

class NgduTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Ngdu::create([
            'name' => 'НГДУ-1',
            'org_id' => 1
        ]);

        App\Models\Ngdu::create([
            'name' => 'НГДУ-2',
            'org_id' => 1
        ]);

        App\Models\Ngdu::create([
            'name' => 'НГДУ-3',
            'org_id' => 1
        ]);

        App\Models\Ngdu::create([
            'name' => 'НГДУ-4',
            'org_id' => 1
        ]);
    }
}
