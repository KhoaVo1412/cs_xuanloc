<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchIngredients extends Model
{
    use HasFactory;
    protected $table = 'batch_ingredient';

    protected $fillable = ['batch_id', 'ingredient_id'];
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }
}
