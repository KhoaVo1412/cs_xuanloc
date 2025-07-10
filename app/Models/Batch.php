<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $table = "batches";
    protected $fillable = [
        'batch_code',
        'date_sx',
        'received_date',
        'batch_weight',
        'banh_weight',
        'order_export_id',
        'status',
        'type',
        'qr_code',
        'note',
        'created_at'
    ];
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'batch_ingredient', 'batch_id', 'ingredient_id')
            ->withTimestamps();
    }

    public function testingResult()
    {
        return $this->hasOne(TestingResult::class, 'batch_id');
    }
    public function orderExport()
    {
        return $this->belongsTo(OrderExport::class, 'order_export_id');
    }
}
