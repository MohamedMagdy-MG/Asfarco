<?php

namespace App\Http\RepoClasses\frontend;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\frontend\HomeAdsTwoInterface;
use App\Http\Resources\frontend\AdsResource;
use App\Models\HomeAdsTwo;
use Illuminate\Database\Eloquent\Builder;

class HomeAdsTwoRepo implements HomeAdsTwoInterface
{

    public $homeAdsTwo;
    public function __construct()
    {
        $this->homeAdsTwo = new HomeAdsTwo();
    }

    public function ShowAds()
    {

        $homeAdsTwo = $this->homeAdsTwo->where('active',true)->first();
        if (!$homeAdsTwo) {
            // request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            // $language == 'en' ? $message = 'first section of the Ads Not Found' : $message = 'لم يتم العثور على بيانات الاعلان';
            // return Helper::ResponseData(null, $message, false, 404);

            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

            return Helper::ResponseData(null, $message, true, 200);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

        return Helper::ResponseData(new AdsResource($homeAdsTwo), $message, true, 200);
    }

    
}
