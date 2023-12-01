<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\HomeAdsOneRepo;
use App\Http\Requests\dashboard\Ads\AdsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeAdsOneController extends Controller
{
    public $homeAdsOneRepo;

    public function __construct()
    {
        $this->homeAdsOneRepo = new HomeAdsOneRepo();
        $this->middleware('auth:dashboard');
    }

    public function ShowAds()
    {
        return $this->homeAdsOneRepo->ShowAds();
    }

    public function UpdateAds(Request $request)
    {
       
        $validator = Validator::make($request->only(['link','image','active']),AdsRequest::rules(),AdsRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to modify data in the Ads' : $message = 'فشل تعديل البيانات في الاعلان';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'link' => $request->link,
                'image' => $request->image,
                'active' => $request->active
            ];
            
            return $this->homeAdsOneRepo->UpdateAds($data);
        }   
        
    }

   
   
   
}
