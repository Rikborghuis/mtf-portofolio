<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('documentation_id');
            $table->unsignedBigInteger('tech_info_id');
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('car_info_id');

            $table->unsignedBigInteger('exterior_interior_id');


            $table->integer('verkoopprijs_particulier');
            $table->text('opmerkingen');
            $table->text('highlights');
            $table->integer('lease_maandbedrag')->nullable();
            $table->integer('actieprijs')->nullable();

            $table->timestamps();

            $table->foreign('documentation_id')->references('id')->on('documentation');
            $table->foreign('tech_info_id')->references('id')->on('tech_info');
            $table->foreign('condition_id')->references('id')->on('condition');
            $table->foreign('car_info_id')->references('id')->on('car_info');


            $table->foreign('exterior_interior_id')->references('id')->on('exterior_interior');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::dropIfExists('post');
    }
};
