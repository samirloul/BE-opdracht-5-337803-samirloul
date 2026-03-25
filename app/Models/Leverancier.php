<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'leverancier';
    protected $fillable = ['Naam', 'ContactPersoon', 'LeverancierNummer', 'Mobiel', 'ContactId', 'IsActief', 'Opmerking'];
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'ContactId', 'Id');
    }

    public function productPerLeveranciers()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'LeverancierId', 'Id');
    }
}
