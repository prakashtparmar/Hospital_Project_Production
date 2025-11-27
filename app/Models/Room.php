<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = ['ward_id', 'room_no', 'status'];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
}
