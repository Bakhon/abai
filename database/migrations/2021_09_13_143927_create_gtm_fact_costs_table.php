<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGtmFactCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paegtm_refs_gtm_fact_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('org_id')->nullable();
            $table->string('dzo_name');
            $table->string('dzo_name_short');
            $table->unsignedBigInteger('geo_id')->nullable();
            $table->string('oilfield');
            $table->string('well_name');
            $table->unsignedBigInteger('gtm_type_id')->nullable();
            $table->string('gtm_name');
            $table->date('gtm_date');
            $table->float('price', 12, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paegtm_refs_gtm_fact_costs');
    }
}
