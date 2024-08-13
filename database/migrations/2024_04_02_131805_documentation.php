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
        Schema::create('documentation', function (Blueprint $table) {
            $table->id();
            $table->date('apk_tot')->nullable();
            $table->boolean('apk_bij_aflevering');
            $table->text('kenteken');
            $table->enum('btw_marge', ['Marge-regeling', 'BTW-voertuig']);
            $table->text('belasting');
            $table->date('fabrieksgarantie_tot')->nullable();
            $table->boolean('nap_weblabel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('documentation');
    }
};
