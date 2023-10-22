<?php
        
namespace App\Http\RepoInterfaces\mobile;   

interface ReservationInterface
{
                                      
    public function Address();
    public function Payments();
    public function Features($car_id);
    public function Reserve($data);
    public function Cancel($reservation_id);
    public function CheckCarReservation($data);
    public function Fatora($data);

                    
}