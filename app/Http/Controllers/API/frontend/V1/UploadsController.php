<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\UploadsRepo;
use App\Http\Requests\frontend\Uploads\ImageRequest;
use App\Http\Requests\frontend\Uploads\ImagesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UploadsController extends Controller
{
    public $uploadsRepo;
    public function __construct()
    {
        $this->uploadsRepo= new UploadsRepo();
    }
   

    public function SaveImage(Request $request) {

        $validator = Validator::make($request->only('image','MediaGate'),ImageRequest::rules(),
        ImageRequest::Message());

        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Image Operation Failed' : $message = 'فشلت عملية اضافة الصورة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }

        if(!$request->has('MediaGate') || $request->MediaGate != env('MEDIA_LICENCE')){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Image Operation Failed' : $message = 'فشلت عملية اضافة الصورة';
            return Helper::ResponseData(null,$message,false,400);
        }

        return $this->uploadsRepo->SaveImage($request->image);


    }

    public function SaveImages(Request $request) {
        
        $validator = Validator::make($request->only('images','MediaGate'),ImagesRequest::rules(),
        ImagesRequest::Message());

        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Images Operation Failed' : $message = 'فشلت عملية اضافة الصور';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }

        if(!$request->has('MediaGate') || $request->MediaGate != env('MEDIA_LICENCE')){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Images Operation Failed' : $message = 'فشلت عملية اضافة الصور';
            return Helper::ResponseData(null,$message,false,400);
        }

        return $this->uploadsRepo->SaveImages($request->images);


    }





}
