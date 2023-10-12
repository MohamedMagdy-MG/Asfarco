<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class ReservationColor extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'name_en',
        'name_ar',
        'hexa_code',
        'reservation_id',
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

    public function Reservation(){
        return $this->belongsTo(Reservation::class,'reservation_id','uuid');
    }
}
