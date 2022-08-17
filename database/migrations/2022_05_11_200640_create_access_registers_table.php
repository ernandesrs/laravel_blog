<?php

use App\Models\AccessRegister;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_registers', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100)->nullable(false)->comment("Nome da rota");
            $table->json("params")->nullable(false)->comment("Parãmetros da rota");

            $table->integer("access")->nullable(false)->default(0)->comment("Todos acessos");
            $table->integer("weekly_access")->nullable(false)->default(0)->comment("Acessos semanais");
            $table->json("daily_access_register")->nullable(false)->default(json_encode(AccessRegister::weekDays))->comment("Registro de acessos nos dias da semana");

            $table->timestamp("week_started_in")->nullable(false)->default(date("Y-m-d H:i:s"))->comment("Data do ínicio da semana");

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
        Schema::dropIfExists('access_registers');
    }
}
