<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PermissionSection;

class AddPermissionSectionForDigitalDrilling extends Migration
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
                'module' => 'digitalDrilling'
            ],
        ];

        foreach ($data as $row) {
            PermissionSection::firstOrCreate($row);
        }
    }
}
