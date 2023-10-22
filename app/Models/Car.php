<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;





class Car extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'active',
        'bags',
        'passengers',
        'doors',
        'daily',
        'daily_discount',
        'daily_after_discount',
        'weekly',
        'weekly_discount',
        'weekly_after_discount',
        'monthly',
        'monthly_discount',
        'monthly_after_discount',
        'yearly',
        'yearly_discount',
        'yearly_after_discount',
        'category_id',
        'fuel_id',
        'brand_id',
        'model_id',
        'model_year_id',
        'transmission_id',
        'branch_id',
        'airport_transfer_service',
        'airport_transfer_service_price',
        'deliver_to_my_location',
        'deliver_to_my_location_price'
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

    public function Category(){
        return $this->belongsTo(CarCategory::class,'category_id','uuid');
    }

    public function FuelType(){
        return $this->belongsTo(FuelType::class,'fuel_id','uuid');
    }

    public function Brand(){
        return $this->belongsTo(CarBrand::class,'brand_id','uuid');
    }

    public function Model(){
        return $this->belongsTo(CarModel::class,'model_id','uuid');
    }

    public function ModelYear(){
        return $this->belongsTo(ModelYear::class,'model_year_id','uuid');
    }

    public function Transmission(){
        return $this->belongsTo(Transmission::class,'transmission_id','uuid');
    }

    public function Branch(){
        return $this->belongsTo(Branch::class,'branch_id','uuid');
    }

    public function Images(){
        return $this->hasMany(CarImages::class,'car_id','uuid');
    }

    public function Favourites(){
        return $this->hasMany(CarFavourites::class,'car_id','uuid');
    }

    public function Features(){
        return $this->hasMany(CarFeatures::class,'car_id','uuid');
    }

    public function AdditionalFeatures(){
        return $this->hasMany(CarAdditionalFeatures::class,'car_id','uuid');
    }

    public function Colors(){
        return $this->hasMany(CarHasColors::class,'car_id','uuid');
    }

    public function Reservation(){
        return $this->hasMany(Reservation::class,'car_id','uuid');
    }
}
