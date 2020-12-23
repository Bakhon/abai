<?php

use App\Models\ComplicationMonitoring\Kormass;
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
            Kormass::create([
                'name' => 'Кормасс-'.$i.'',
            ]);
        }

        Kormass::create([
            'name' => 'Прямой УПСВ'
        ]);
    }
}
