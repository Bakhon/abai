<?php

use Illuminate\Database\Seeder;

class OrgTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Org::create([
            'name' => 'AО Озенмунайгаз'
        ]);
    }
}
