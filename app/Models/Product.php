<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'product';
    protected $fillable = ['Naam', 'Barcode', 'IsActief', 'Opmerking'];
    
    public function productPerAllergeens()
    {
        return $this->hasMany(ProductPerAllergeen::class, 'ProductId', 'Id');
    }

    public function allergeens()
    {
        return $this->belongsToMany(Allergeen::class, 'product_per_allergeen', 'ProductId', 'AllergeenId');
    }

    public function productPerLeveranciers()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'ProductId', 'Id');
    }

    public function magazijns()
    {
        return $this->hasMany(Magazijn::class, 'ProductId', 'Id');
    }
}
