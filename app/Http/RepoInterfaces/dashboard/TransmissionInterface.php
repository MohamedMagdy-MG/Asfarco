<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface TransmissionInterface
{
                           
    public function getAllTransmissions($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}