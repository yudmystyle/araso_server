<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuelAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duel_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("id_user")->unsigned();
            $table->bigInteger("id_duel")->unsigned();
            $table->string("answer");
            $table->string("correct_answer");
            $table->string("question_number");
            $table->timestamps();
        });

        Schema::table('duel_answers',function($table){
            $table->foreign('id_duel')
                    ->references('id_duel')
                    ->on('duels')
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
        Schema::dropIfExists('duel_answers');
    }
}
