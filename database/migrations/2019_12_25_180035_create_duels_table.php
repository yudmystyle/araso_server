<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duels', function (Blueprint $table) {
            $table->bigIncrements('id_duel');
            $table->bigInteger('id_paketsoal')->unsigned();
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('duels',function($table){
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
        Schema::dropIfExists('duels');
    }
}