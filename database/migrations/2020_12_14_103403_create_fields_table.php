<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_s', function (Blueprint $table) {
            $table->renameColumn('field', 'field_id');
        });

        Schema::table('corrosions', function (Blueprint $table) {
            $table->renameColumn('field', 'field_id');
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        $this->seed();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_s', function (Blueprint $table) {
            $table->renameColumn('field_id', 'field');
        });

        Schema::table('corrosions', function (Blueprint $table) {
            $table->renameColumn('field_id', 'field');
        });

        Schema::dropIfExists('fields');
    }

    private function seed() {

        $names = [
            'Узень',
            'Карамандыбас'
        ];

        foreach($names as $name) {
            DB::table('fields')->insert(
                [
                    'name' => $name
                ]
            );
        }
    }
}
