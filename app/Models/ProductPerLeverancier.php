<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerLeverancier extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'product_per_leverancier';
    protected $fillable = ['LeverancierId', 'ProductId', 'DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering', 'IsActief', 'Opmerking'];
    
    public function leverancier()
    {
        return $this->belongsTo(Leverancier::class, 'LeverancierId', 'Id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }
}
