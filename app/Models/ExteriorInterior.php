<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExteriorInterior extends Model
{
    protected $table = 'exterior_interior';

    protected $fillable = ['basiskleur', 'laksoort', 'interieurkleur', 'bekleding'];
}
