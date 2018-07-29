<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');

            $table->string('country'); // ISO 3166-1 alpha-3
            $table->string('country2')->nullable(); // ISO 3166-1 alpha-2
            $table->string('prefix');
            $table->string('number'); // интернациональный формат без префикса
            $table->string('label')->nullable();
            $table->boolean('verified'); // подтвержден?
            $table->boolean('public'); // публичный?
            $table->string('sms_verification_code')->nullable(); // длина - 5
            $table->timestamps();

            $table->unique(['number', 'prefix']);
            $table->unique(['prefix', 'number']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });


        Schema::table('users', function ($table) {
            // почта для уведомлений
            $table->unsignedInteger('main_phone_id')->nullable();

            $table->foreign('main_phone_id')
                ->references('id')
                ->on('phones')
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
            $table->dropForeign(['main_phone_id']);
        });

        Schema::dropIfExists('phones');
    }
}
