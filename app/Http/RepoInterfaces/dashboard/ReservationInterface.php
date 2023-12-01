<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface ReservationInterface
{
    public function getAllPendingReservation($start_date,$end_date,$search);
    public function getAllOngoingReservation($start_date,$end_date,$search);
    public function getAllCompletedReservation($start_date,$end_date,$search);
    public function getAllCancelledReservation($start_date,$end_date,$search);
                    
}