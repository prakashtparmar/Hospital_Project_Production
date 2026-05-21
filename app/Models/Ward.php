<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'status'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
