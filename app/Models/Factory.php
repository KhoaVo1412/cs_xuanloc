<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    use HasFactory;
    protected $table = 'factory';

    protected $fillable = ['factory_name', 'factory_code', 'status'];
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'received_factory_id');
    }
}
