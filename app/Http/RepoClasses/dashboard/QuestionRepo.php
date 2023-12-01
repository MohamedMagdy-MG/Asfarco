<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\QuestionInterface;
use App\Http\Resources\dashboard\QuestionResource;
use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;

class QuestionRepo implements QuestionInterface
{
       
    
    public $question;
    public function __construct()
    {
        $this->question = new Question();
    }

        
    public function getAllQuestions($search){
    
        $question = $this->question;
        if($search != null){
            $question = $question->where(function(Builder $query) use($search){
                $query->where('title_en','LIKE','%'.$search.'%')
                ->orWhere('title_ar','LIKE','%'.$search.'%');
            });
            
        }
        $question = $question->orderBy('arrange','ASC')->paginate(10);
        $data = [
            'Questions' => QuestionResource::collection($question),
            'Pagination' => [
                'total'       => $question->total(),
                'count'       => $question->count(),
                'perPage'     => $question->perPage(),
                'currentPage' => $question->currentPage(),
                'totalPages'  => $question->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Successfully obtained all question' : $message = 'تم الحصول على جميع الاسئلة بنجاح ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllQuestionsWithData($search){
        
        $question = $this->question;
        if($search != null){
            $question = $question->where(function(Builder $query) use($search){
                $query->where('title_en','LIKE','%'.$search.'%')
                ->orWhere('title_ar','LIKE','%'.$search.'%');
            });
            
        }
        $question = $question->orderBy('arrange','ASC')->get();
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Successfully obtained all question' : $message = 'تم الحصول على جميع الاسئلة بنجاح ';

        return Helper::ResponseData(QuestionResource::collection($question),$message,true,200);
    }

    public function Show($id){   
        
        $question = $this->question->where('uuid',$id)->first();
        if(!$question){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'question Not Found' : $message = 'لم يتم العثور على السؤال';
            return Helper::ResponseData(null,$message,false,404);
        }
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The question data display process was completed successfully' : $message = 'تمت عملية عرض بيانات الاسئلة بنجاح ';

        return Helper::ResponseData(new QuestionResource($question),$message,true,200);

        

    }
    
    public function Add($data = []){ 
        $find_question = $this->question->where('title_en',$data['title_en'])->first();
        if($find_question){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to add question' : $message = 'فشل إضافة السؤال';

            $title_error_ar =  'حقل السؤال (باللغة الإنجليزية) موجود بالفعل.';
            $title_error_en = 'The Title ( English ) field is already exists.';
            return Helper::ResponseData(null,$message,false,400,[
                [
                    'title_en' => $language == 'ar' ? $title_error_ar : $title_error_en
                ]
            ]);
        }
        $find_question = $this->question->where('title_ar',$data['title_ar'])->first();
        if($find_question){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to add question' : $message = 'فشل إضافة السؤال';

            $title_error_ar = 'حقل السؤال (باللغة العربية) موجود بالفعل.';
            $title_error_en =  'The Title ( Arabic ) field is already exists.';
            return Helper::ResponseData(null,$message,false,400,[
                [
                    'title_ar' => $language == 'ar' ? $title_error_ar : $title_error_en
                ]
            ]);
        }
        if($this->question->orderBy('arrange','DESC')->count() > 0){
            $arrange = $this->question->orderBy('arrange','DESC')->first()->arrange;
        }else{
            $arrange = 1;
        }
        $questionData = [
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'answer_en' => $data['answer_en'],
            'answer_ar' => $data['answer_ar'],
            'arrange' => $arrange,
        ];
        $question = $this->question->create($questionData);
        
       
        

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process of adding the question was completed successfully' : $message = 'تمت عملية إضافة السؤال بنجاح';

        return Helper::ResponseData(null,$message,true,200);


        

    }

    public function Edit($data = []){   
        
        $question = $this->question->where('uuid',$data['id'])->first();
        if(!$question){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'question Not Found' : $message = 'لم يتم العثور على السؤال';
            return Helper::ResponseData(null,$message,false,404);
        }
       
        $questionData = [
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'answer_en' => $data['answer_en'],
            'answer_ar' => $data['answer_ar'],
        ];

        $question->update($questionData);

       
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The question data modification process was completed successfully' : $message = 'تمت عملية تعديل بيانات السؤال بنجاح ';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function Delete($id){
        
        $question = $this->question->where('uuid',$id)->first();
        if(!$question){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'question Not Found' : $message = 'لم يتم العثور على السؤال';
            return Helper::ResponseData(null,$message,false,404);
        }

       
        $question->forceDelete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'question information has been successfully deleted' : $message = 'تم حذف معلومات السؤال بنجاح ';

        return Helper::ResponseData(null,$message,true,200);

        

    }


    public function Arrange($ids){   
        
        if(is_array($ids)){
            $arrange = 1;
            foreach ($ids as $id) {
                $question = $this->question->where('uuid',$id)->first();
                if($question){
                    $question->update([
                        'arrange' => $arrange
                    ]);
                    $arrange = $arrange + 1;
                }
            
            }
        }
        

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The questions data has been arranged successfully' : $message = 'تم ترتيب بيانات الاسئلة بنجاح ';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    
   
   
    
    

    

                    
}