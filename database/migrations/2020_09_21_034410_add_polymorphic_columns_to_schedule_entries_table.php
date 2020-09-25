<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolymorphicColumnsToScheduleEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_entries', function (Blueprint $table) {
            $table->unsignedInteger('scheduled_id')->nullable();
            $table->string('scheduled_type')->nullable();
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
        Schema::table('schedule_entries', function (Blueprint $table) {
            //
        });
    }
}
