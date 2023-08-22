<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentImage extends Model {
    public $timestamps = false;
    protected $fillable = ['apartment_id', 'image_path'];

    public function apartmentImage() {
        return $this->belongsTo(Apartment::class);
    }
}
