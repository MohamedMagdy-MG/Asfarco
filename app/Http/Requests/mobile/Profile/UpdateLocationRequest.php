<?php

namespace App\Http\Requests\mobile\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    public static function rules()
    {
        return [
            'longitude'=> 'required',
            'latitude' => 'required'
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
               
                'longitude.required' => 'حقل خط الطول مطلوب.',
                'latitude.required' => 'حقل خط العرض مطلوب.',

            ];
        }else{
            return [
               
                'longitude.required' => 'The Longitude field is required.',
                'latitude.required' => 'The Latitude field is required.',



            ];
        }
    }

}
