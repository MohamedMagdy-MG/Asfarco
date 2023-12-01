<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\QuestionRepo;


class QuestionController extends Controller
{
    public $questionRepo;

    public function __construct()
    {
        $this->questionRepo = new QuestionRepo();
    }




    public function getAllQuestions()
    {
        $search = null;
        if(array_key_exists('search',$_GET)){
            $search = $_GET['search'];
        }
        return $this->questionRepo->getAllQuestions($search);
    }

    public function getAllQuestionsWithData()
    {
        $search = null;
        if(array_key_exists('search',$_GET)){
            $search = $_GET['search'];
        }
       
        return $this->questionRepo->getAllQuestionsWithData($search);
    }

   
    

    


   
    



   

    



}
