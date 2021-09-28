<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PermissionSection;

class AddPermissionSectionForPlastFluids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    private function seed()
    {
        $data = [
            [
                'code' => 'main',
                'module' => 'plastFluids',
                'title_trans' => 'plast_fluids.module_whole_pages',
            ],
        ];

        foreach ($data as $row) {
            PermissionSection::firstOrCreate($row);
        }
    }

}
