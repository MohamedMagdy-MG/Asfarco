<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface QuestionInterface
{
                                      
    public function getAllQuestions($search);
    public function getAllQuestionsWithData($search);
    public function Show($id);
    public function Add($data = []);
    public function Edit($data = []);
    public function Delete($id);
    public function Arrange($ids);

                    
}