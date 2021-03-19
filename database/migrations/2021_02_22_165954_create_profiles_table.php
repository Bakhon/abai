<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'profiles',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->timestamp('birthday')->nullable();
                $table->enum('gender', ['male', 'female'])->nullable();
                $table->string('city')->nullable();
                $table->string('position')->nullable();
                $table->string('org')->nullable();
                $table->string('department')->nullable();
                $table->string('sector')->nullable();
                $table->string('boss')->nullable();
                $table->string('phone')->nullable();
                $table->string('cabinet')->nullable();
                $table->string('mobile')->nullable();
                $table->string('email')->nullable();
                $table->string('phone_work')->nullable();
                $table->text('thumb')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );

        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->dropColumn('thumb');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');

        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->text('thumb')->nullable();
            }
        );
    }
}
