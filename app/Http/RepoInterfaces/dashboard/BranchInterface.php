<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface BranchInterface
{
                           
    public function getAllCities();
    public function getAllBranches($search,$city);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
    public function Active($id);
                    
}