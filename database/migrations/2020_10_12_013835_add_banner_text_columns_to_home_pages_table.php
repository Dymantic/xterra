<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerTextColumnsToHomePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->string('banner_heading')->nullable();
            $table->string('banner_subheading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->dropColumn(['banner_heading', 'banner_subheading']);
        });
    }
}
