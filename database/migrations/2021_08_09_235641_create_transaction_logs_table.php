<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('Type');
            $table->string('description')->comment('Description');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade')->comment('User');
            $table->foreignId('user_book_id')->nullable()->constrained('user_books')->onUpdate('cascade')->onDelete('cascade')->comment('Book Reservation');
            $table->foreignId('book_id')->nullable()->constrained('books')->onUpdate('cascade')->onDelete('cascade')->comment('Book');
            $table->foreignId('author_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade')->comment('Authors');
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
        Schema::dropIfExists('transaction_logs');
    }
}
