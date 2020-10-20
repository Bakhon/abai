<?php

use Illuminate\Database\Seeder;

class KormassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 13; $i++) {
            App\Models\Kormass::create([
                'name' => 'Кормасс-'.$i.'',
            ]);
        }

        App\Models\Kormass::create([
            'name' => 'Прямой УПСВ'
        ]);
    }
}
