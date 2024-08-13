<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechInfo extends Model
{
    protected $table = 'tech_info';

    protected $fillable = ['brandstof', 'gemiddeld_verbruik', 'verbruik_stad', 'verbruik_snelweg', 'co2_uitstoot', 'emissie_klasse', 'transmissie', 'aantal_versnellingen', 'cilinder_inhoud', 'cilinder_aantal', 'vermogen_motor_kw', 'topsnelheid', 'acceleratie'];
}
