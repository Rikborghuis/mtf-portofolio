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
        Schema::create('car_info', function (Blueprint $table) {
            $table->id();
            $table->integer('voertuignr_hexon');
            $table->text('merk');
            $table->text('model');
            $table->text('type');
            $table->text('carrosserie');
            $table->integer('aantal_zitplaatsen');
            $table->integer('aantal_deuren');
            $table->enum('aandrijving', ['serieel', 'parallel', 'power-split', 'motorisch']);
            $table->integer('massa');
            $table->text('accessoires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_info');
    }
};
