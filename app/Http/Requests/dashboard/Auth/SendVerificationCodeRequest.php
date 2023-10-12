<?php

namespace App\Http\Requests\dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendVerificationCodeRequest extends FormRequest
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
            'email' => 'required',
        ];
    }
   
    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'eamil.email'=>'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا'

            ];
        }else{
            return [
                'email.required' => 'The Email field is required.',
                'eamil.email'=> 'The email must be a valid email address'

            ];
        }
    }
}
