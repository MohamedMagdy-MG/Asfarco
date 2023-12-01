<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\HeaderRepo;
use App\Http\Requests\dashboard\Header\HeaderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HeaderController extends Controller
{
    public $headerRepo;

    public function __construct()
    {
        $this->headerRepo = new HeaderRepo();
        $this->middleware('auth:dashboard');
    }

    public function ShowHeader()
    {
        return $this->headerRepo->ShowHeader();
    }

    public function UpdateHeader(Request $request)
    {
       
        $validator = Validator::make($request->only(['title_en','title_ar','description_en','description_ar','image_en','image_ar']),HeaderRequest::rules(),HeaderRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to modify data in the header' : $message = 'فشل تعديل البيانات في الرأس';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'image_en' => $request->image_en,
                'image_ar' => $request->image_ar,
            ];
            
            return $this->headerRepo->UpdateHeader($data);
        }   
        
    }

   
   
   
}
