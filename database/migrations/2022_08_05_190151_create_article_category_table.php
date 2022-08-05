<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_category', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId("article_id")->unsigned()->nullable(true);
            $table->foreignId("category_id")->unsigned()->nullable(false);

            $table->foreign("article_id")->references("id")->on("articles")->nullOnDelete();
            $table->foreign("category_id")->references("id")->on("categories")->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_category');
    }
}
