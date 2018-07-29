<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialiteTablesAndModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialite_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // vkontakte
            $table->string('name_for_human'); // Вконтакте
            $table->string('icon');
            $table->string('color');
            $table->string('text_color')->nullable();
        });

        Schema::create('socialite_provider_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('socialite_provider_id');
            $table->string('uid'); // id profile from provider
            $table->string('token');
            $table->string('expiresIn')->nullable(); // только инстаграм null
            $table->string('refreshToken')->nullable();

            $table->unique(['user_id', 'socialite_provider_id']);
            $table->unique(['socialite_provider_id', 'uid']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table->foreign('socialite_provider_id')
                ->references('id')
                ->on('socialite_providers')
                ->onDelete('CASCADE');
            $table->timestamps();
        });

        Schema::table('users', function ($table) {
            $table->unsignedInteger('created_through_soc_acc')->nullable(); // сделал акк через соц акк или через обычную форму регистрации
            $table->unsignedInteger('signin_through_soc_acc')->nullable(); // через какой акк вошел

            $table->foreign('created_through_soc_acc')
                ->references('id')
                ->on('socialite_providers')
                ->onDelete('set null');
            $table->foreign('signin_through_soc_acc')
                ->references('id')
                ->on('socialite_providers')
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
            // почему-то нельзя было сделать через один массив
            $table->dropForeign(['created_through_soc_acc']);
            $table->dropForeign(['signin_through_soc_acc']);
        });

        Schema::dropIfExists('socialite_provider_user');
        Schema::dropIfExists('socialite_providers');
    }
}
