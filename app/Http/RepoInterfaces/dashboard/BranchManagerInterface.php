<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface BranchManagerInterface
{
                                      
    public function getAllBranchManagers($search,$branch);
    public function getAllBranches($search);
    public function Add($data = []);
    public function Delete($id);
    public function Active($id);
                    
}