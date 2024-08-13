<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->cascadeOnDelete();
            $table->text('bestandsnaam');
            $table->integer('nr');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('post');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};
