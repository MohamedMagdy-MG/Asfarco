<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Header extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'image_en',
        'image_ar',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
    ];
    protected $casts = [];
    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::random(4) . '-' . Str::random(4); 
        });
    }
}
