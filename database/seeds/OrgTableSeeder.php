<?php

use App\Models\Refs\Org;
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
        Org::create([
            'name' => 'AО Озенмунайгаз'
        ]);
    }
}
