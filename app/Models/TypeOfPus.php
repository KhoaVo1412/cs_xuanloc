<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfPus extends Model
{
    use HasFactory;
    protected $table = 'typeofpus';
    protected $fillable = [
        'code_pus',
        'name_pus',
        'status',
    ];
}
