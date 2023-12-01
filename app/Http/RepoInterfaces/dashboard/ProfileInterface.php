<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface ProfileInterface
{
                                      
    public function Profile();
    public function UpdateProfile($data = []);
    public function Logout();
    public function UpdateFirebaseToken($firebasetoken);
    public function UpdateLanguage($language);
    public function getAllNotificationsCount();
    public function getAllNotifications();
    public function Delete($id);
    public function ReadAll($model);

                    
}