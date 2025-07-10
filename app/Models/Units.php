<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $table = 'units';

    protected $fillable = ['unit_name', 'status'];
    public function farms()
    {
        return $this->hasMany(Farm::class, 'unit_id', 'id');
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'unit_id', 'id');
    }
}
