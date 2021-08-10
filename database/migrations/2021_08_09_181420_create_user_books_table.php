<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_books', function (Blueprint $table) {
            $table->id();
            $table->decimal('cost', 5, 2)->comment('Cost');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->comment('User');
            $table->foreignId('book_id')->constrained('books')->onUpdate('cascade')->onDelete('cascade')->comment('Book');
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
        Schema::dropIfExists('user_books');
    }
}
