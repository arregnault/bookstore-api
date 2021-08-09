<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Title');
            $table->string('isbn')->comment('ISBN Code');
            $table->string('publisher')->comment('Publisher');
            $table->decimal('price', 5, 2)->comment('Price');
            $table->integer('year')->comment('Year');
            $table->integer('quantity')->comment('Quantity for sale');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->comment('Author');
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
        Schema::dropIfExists('books');
    }
}
