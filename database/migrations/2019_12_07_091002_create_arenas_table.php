<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arenas', function (Blueprint $table) {
            $table->bigIncrements('id_arena');
            $table->bigInteger('id_paketsoal')->unsigned();
            $table->string("uniquecode");
            $table->dateTime("waktu_mulai");
            $table->dateTime("waktu_selesai");
            $table->timestamps();
        });

        Schema::table('arenas',function($table){
            $table->foreign('id_paketsoal')
                    ->references('id_paketsoal')
                    ->on('paketsoals')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arenas');
    }
}
