<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;



class Reservation extends Model
{
    use HasFactory,SoftDeletes;
    // mode => Daily,Weekly,Monthly,Yearly
    // payment_mode => Cash,Visa,Bitcoin
    // status => Pending,Ongoing,Completed,Cancelled

    protected $fillable = [
        'uuid',
        'pickup',
        'return',
        'car_id',
        'user_id',
        'mode',
        'payment_mode',
        'status',
        'cancelled_on',
    ];
    protected $casts = [];
    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = rand(1000000, 9999999) . '-' . Str::random(1); 
        });
    }

    public function Car(){
        return $this->belongsTo(Car::class,'car_id','uuid');
    }


    public function User(){
        return $this->belongsTo(User::class,'user_id','uuid');
    }

    public function Color(){
        return $this->hasOne(ReservationColor::class,'reservation_id','uuid');
    }

    public function Price(){
        return $this->hasOne(ReservationPrice::class,'reservation_id','uuid');
    }

    public function Address(){
        return $this->hasOne(ReservationAddress::class,'reservation_id','uuid');
    }

    public function Features(){
        return $this->hasMany(ReservationFeature::class,'reservation_id','uuid');
    }

    public function Payment(){
        return $this->hasOne(ReservationPayment::class,'reservation_id','uuid');
    }

}
