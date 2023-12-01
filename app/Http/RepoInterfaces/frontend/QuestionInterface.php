<?php
        
namespace App\Http\RepoInterfaces\frontend;   

interface QuestionInterface
{
                                      
    public function getAllQuestions($search);
    public function getAllQuestionsWithData($search);

                    
}