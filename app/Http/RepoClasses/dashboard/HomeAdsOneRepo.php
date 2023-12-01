<?php

namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\HomeAdsOneInterface;
use App\Http\Resources\dashboard\AdsResource;
use App\Models\HomeAdsOne;
use Illuminate\Database\Eloquent\Builder;

class HomeAdsOneRepo implements HomeAdsOneInterface
{

    public $homeAdsOne;
    public function __construct()
    {
        $this->homeAdsOne = new HomeAdsOne();
    }

    public function ShowAds()
    {

        $homeAdsOne = $this->homeAdsOne->first();
        if (!$homeAdsOne) {
            request()->headers->has('language') ? $language = request()->language->get('language') : $language = 'en';
            $language == 'en' ? $message = 'first section of the Ads Not Found' : $message = 'لم يتم العثور على بيانات الاعلان';
            return Helper::ResponseData(null, $message, false, 404);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

        return Helper::ResponseData(new AdsResource($homeAdsOne), $message, true, 200);
    }

    public function UpdateAds($data = [])
    {
        $homeAdsOne = $this->homeAdsOne->first();
        if (!$homeAdsOne) {
            $this->homeAdsOne->create($data);
        } else {
            $homeAdsOne->update($data);
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data has been successfully modified to the Ads' : $message = 'تم تعديل البيانات بنجاح إلى الاعلان ';

        return Helper::ResponseData(null, $message, true, 200);
    }
}
