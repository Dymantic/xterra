<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidAndConversionsDiskColumnsToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->string('conversions_disk')->nullable();
        });

        \Spatie\MediaLibrary\MediaCollections\Models\Media::eachById(function($media) {
            $media->update([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'conversions_disk' => $media->disk,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            //
        });
    }
}
