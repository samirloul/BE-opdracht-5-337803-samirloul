<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $table = 'contact';
    protected $fillable = ['Straat', 'Huisnummer', 'Postcode', 'Stad', 'IsActief', 'Opmerking'];
    
    public function leveranciers()
    {
        return $this->hasMany(Leverancier::class, 'ContactId', 'Id');
    }
}
