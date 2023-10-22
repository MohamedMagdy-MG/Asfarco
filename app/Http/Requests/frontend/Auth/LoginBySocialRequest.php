<?php

namespace App\Http\Requests\frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginBySocialRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'login_type' => 'required|in:Apple,Gmail',
            
        ];
    }
   
    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'name.required' => 'حقل الاسم مطلوب.',
                'name.min' => 'يجب ألا يقل الاسم عن 8 أحرف.',
                'name.max' => 'يجب ألا يزيد الاسم عن 30 حرفًا.',
                'name.regex' => ' تنسيق الاسم (الإنجليزية) غير صالح.',

                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'eamil.email'=>'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا',
                'login_type.required' => 'حقل نوع تسجيل الدخول مطلوب.',
                'login_type.in' => ' نوع التستسجيل الدخولجيل غير صالح.',


            ];
        }else{
            return [
                'name.required' => 'The Name field is required.',
                'name.min' => 'The Name must be at least 8 Characters.',
                'name.max' => 'The Name must not be greater than 30 Characters.',
                'name.regex' => 'The Name format is invalid.',
                'email.required' => 'The Email field is required.',
                'eamil.email'=> 'The email must be a valid email address',
                'login_type.required' => 'The Login Type field is required.',
                'login_type.in'=>'The selected Login Type is invalid.',
            ];
        }
    }
}
