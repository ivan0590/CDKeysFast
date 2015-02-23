<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name', 100)->nullable();
            $table->string('surname', 100)->nullable();
            $table->morphs('userable');
            $table->boolean('confirmed');
            $table->string('confirmation_code', 30);
            $table->string('change_email_code', 30);
            $table->string('change_email')->unique()->nullable();
            $table->string('change_password_code', 30);
            $table->string('change_password')->nullable();
            $table->string('unsuscribe_code', 30);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
