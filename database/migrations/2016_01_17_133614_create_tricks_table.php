<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTricksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tricks', function (Blueprint $table) {
            
            $table->increments('id');
            $table->boolean('spam')->default(0);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable()->default(NULL);
            $table->text('code');
            //$table->integer('vote_cache')->unsigned()->default(0);
            //$table->integer('view_cache')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::table('tricks', function($table)
        {
            $table->dropForeign('tricks_user_id_foreign');
        });

        Schema::drop('tricks');
    }
}
