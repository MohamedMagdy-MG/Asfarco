<?php

namespace App\Http\Resources\dashboard;

use App\Models\Chat;
use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function calculateDate($date){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $carbon = new Carbon();
        $now = $carbon->setTimezone('Asia/Dubai')->now();
        $totalDuration = $now->diffInMinutes($date);

        if($totalDuration == 0){
            $language == 'ar' ?  $date = 'الان': $date = "Just now" ;
        }
        
        elseif($totalDuration < 60){
            $language == 'ar' ?  $date = 'منذ '. $totalDuration . " دقيفة": $date = $totalDuration . " Minutes ago" ;
        }


        elseif($totalDuration >= 60 && $totalDuration < 1440 ){
            if(floor($totalDuration / 60) == 1){
                $language == 'ar' ?  $date = "منذ  ساعة": $date = floor($totalDuration / 60) . " Hour ago" ;

            }
            else if(floor($totalDuration / 60) == 2){
                $language == 'ar' ?  $date = "منذ  ساعتين":$date= "2 Hour ago" ;
 
            }
            else{
                $language == 'ar' ?  $date = 'منذ '. floor($totalDuration / 60) . " ساعات": $date = floor($totalDuration / 60) . " Hours ago" ;

            }

        }
        else{
            $transalte = new GoogleTranslate();
            $language == 'ar' ?  $date = $transalte->setSource('en')->setTarget('ar')->translate(date('d M Y - h:i A', strtotime($this->created_at->timezone('Asia/Dubai')))):  $date = date('l, d M Y - h:i A', strtotime($this->created_at->timezone('Asia/Dubai'))) ;       


        }
        return $date;
    }
    public function toArray($request)
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';

        return [
            'id' => $this->uuid,
            'message' => $language == 'ar' ? $this->message_ar : $this->message_en,
            'model' => $this->model,
            'title' => $language == 'ar' ? $this->title_ar : $this->title_en,
            'CreatedOn' => $this->calculateDate($this->created_at->timezone('Asia/Dubai')) 
        ];
    }
}
