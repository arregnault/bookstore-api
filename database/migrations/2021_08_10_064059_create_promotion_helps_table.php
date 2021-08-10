<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_helps', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 5, 2)->comment('Amount');
            $table->decimal('collected', 5, 2)->default(0)->comment('Collected');
            $table->boolean('is_bankable')->default(0)->comment('Eligible for Funding');
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
        Schema::dropIfExists('promotion_helps');
    }
}
