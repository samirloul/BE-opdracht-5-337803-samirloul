<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerAllergeen extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'product_per_allergeen';
    protected $fillable = ['ProductId', 'AllergeenId', 'IsActief', 'Opmerking'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    public function allergeen()
    {
        return $this->belongsTo(Allergeen::class, 'AllergeenId', 'Id');
    }
}
