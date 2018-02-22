<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('url', 50);
            $table->string('location', 30);
            $table->integer('genre_id')->unsigned();
            $table->foreign('genre_id')
                ->references('id')->on('genres')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('tags', 255);
            $table->text('bio');
            $table->string('websites', 255)->nullable();
            $table->string('social_links', 255)->nullable();
            $table->string('email', 50);
            $table->string('profile_picture', 50)->nullable();
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
        Schema::dropIfExists('artists');
    }
}
