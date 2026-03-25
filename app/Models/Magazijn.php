<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'magazijn';
    protected $fillable = ['ProductId', 'VerpakkingsEenheid', 'AantalAanwezig', 'IsActief', 'Opmerking'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }
}
