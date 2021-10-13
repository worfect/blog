<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


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
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->string('login');
            $table->string('screen_name');
            $table->string('password');
            $table->string('role');

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->string('verify_code')->nullable();
            $table->timestamp('expired_token')->nullable();
            $table->boolean('phone_confirmed')->default(false);
            $table->boolean('email_confirmed')->default(false);
            $table->rememberToken();
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
