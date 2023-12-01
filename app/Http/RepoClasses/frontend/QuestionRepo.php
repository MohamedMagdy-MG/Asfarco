<?php
        
namespace App\Http\RepoClasses\frontend;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\frontend\QuestionInterface;
use App\Http\Resources\frontend\QuestionResource;
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

    

                    
}