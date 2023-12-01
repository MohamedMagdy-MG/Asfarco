<?php

namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\FleetAdsInterface;
use App\Http\Resources\dashboard\AdsResource;
use App\Models\FleetAds;
use Illuminate\Database\Eloquent\Builder;

class FleetAdsRepo implements FleetAdsInterface
{

    public $fleetAds;
    public function __construct()
    {
        $this->fleetAds = new FleetAds();
    }

    public function ShowAds()
    {

        $fleetAds = $this->fleetAds->first();
        if (!$fleetAds) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'first section of the Ads Not Found' : $message = 'لم يتم العثور على بيانات الاعلان';
            return Helper::ResponseData(null, $message, false, 404);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data for the Ads has been displayed successfully' : $message = 'تم عرض بيانات الاعلان بنجاح ';

        return Helper::ResponseData(new AdsResource($fleetAds), $message, true, 200);
    }

    public function UpdateAds($data = [])
    {
        $fleetAds = $this->fleetAds->first();
        if (!$fleetAds) {
            $this->fleetAds->create($data);
        } else {
            $fleetAds->update($data);
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The data has been successfully modified to the Ads' : $message = 'تم تعديل البيانات بنجاح إلى الاعلان ';

        return Helper::ResponseData(null, $message, true, 200);
    }
}
