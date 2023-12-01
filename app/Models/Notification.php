<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Notification extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'uuid',
        'admin_id',
        'model',
        'title_en',
        'title_ar',
        'message_en',
        'message_ar',
        'is_read'
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
