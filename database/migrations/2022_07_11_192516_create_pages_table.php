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

            $table->string("title", 100)->nullable(false);
            $table->string("description")->nullable(false);
            $table->string("cover")->nullable();
            $table->string("lang", 5)->nullable(false)->default(config("app.locale"));
            $table->string("content_type", 6)->nullable(false)->default("text");
            $table->text("content")->nullable(true);
            $table->integer("protection")->nullable(false)->default(Page::PROTECTION_AUTHOR);
            $table->boolean("follow")->nullable(false)->default(true);
            $table->fullText(["title", "description"], "fulltext_index_search");

            $table->string("status", 10)->nullable(false)->default("draft");
            $table->timestamp("published_at")->nullable(true);
            $table->timestamp("scheduled_to")->nullable(true);

            // FOREIGN KEYS
            $table->foreignId("user_id")->unsigned()->nullable(true);
            $table->foreignId("slug_id")->unsigned()->nullable(false);
            $table->foreignId("access_register_id")->unsigned()->nullable(true);

            $table->foreign("user_id")->references("id")->on("users")->nullOnDelete();
            $table->foreign("slug_id")->references("id")->on("slugs")->restrictOnDelete();
            $table->foreign("access_register_id")->references("id")->on("access_registers")->restrictOnDelete();

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
