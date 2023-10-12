<?php

namespace App\Http\Requests\dashboard\Uploads;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'image' => 'required',
        ];
    }
    
    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'image.required' => 'حقل الصورة مطلوب',
                'image.image' => 'يجب أن يكون حقل الصورة صورة فقط',
            ];
        }else{
            return [
                'image.required' => 'The Image field is required.',
                'image.image' => 'The Image must be Image Only.',
            ];
        }
    }
}
