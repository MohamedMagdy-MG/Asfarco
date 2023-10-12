<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface BranchEmployeeInterface
{
                                      
    public function getAllBranchEmployees($search,$branch);
    public function getAllBranches($search);
    public function Add($data = []);
    public function Delete($id);
    public function Active($id);
                    
}