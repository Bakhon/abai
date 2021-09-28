<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGtmDeclineRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paegtm_gtm_decline_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('org_id');
            $table->string('dzo_name')->nullable();
            $table->string('dzo_name_short')->nullable();
            $table->unsignedBigInteger('geo_id');
            $table->string('oilfield')->nullable();
            $table->date('date');
            $table->float('base_fund', 12, 8);
            $table->float('vns', 12, 8);
            $table->float('vns_grp', 12, 8);
            $table->float('gs', 12, 8);
            $table->float('gs_grp', 12, 8);
            $table->float('zbs', 12, 8);
            $table->float('zbgs', 12, 8);
            $table->float('ugl', 12, 8);
            $table->float('grp', 12, 8);
            $table->float('vbd', 12, 8);
            $table->float('pvlg', 12, 8);
            $table->float('rir', 12, 8);
            $table->float('pvr', 12, 8);
            $table->float('opz', 12, 8);
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
        Schema::dropIfExists('paegtm_gtm_decline_rates');
    }
}
