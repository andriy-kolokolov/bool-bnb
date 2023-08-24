<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    public $timestamps = false;
    protected $fillable = [
        'apartment_id',
        'image_path',
        'is_cover',
    ];

    public function apartment() {
        return $this->belongsTo(Apartment::class);
    }
}
