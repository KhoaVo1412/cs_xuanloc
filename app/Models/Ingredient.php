<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = "ingredients";
    protected $fillable = [
        'farm_id',
        'type_of_pus_id',
        'vehicle_number_id',
        'trip',
        'received_date',
        'received_factory_id',
        'harvesting_date',
        'end_harvest_date',
    ];
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }
    public function typeOfPus()
    {
        return $this->belongsTo(TypeOfPus::class, 'type_of_pus_id', 'id');
    }
    public function factory()
    {
        return $this->belongsTo(Factory::class, 'received_factory_id', 'id');
    }
    public function plantingAreas()
    {
        return $this->belongsToMany(PlantingArea::class, 'ingredient_plantingarea');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_number_id');
    }
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_ingredient', 'ingredient_id', 'batch_id')
            ->withTimestamps();
    }
}
