<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolymorphicCostlyColumnsToFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->unsignedInteger('costly_id')->nullable();
            $table->string('costly_type')->nullable();
            $table->unsignedInteger('event_id')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fees', function (Blueprint $table) {
            //
        });
    }
}
