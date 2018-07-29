<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('email')->unique();
            $table->string('label')->nullable(); // метка
            $table->boolean('verified'); // подтверждена ли почта?
            $table->boolean('public'); // публичный?
            $table->string('verification_token')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });


        Schema::table('users', function ($table) {
            // почта для уведомлений
            $table->unsignedInteger('main_email_id')->nullable();

            $table->foreign('main_email_id')
                ->references('id')
                ->on('emails')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropForeign(['main_email_id']);
        });

        Schema::dropIfExists('emails');
    }
}
