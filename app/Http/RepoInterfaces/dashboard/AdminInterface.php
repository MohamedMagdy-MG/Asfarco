<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface AdminInterface
{
                                      
    public function getAllAdmins($search);
    public function Add($data = []);
                    
}