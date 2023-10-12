<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;



class City extends Model
{
    use HasFactory;

    protected $fillable = [
       'name_en','name_ar'
    ];
    protected $casts = [];
    protected $hidden = [];


    

    
}
