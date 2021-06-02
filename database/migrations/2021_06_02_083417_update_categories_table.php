<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            //adding slug and parent_id 
            $table->string('slug')->unique()->nullable()->after('name');
            $table->unsignedBigInteger('parent_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //delete these two columns 
            $table->dropColumn('slug');
            $table->dropColumn('parent_id');
        });
    }
}
