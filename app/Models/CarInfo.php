<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CarInfo extends Model
{
    protected $table = 'car_info';


    protected $fillable = ['voertuignr_hexon', 'merk', 'model', 'type', 'carrosserie', 'aantal_zitplaatsen', 'aantal_deuren', 'aandrijving', 'massa', 'accessoires'];

    public function scopeFilterByAccessoires($query, $accessoires)
    {
        foreach ($accessoires as $accessoire) {
            $query->where('accessoires', 'like', '%' . $accessoire . '%');
        }

        return $query;
    }
}
