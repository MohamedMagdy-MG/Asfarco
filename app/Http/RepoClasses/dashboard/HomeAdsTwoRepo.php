<?php

namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\HomeAdsTwoInterface;
use App\Http\Resources\dashboard\AdsResource;
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

        $homeAdsTwo = $this->homeAdsTwo->first();
        if (!$homeAdsTwo) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'first section of the Ads Not Found' : $message = 'لم يتم العثور على بيانات الاعلان';
            return Helper::ResponseData(null, $message, false, 404);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

        return Helper::ResponseData(new AdsResource($homeAdsTwo), $message, true, 200);
    }

    public function UpdateAds($data = [])
    {
        $homeAdsTwo = $this->homeAdsTwo->first();
        if (!$homeAdsTwo) {
            $this->homeAdsTwo->create($data);
        } else {
            $homeAdsTwo->update($data);
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data has been successfully modified to the Ads' : $message = 'تم تعديل البيانات بنجاح إلى الاعلان ';

        return Helper::ResponseData(null, $message, true, 200);
    }
}
