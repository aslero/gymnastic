<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('article_id')->unsigned();
            $table->foreign('article_id')
                ->references('id')->on('articles')
                ->onDelete('cascade');
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('article_galleries');
    }
}
