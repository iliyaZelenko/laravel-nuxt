<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->unique();
            $table->string('password')->nullable(); // если через соц сеть то может не быть пароля
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country')->nullable(); // ISO 3166-1
            $table->string('timezone')->default(config('app.timezone'));
            $table->boolean('gender')->nullable();
            $table->date('birthday')->nullable();

            // $table->string('avatar')->nullable();
            $table->json('avatar')->nullable();

            // говорит о том может ли пользователь пользоваться основным функционалом сайта,
            // ставится true если вошел через соц сеть или прикрепил соц сеть или если подтвердил почту
            // $table->boolean('activated');


            // $table->string('email')->nullable()->unique(); // если через соц сеть то может не быть почты
            // подтверждение почты
            // $table->boolean('email_verified'); // подтверждена ли почта?
            // $table->string('email_verification_token')->nullable();


            // $table->timestamp('last_login');
            // $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}


// 15 days visited
//
// 43m read time
//
// 24 topics viewed
//
// 401 posts read
//
// 3  given
//
// 2 topics created
//
// 6 posts created
//
// 1  received
