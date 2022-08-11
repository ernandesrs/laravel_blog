<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->string("name", 30)->nullable(false);
            $table->string("tags", 100)->nullable(false);
            $table->string("extension", 6)->nullable(false);
            $table->integer("size")->nullable(false);
            $table->string("path")->nullable(false);
            $table->fullText(["name", "tags"], "fulltext_index_search");

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
        Schema::dropIfExists('images');
    }
}
