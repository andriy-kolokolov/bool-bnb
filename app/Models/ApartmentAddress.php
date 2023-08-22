<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentAddress extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'apartment_id',
        'zip',
        'city',
        'address',
        'gps_coordinates'
    ];

    public function apartmentAddress() {
        return $this->belongsTo(Apartment::class);
    }
}
