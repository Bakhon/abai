<?php

use App\Models\Refs\Gu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNgduColumnForGu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'gus',
            function (Blueprint $table) {
                $table->bigInteger('ngdu_id')->unsigned()->nullable();
            }
        );

        Schema::table('gus', function (Blueprint $table) {
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
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
        Schema::table('gus', function (Blueprint $table) {
            $table->dropForeign('gus_ngdu_id_foreign');
            $table->dropIndex('gus_ngdu_id_foreign');
        });

        Schema::table(
            'gus',
            function (Blueprint $table) {
                $table->dropColumn('ngdu_id');
            }
        );
    }

    public function seed()
    {
        $zus = DB::table('zus')->distinct()->select('gu_id', 'ngdu_id')->get();
        foreach ($zus as $zu) {
            $gu = Gu::find($zu->gu_id);
            $gu->ngdu_id = $zu->ngdu_id;
            $gu->save();
        }
    }
}
