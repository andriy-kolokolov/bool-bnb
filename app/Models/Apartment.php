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
        'is_available',
        'is_sponsored',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function addresses() {
        return $this->hasMany(Address::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function views() {
        return $this->hasMany(View::class);
    }
}
