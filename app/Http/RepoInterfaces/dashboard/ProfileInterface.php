<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface ProfileInterface
{
                                      
    public function Profile();
    public function UpdateProfile($data = []);
    public function Logout();
    public function UpdateFirebaseToken($firebasetoken);
                    
}