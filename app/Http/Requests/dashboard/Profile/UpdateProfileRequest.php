<?php

namespace App\Http\Requests\dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'name_en' => 'nullable|min:8|max:30',
            'name_ar' => 'nullable|min:8|max:30',
            'gender'=> 'nullable|in:Male,Female,Other',
            'email' => 'nullable|email|unique:admins,email',
            'password' => 'nullable|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'image' => 'nullable|url|active_url',
            
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'name_en.min' => 'يجب ألا يقل الاسم (باللغة الإنجليزية) عن 8 أحرف.',
                'name_en.max' => 'يجب ألا يزيد الاسم (باللغة الإنجليزية) عن 30 حرفًا.',

                'name_ar.min' => 'يجب ألا يقل الاسم (باللغة العربية) عن 8 أحرف.',
                'name_ar.max' => 'يجب ألا يزيد الاسم (باللغة العربية) عن 30 حرفًا.',

                'gender.in'=>'الجنس المحدد غير صالح.',

                'email.email' => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا.',
                'email.unique' => 'تم أخذ البريد الإلكتروني بالفعل.',


                'password.regex' => 'تنسيق كلمة المرور غير صالح (يجب أن يحتوي على الأقل على حرف خاص واحد وحرف صغير وحرف كبير ورقم)',
                'password.required_if' => 'حقل كلمة المرور مطلوب.',

                'image.url' => 'يجب أن تكون الصورة عنوان URL صالحًا.',
                'image.active_url' =>  'الصورة ليست عنوان URL صالحًا.',

                

            ];
        }else{
            return [
                'name_en.min' => 'The Name ( English ) must be at least 8 Characters.',
                'name_en.max' => 'The Name ( English ) must not be greater than 30 Characters.',

                'name_ar.min' => 'The Name ( Arabic ) must be at least 8 Characters.',
                'name_ar.max' => 'The Name ( Arabic ) must not be greater than 30 Characters.',

                'gender.in'=>'The selected Gender is invalid.',

                'email.email' => 'The Email must be a valid email address.',
                'email.unique' => 'The Email has already been taken.',

                'mobile.unique' => 'The Mobile has already been taken.',

                'password.regex' => 'The Password format is invalid ( must contain at least one special character, a lowercase letter, an uppercase letter, and a number )',
                'password.required_if' => 'The Password field is required.',

                'image.url' => 'The Image must be a valid URL.',
                'image.active_url' =>  'The Image is not a valid URL.',

                
            ];
        }
    }
}
