<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });

        \App\Occasions\Activity::eachById(function($activity) {
            if(!$activity->slug) {
                $activity->update(['slug' => \App\UniqueKey::for('activities:slug')]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
