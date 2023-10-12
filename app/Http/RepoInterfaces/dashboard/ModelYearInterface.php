<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface ModelYearInterface
{
                           
    public function getAllModelYears($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}