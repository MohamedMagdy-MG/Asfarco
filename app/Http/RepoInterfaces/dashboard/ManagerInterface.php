<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface ManagerInterface
{
                                      
    public function getAllManagers($search);
    public function Add($data = []);
    public function Delete($id);
    public function Active($id);
                    
}