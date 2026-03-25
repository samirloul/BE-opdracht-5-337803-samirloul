<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'allergeen';
    protected $fillable = ['Naam', 'Omschrijving', 'IsActief', 'Opmerking'];
    
    public function productPerAllergeens()
    {
        return $this->hasMany(ProductPerAllergeen::class, 'AllergeenId', 'Id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_per_allergeen', 'AllergeenId', 'ProductId');
    }
}
