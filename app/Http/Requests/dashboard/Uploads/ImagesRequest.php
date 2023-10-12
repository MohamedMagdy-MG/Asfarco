<?php

namespace App\Http\Requests\dashboard\Uploads;

use Illuminate\Foundation\Http\FormRequest;

class ImagesRequest extends FormRequest
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
            'images' => 'required',
            'images.*' => 'required|image',
        ];
    }
    
    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'images.required' => 'حقل الصور مطلوب',
                'images.*.required' => 'حقل الصورة مطلوب',
                'images.*.image' => 'يجب أن يكون حقل الصورة صورة فقط',
            ];
        }else{
            return [
                'images.required' => 'The Images field is required.',
                'images.*.required' => 'The Image field is required.',
                'images.*.image' => 'The Image must be Image Only.',
            ];
        }
    }
}
