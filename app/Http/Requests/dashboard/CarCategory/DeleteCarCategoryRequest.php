<?php

namespace App\Http\Requests\dashboard\CarCategory;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCarCategoryRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'id' => 'required',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف قسم السيارة مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Car Category ID field is required.',
            ];
        }
    }
}
