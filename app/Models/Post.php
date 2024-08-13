<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use League\CommonMark\Node\Block\Document;
use PhpParser\Node\Expr\Cast;

class Post extends Model
{

    use HasFactory;

    protected $table = 'post';

    protected $fillable =  ['documentation_id', 'tech_info_id', 'condition_id', 'car_info_id', 'exterior_interior_id', 'verkoopprijs_particulier', 'opmerkingen', 'highlights', 'lease_maandbedrag', 'actieprijs', 'afbeeldingen'];

    protected $casts = [


        'actieprijs' => 'array',

        'highlights' => 'array',

    ];


    public function carinfo(): HasOne
    {
        return $this->hasOne(CarInfo::class, 'id');
    }

    public function condition(): HasOne
    {
        return $this->hasOne(Condition::class, 'id');
    }

    public function docu(): HasOne
    {
        return $this->hasOne(Documentation::class, 'id');
    }

    public function looks(): HasOne
    {
        return $this->hasOne(ExteriorInterior::class, 'id');
    }


    public function techinfo(): HasOne
    {
        return $this->hasOne(TechInfo::class, 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'post_id');
    }
}
