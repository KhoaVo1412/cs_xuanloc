<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExport extends Model
{
    use HasFactory;


    protected $table = 'order_exports';

    protected $fillable = ['code', 'contract_id'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function batches()
    {
        return $this->hasMany(Batch::class, 'order_export_id');
    }
    public function exportFile()
    {
        return $this->hasMany(OrderExportFile::class, 'order_export_id', 'id');
    }
}
