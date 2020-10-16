<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('album_categories');
        Schema::create('album_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 64)->unique();
            // $table->foreignId('user_id')->index()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });

        // TABELLA PIVOT
        Schema::dropIfExists('album_category');
        Schema::create('album_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id');
            $table->foreignId('category_id');
            $table->unique(['album_id', 'category_id']);
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
        Schema::dropIfExists('album_categories');
    }
}
