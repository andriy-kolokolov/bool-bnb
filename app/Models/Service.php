<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    public $timestamps = false;
    protected $fillable = [
        'name',
        'icon',
    ];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
