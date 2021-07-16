<?php

use Illuminate\Database\Seeder;

class RepTtTypesReferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $names = [
        'Incomes for distribution' => 'Доходы для распределения по месторождением',
        'Fixed costs' => 'Постоянные расходы для распределния по месторождениям',
        'Variable costs' => 'Переменные расходы (Затраты по материалам и электроэнергии) по месторождениям',
        'kvl' => 'Капитальные вложения',
        'dds' => 'Движение денежных средств'
    ];

    public function run()
    {
        foreach ($this->names as $name=>$desc) {
            DB::table('rep_tt_types')->insert([
                'name' => $name,
                'description' => $desc
            ]);
        }
    }
}
