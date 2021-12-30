<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsManufacturingProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_manufacturing_programs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                ->references('id')
                ->on('eco_refs_companies_ids');

            $table->unsignedBigInteger('log_id');
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->decimal('dollar_rate', 8, 2);
            $table->decimal('oil_price', 8, 2);

            $table->decimal('oil', 20, 10);
            $table->decimal('oil_from_transfer_wells', 20, 10);
            $table->decimal('oil_from_new_wells', 20, 10);
            $table->decimal('oil_from_gtm', 20, 10);

            $table->decimal('oil_sale', 20, 10);
            $table->decimal('oil_sale_export', 20, 10);
            $table->decimal('oil_sale_local', 20, 10);

            $table->unsignedInteger('wells');
            $table->unsignedInteger('transfer_wells');
            $table->unsignedInteger('new_wells');

            $table->unsignedInteger('prs');
            $table->unsignedInteger('brigade_prs');
            $table->unsignedInteger('krs');

            $table->unsignedInteger('pp');
            $table->unsignedInteger('aup');

            $table->decimal('revenue', 20, 10);
            $table->decimal('expenditures', 20, 10);

            $table->decimal('cost_price', 20, 10);
            $table->decimal('cost_price_variable', 20, 10);
            $table->decimal('cost_price_staff', 20, 10);
            $table->decimal('cost_price_ndpi', 20, 10);
            $table->decimal('cost_price_permanent', 20, 10);
            $table->decimal('cost_price_amort', 20, 10);

            $table->decimal('realization_cost', 20, 10);
            $table->decimal('realization_cost_rent_tax', 20, 10);
            $table->decimal('realization_cost_etp', 20, 10);
            $table->decimal('realization_cost_trans_expenditures', 20, 10);

            $table->decimal('oar_financing_expenditures', 20, 10);

            $table->decimal('revenue_before_tax', 20, 10);
            $table->decimal('kpn', 20, 10);
            $table->decimal('ept', 20, 10);
            $table->decimal('operating_profit', 20, 10);

            $table->decimal('capital_investment', 20, 10);
            $table->decimal('capital_investment_drilling', 20, 10);
            $table->decimal('capital_investment_os', 20, 10);
            $table->decimal('capital_investment_building', 20, 10);
            $table->decimal('capital_investment_other', 20, 10);

            $table->decimal('cash_flow', 20, 10);

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
        Schema::dropIfExists('eco_refs_manufacturing_programs');
    }
}
