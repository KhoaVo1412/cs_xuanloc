<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestingResult extends Model
{
    protected $table = 'testing_results';


    protected $fillable = [
        'batch_id',
        'svr_impurity',
        'svr_ash',
        'svr_volatile',
        'svr_nitrogen',
        'svr_po',
        'svr_pri',
        'svr_width',
        'svr_viscous',
        'svr_vul',
        'svr_color',
        'svr_vr',
        'latex_tsc',
        'latex_drc',
        'latex_nrs',
        'latex_nh3',
        'latex_mst',
        'latex_vfa',
        'latex_koh',
        'latex_ph',
        'latex_coagulant',
        'latex_residue',
        'latex_mg',
        'latex_mn',
        'latex_cu',
        'latex_acid_boric',
        'latex_surface_tension',
        'latex_viscosity',
        'rss_impurity',
        'rss_ash',
        'rss_volatile',
        'rss_nitrogen',
        'rss_po',
        'rss_pri',
        'rss_vr',
        'rss_aceton',
        'rss_tensile_strength',
        'rss_elongation',
        'rss_vulcanization',
        'ngay_gui_mau',
        'ngay_kiem_nghiem',
        'rank'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
