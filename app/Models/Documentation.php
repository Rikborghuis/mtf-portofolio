<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Documentation extends Model

{
    protected $table = 'documentation';

    protected $fillable = ['apk_tot', 'apk_bij_aflevering', 'kenteken', 'btw_marge', 'belasting', 'fabrieksgarantie_tot', 'nap_weblabel'];




    public function setFabriekGarantieTot($value)
    {

        if (strlen($value)) {
            $this->attributes['fabrieksgarantie_tot'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['fabrieksgarantie_tot'] = null;
        }
    }
}
