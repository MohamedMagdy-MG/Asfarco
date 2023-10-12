<?php

namespace App\Http\Requests\frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public static function rules()
    {
        return [
            'id' => 'required',
            'label' => 'required',
            'address' => 'required',
            'city' => 'required',
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف العنوان مطلوب.',
                'label.required' => 'حقل تسمية عنوان مطلوب.',
                'address.required' => 'حقل العنوان مطلوب.',
                'city.required' => 'حقل المدينة مطلوب.',





            ];
        }else{
            return [
                'id.required' =>'The Address ID field is required.',
                'label.required' => 'The Address Label field is required.',
                'address.required' => 'The Address field is required.',
                'city.required' => 'The City field is required.',

            ];
        }
    }

}
