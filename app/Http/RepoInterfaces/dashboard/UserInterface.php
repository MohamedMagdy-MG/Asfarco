<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface UserInterface
{
                                      
    public function getAllPendingUsers($search);
    public function getAllDeactiveUsers($search);
    public function getAllUnVerificationsUsers($search);
    public function getAllActiveUsers($search);
    public function Active($id);
    public function VerifyDocument($id);
                    
}