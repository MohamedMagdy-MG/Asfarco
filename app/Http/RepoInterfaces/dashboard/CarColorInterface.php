<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface CarColorInterface
{
                           
    public function getAllCarColors($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}