<?php
        
namespace App\Http\RepoInterfaces\frontend;   

interface ProfileInterface
{
                                      
    public function Profile();
    public function UpdateProfile($data = []);
    public function UpdateFirebaseToken($firebasetoken);
    public function UpdateLanguage($language);
    public function UpdateLocation($data);
    public function getAllCities();
    public function AddAddress($data = []);
    public function UpdateAddress($data = []);
    public function DeleteAddress($id);
    public function UpdatePassword($data);
    public function UpdatePasswordWithOutCurrentPassword($data);
    public function AddPayment($data = []);
    public function UpdatePayment($data = []);
    public function DeletePayment($id);
    public function Favourite($id);
    public function GetFavourites();
    public function GetPendingReservations();
    public function GetOngoingReservations();
    public function GetCompletedReservations();
    public function GetCancelledReservations();
    public function ReservationDetails($reservation_id);
    public function Logout();
                    
}