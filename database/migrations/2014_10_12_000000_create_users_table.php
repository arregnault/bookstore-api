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
            $table->string('name')->comment('Full Name');
            $table->string('email')->unique()->comment('Email');
            $table->integer('account_balance')->default(0)->comment('Account Balance ($)');
            $table->timestamp('email_verified_at')->nullable()->comment('Email Verification Date');
            $table->string('password')->comment('Password');
            $table->rememberToken()->comment('Remember Token');
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
