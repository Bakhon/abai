<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OrgTableSeeder::class);
        $this->call(NgduTableSeeder::class);
        $this->call(CdngTableSeeder::class);
        $this->call(GuTableSeeder::class);
        $this->call(ZuTableSeeder::class);
        $this->call(WellTableSeeder::class);
        $this->call(HydrocarbonOxidizingBacteriaTableSeeder::class);
        $this->call(OtherObjectsTableSeeder::class);
        $this->call(SulphateReducingBacteriaTableSeeder::class);
        $this->call(ThionicBacteriaTableSeeder::class);
        $this->call(WaterTypeBySulinTableSeeder::class);
        $this->call(WaterMeasurementTableSeeder::class);
        $this->call(KormassTableSeeder::class);
        $this->call(KormassGuTableSeeder::class);
        $this->call(CorrosionTableSeeder::class);
        $this->call(BactericideTableSeeder::class);
    }
}
