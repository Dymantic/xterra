<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dymantic_instagram_basic_profiles', function (Blueprint $table) {
            $table->string('identity_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dymantic_instagram_basic_profiles', function (Blueprint $table) {
            $table->dropColumn('identity_token');
        });
    }
};
