<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\QuestionRepo;
use App\Http\Requests\dashboard\Question\AddQuestionRequest;
use App\Http\Requests\dashboard\Question\ArrangeQuestionRequest;
use App\Http\Requests\dashboard\Question\DeleteQuestionRequest;
use App\Http\Requests\dashboard\Question\ShowQuestionRequest;
use App\Http\Requests\dashboard\Question\UpdateQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class QuestionController extends Controller
{
    public $questionRepo;

    public function __construct()
    {
        $this->questionRepo = new QuestionRepo();
        $this->middleware('auth:dashboard');
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

    public function Show(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ShowQuestionRequest::rules(),ShowQuestionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to display question' : $message = 'فشل في اظهار السؤال';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->questionRepo->Show($request->id);
        }   
        
    }

    public function Add(Request $request)
    {
       
        $validator = Validator::make($request->only(["title_en","title_ar","answer_en","answer_ar"]),AddQuestionRequest::rules(),AddQuestionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to add question' : $message = 'فشل إضافة السؤال';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'answer_en' => $request->answer_en,
                'answer_ar' => $request->answer_ar,
            ];
            
            return $this->questionRepo->Add($data);
        }   
        
    }

    public function Edit(Request $request)
    {
       
        $validator = Validator::make($request->only(['id',"title_en","title_ar","answer_en","answer_ar"]),UpdateQuestionRequest::rules(),UpdateQuestionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to modify question data' : $message = 'فشل في تعديل بيانات السؤال';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'answer_en' => $request->answer_en,
                'answer_ar' => $request->answer_ar,
            ];
            
            return $this->questionRepo->Edit($data);
        }   
        
    }


    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteQuestionRequest::rules(),DeleteQuestionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to delete question data' : $message = 'فشل في حذف بيانات السؤال';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->questionRepo->Delete($request->id);
        }   
        
    }

    public function Arrange(Request $request)
    {
        $validator = Validator::make($request->only(['ids']),ArrangeQuestionRequest::rules(),ArrangeQuestionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to arranage questions data' : $message = 'فشل في ترتيبت بيانات الشروط';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->questionRepo->Arrange($request->ids);
        }   
        
    }

    

    


   
    



   

    



}
