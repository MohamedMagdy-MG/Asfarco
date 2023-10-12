<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Branch extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'longitude',
        'latitude',
        'active',
        'city_id'
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

    public function Admins(){
        return $this->hasMany(Admin::class,'branch_id','uuid');
    }

    public function City(){
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function Cars(){
        return $this->hasMany(Branch::class,'branch_id','uuid');
    }
}
