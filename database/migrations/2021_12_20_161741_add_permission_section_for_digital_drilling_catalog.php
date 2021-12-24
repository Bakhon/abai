<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionSectionForDigitalDrillingCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permission_sections')->insert(
            [
                'code' => 'catalog',
                'title_trans' => 'digital_drilling.permission_sections.daily_raport_catalogs',
                'module' => 'digitalDrilling'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permission_sections')
            ->where('code', 'catalog')
            ->where('module','digitalDrilling')
            ->delete();
    }
}
