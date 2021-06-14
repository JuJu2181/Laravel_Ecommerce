<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewAndRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_and_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products','id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete;
            $table->float("rating")->default(0);
            $table->text('review');
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
        Schema::dropIfExists('review_and_ratings');
    }
}
