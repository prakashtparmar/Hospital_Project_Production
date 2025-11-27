<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bed extends Model
{
    use SoftDeletes;

    protected $fillable = ['room_id', 'bed_no', 'is_occupied', 'status'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
