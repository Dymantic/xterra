<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('article_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('language');
            $table->string('title');
            $table->text('intro')->nullable();
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->string('author_name')->nullable();
            $table->date('first_published_on')->nullable();
            $table->date('published_on')->nullable();
            $table->boolean('is_published')->default(0);
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
        Schema::dropIfExists('translations');
    }
}
