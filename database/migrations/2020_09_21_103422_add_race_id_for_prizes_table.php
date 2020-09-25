<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaceIdForPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prizes', function (Blueprint $table) {
            $table->unsignedInteger('event_id')->change()->nullable();
            $table->unsignedInteger('activity_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prizes', function (Blueprint $table) {
            //
        });
    }
}
