<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantingArea extends Model
{
    use HasFactory;
    protected $table = 'plantingarea';

    protected $fillable = [
        'farm_id',
        'fid',
        'idmap',
        'ma_lo',
        'hien_trang',
        'layer',
        'nha_sx',
        'quoc_gia',
        'plot',
        'nam_trong',
        'chi_tieu',
        'dien_tich',
        'tapping_y',
        'repl_time',
        'find',
        'webmap',
        'gwf',
        'xa',
        'huyen',
        'nguon_goc_lo',
        'nguon_goc_dat',
        'hang_dat',
        'x',
        'y',
        'chu_thich',
        'geo',
        'pdf',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_plantingarea');
    }
}
