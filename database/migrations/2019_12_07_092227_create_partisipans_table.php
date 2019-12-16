<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartisipansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partisipans', function (Blueprint $table) {
            $table->bigInteger("id_user")->unsigned();
            $table->bigInteger("id_arena")->unsigned();
            $table->string("score");
            $table->timestamps();
        });

        Schema::table('partisipans',function($table){
            $table->foreign('id_arena')
                    ->references('id_arena')
                    ->on('arenas')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('id_user')
                    ->references('id_user')
                    ->on('users')
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
        Schema::dropIfExists('partisipans');
    }
}
