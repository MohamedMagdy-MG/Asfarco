<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;



class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code','name_en','name_ar','nationality_en','nationality_ar'
    ];
    protected $casts = [];
    protected $hidden = [];


    

    
}
