<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\HeaderInterface;
use App\Http\Resources\dashboard\HeaderResource;
use App\Models\Header;
use Illuminate\Database\Eloquent\Builder;

class HeaderRepo implements HeaderInterface
{
       
    public $header;
    public function __construct()
    {
        $this->header = new Header();
    }

    public function ShowHeader(){ 

        $header = $this->header->first();
        if(!$header){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'header Not Found' : $message = 'لم يتم العثور على بيانات الرأس';
            return Helper::ResponseData(null,$message,false,404);
        }
       
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data for the header has been displayed successfully' : $message = 'تم عرض بيانات الرأس بنجاح ';

        return Helper::ResponseData(new HeaderResource($header),$message,true,200);


        

    }
    
    public function UpdateHeader($data = []){ 
        $header = $this->header->first();
        if(!$header){
            $this->header->create($data);
        }else{
            $header->update($data);
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data has been successfully modified to the header' : $message = 'تم تعديل البيانات بنجاح إلى الرأس ';

        return Helper::ResponseData(null,$message,true,200);
    }   

   
                    
}