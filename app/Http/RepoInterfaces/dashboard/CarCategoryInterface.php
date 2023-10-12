<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface CarCategoryInterface
{
                           
    public function getAllCarCategories($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}