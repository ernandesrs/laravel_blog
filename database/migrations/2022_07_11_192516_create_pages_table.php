<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string("title")->fulltext()->nullable(false);
            $table->string("description")->fulltext()->nullable(false);
            $table->string("cover")->nullable();
            $table->string("lang", 5)->nullable(false)->default(config("app.locale"));
            $table->string("content_type")->nullable(false)->default("text");
            $table->string("content")->nullable(true);
            $table->integer("protection")->nullable(false)->default(Page::PROTECTION_AUTHOR);
            $table->boolean("follow")->nullable(false)->default(true);

            $table->string("status")->nullable(false)->default("draft");
            $table->timestamp("published_at")->nullable(true);
            $table->timestamp("scheduled_to")->nullable(true);

            // FOREIGN KEYS
            $table->foreignId("author")->unsigned()->nullable(true);
            $table->foreignId("slug")->unsigned()->nullable(false);

            $table->foreign("author")->references("id")->on("users")->nullOnDelete();
            $table->foreign("slug")->references("id")->on("slugs")->restrictOnDelete();

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
        Schema::dropIfExists('pages');
    }
}
