<?php

namespace App\Http\RepoClasses\frontend;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\frontend\AboutAdsInterface;
use App\Http\Resources\frontend\AdsResource;
use App\Models\AboutAds;
use Illuminate\Database\Eloquent\Builder;

class AboutAdsRepo implements AboutAdsInterface
{

    public $aboutAds;
    public function __construct()
    {
        $this->aboutAds = new AboutAds();
    }

    public function ShowAds()
    {

        $aboutAds = $this->aboutAds->where('active',true)->first();
        if (!$aboutAds) {
            // request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            // $language == 'en' ? $message = 'first section of the Ads Not Found' : $message = 'لم يتم العثور على بيانات الاعلان';
            // return Helper::ResponseData(null, $message, false, 404);

            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

            return Helper::ResponseData(null, $message, true, 200);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

        return Helper::ResponseData(new AdsResource($aboutAds), $message, true, 200);
    }

    
}
