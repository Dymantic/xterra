<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->uuid('slug')->nullable();
            $table->boolean('is_public')->default(0);
            $table->json('location');
            $table->json('venue_name');
            $table->json('venue_address');
            $table->string('venue_maplink')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('registration_link')->nullable();
            $table->json('overview');
            $table->string('results_link')->nullable();
            $table->string('travel_guide')->nullable();
            $table->string('travel_guide_disk')->nullable();
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
        Schema::dropIfExists('events');
    }
}
