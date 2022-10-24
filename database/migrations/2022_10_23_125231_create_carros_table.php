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
        Schema::create('carros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("modelo_id");
            $table->string("placa", 10);
            $table->boolean("disponivel");
            $table->integer("km");
            $table->timestamps();

            $table->foreign("modelo_id")->references("id")->on("modelos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carros', function (Blueprint $table) {
            $table->dropForeign("carros_modelo_id_foreign");
        });
        Schema::dropIfExists('carros');
    }
};
