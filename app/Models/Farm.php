<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;
    protected $table = 'farm';

    protected $fillable = ['farm_code', 'farm_name', 'unit', 'unit_id', 'status'];
    // public function vehicles()
    // {
    //     return $this->hasMany(Vehicle::class);
    // }
    public function plantingAreas()
    {
        return $this->hasMany(PlantingArea::class, 'farm_id', 'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'farm_user', 'farm_id', 'user_id');
    }

    public function unitRelation()
    {
        return $this->belongsTo(Units::class, 'unit_id');
    }
}
