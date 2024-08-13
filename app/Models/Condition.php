<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $table = 'condition';
    protected $casts = ['nieuw_voertuig' => 'boolean',];
    protected $fillable = ['tellerstand', 'nieuw_voertuig', 'bouwjaar', 'staat_algemeen',];
}
