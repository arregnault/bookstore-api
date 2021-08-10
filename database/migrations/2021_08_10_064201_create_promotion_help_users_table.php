<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionHelpUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_help_users', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 5, 2)->comment('Amount');
            $table->foreignId('promotion_help_id')->constrained('promotion_helps')->onUpdate('cascade')->onDelete('cascade')->comment('Promotion');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->comment('User');

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
        Schema::dropIfExists('promotion_help_users');
    }
}
