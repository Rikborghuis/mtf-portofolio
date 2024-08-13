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
        Schema::create('tech_info', function (Blueprint $table) {
            $table->id();

            $table->enum('brandstof', [
                'Benzine',
                'Diesel',
                'LPG',
                'LPG G3',
                'Elektrisch',
                'Benzine / Elektrisch',
                'Diesel / Elektrisch',
                'Hybride',
                'Aardgas',
                'Alcohol',
                'Biodiesel',
                'E85',
                'HCNG',
                'Overig'
            ]);
            $table->decimal('gemiddeld_verbruik');
            $table->decimal('verbruik_stad');
            $table->decimal('verbruik_snelweg');
            $table->integer('co2_uitstoot');
            $table->enum('emissieklasse', ['0', '1', '2', '3', '4', '5', '6', '6b', '6c', '6d-TEMP', '6d']);
            $table->enum('transmissie', ['Handgeschakeld', 'Automaat', 'CVT', ' Semi - automaat']);
            $table->integer('aantal_versnellingen');
            $table->integer('cilinder_inhoud');
            $table->integer('cilinder_aantal');
            $table->integer('vermogen_motor_kw');
            $table->integer('topsnelheid');
            $table->integer('acceleratie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tech_info');
    }
};
