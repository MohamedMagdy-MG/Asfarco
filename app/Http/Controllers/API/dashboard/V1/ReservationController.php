<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\ReservationRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    public $reservationRepo;

    public function __construct()
    {
        $this->reservationRepo = new ReservationRepo();
        $this->middleware('auth:dashboard');
    }




    public function getAllPendingReservation()
    {
        $start_date = null;
        if(array_key_exists('start_date',$_GET)){
            $start_date = $_GET['start_date'];
        }
        $end_date = null;
        if(array_key_exists('end_date',$_GET)){
            $end_date = $_GET['end_date'];
        }
        $search = null;
        if(array_key_exists('search',$_GET)){
            $search = $_GET['search'];
        }
        return $this->reservationRepo->getAllPendingReservation($start_date,$end_date,$search);
    }

    public function getAllOngoingReservation(){

        $start_date = null;
        if(array_key_exists('start_date',$_GET)){
            $start_date = $_GET['start_date'];
        }
        $end_date = null;
        if(array_key_exists('end_date',$_GET)){
            $end_date = $_GET['end_date'];
        }
        $search = null;
        if(array_key_exists('search',$_GET)){
            $search = $_GET['search'];
        }
        return $this->reservationRepo->getAllOngoingReservation($start_date,$end_date,$search);

    }
    public function getAllCompletedReservation(){

        $start_date = null;
        if(array_key_exists('start_date',$_GET)){
            $start_date = $_GET['start_date'];
        }
        $end_date = null;
        if(array_key_exists('end_date',$_GET)){
            $end_date = $_GET['end_date'];
        }
        $search = null;
        if(array_key_exists('search',$_GET)){
            $search = $_GET['search'];
        }
        return $this->reservationRepo->getAllCompletedReservation($start_date,$end_date,$search);

    }
    public function getAllCancelledReservation(){
        $start_date = null;
        if(array_key_exists('start_date',$_GET)){
            $start_date = $_GET['start_date'];
        }
        $end_date = null;
        if(array_key_exists('end_date',$_GET)){
            $end_date = $_GET['end_date'];
        }
        $search = null;
        if(array_key_exists('search',$_GET)){
            $search = $_GET['search'];
        }
        return $this->reservationRepo->getAllCancelledReservation($start_date,$end_date,$search);

    }
   

    

    


}
