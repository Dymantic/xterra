<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbeddableVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embeddable_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('videoed_id');
            $table->string('videoed_type');
            $table->string('platform');
            $table->string('video_id');
            $table->json('title');
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
        Schema::dropIfExists('embeddable_videos');
    }
}
