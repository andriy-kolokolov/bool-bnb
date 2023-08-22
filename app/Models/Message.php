<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    public $timestamps = false;
    protected $fillable = ['user_id', 'message', 'email'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
