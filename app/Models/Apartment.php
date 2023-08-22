<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model {
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'name',
        'rooms',
        'beds',
        'bathrooms',
        'square_meters',
        'images',
        'is_available',
        'sponsor',
        'zip',
        'city',
        'address',
        'gps_coordinates',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    public function images() {
        return $this->hasMany(ApartmentImage::class);
    }

    public function address() {
        return $this->hasOne(ApartmentAdress::class);
    }


}
