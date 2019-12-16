<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->bigIncrements('id_soal');
            $table->bigInteger('id_paketsoal')->unsigned();
            $table->longText('pertanyaan');
            $table->longText('pilihan1');
            $table->longText('pilihan2');
            $table->longText('pilihan3');
            $table->longText('pilihan4');
            $table->integer('jawabanbenar');
            $table->timestamps();
        });

        Schema::table('soals',function($table){
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
        Schema::dropIfExists('soals');
    }
}
