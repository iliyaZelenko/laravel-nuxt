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

            // $table->string('prefix'); // +380
            $table->string('country'); // ISO 3166-1 alpha-3
            $table->string('country2')->nullable(); // ISO 3166-1 alpha-2
            $table->string('prefix');
            $table->string('number'); // ->unique(); интернациональный формат                    не 0960652658 Формат: \libphonenumber\PhoneNumberFormat::NATIONAL(национальный, не интернациональный, то есть как внутри страны, но когда выдается то преобразуется во всемирный через поле country)
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
        Schema::dropIfExists('phones');

        Schema::table('users', function ($table) {
            $table->dropColumn('main_phone_id');
        });
    }
}
