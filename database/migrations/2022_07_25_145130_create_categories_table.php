<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string("title", 25)->nullable(false)->unique()->fulltext();
            $table->string("description", 125)->nullable()->fulltext();
            $table->string("lang", 5)->nullable(false)->default(config("app.locale"));
            $table->foreignId("slug_id")->nullable(false);

            $table->foreign("slug_id")->references("id")->on("slugs")->restrictOnDelete();

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
        Schema::dropIfExists('categories');
    }
}
