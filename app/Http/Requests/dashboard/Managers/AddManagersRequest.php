<?php

namespace App\Http\Requests\dashboard\Managers;

use Illuminate\Foundation\Http\FormRequest;

class AddManagersRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'name_en' => 'required|min:8|max:30',
            'name_ar' => 'required|min:8|max:30',
            'gender'=> 'required|in:Male,Female,Other',
            'email' => 'required|email|unique:admins,email',
            // 'password' => 'required|min:8|max:30',
            'image' => 'nullable|url|active_url',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_en.min' => 'يجب ألا يقل الاسم (باللغة الإنجليزية) عن 8 أحرف.',
                'name_en.max' => 'يجب ألا يزيد الاسم (باللغة الإنجليزية) عن 30 حرفًا.',
                'name_en.regex' => ' تنسيق الاسم (الإنجليزية) غير صالح.',

                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
                'name_ar.min' => 'يجب ألا يقل الاسم (باللغة العربية) عن 8 أحرف.',
                'name_ar.max' => 'يجب ألا يزيد الاسم (باللغة العربية) عن 30 حرفًا.',

                'gender.required' => 'حقل الجنس مطلوب.',
                'gender.in'=>'الجنس المحدد غير صالح.',

                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'email.email' => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا.',
                'email.unique' => 'تم أخذ البريد الإلكتروني بالفعل.',

                'mobile.required' => 'حقل الهاتف المحمول مطلوب.',
                'mobile.unique' => 'تم أخذ الهاتف المحمول بالفعل.',

                'password.regex' => 'تنسيق كلمة المرور غير صالح (يجب أن يحتوي على الأقل على حرف خاص واحد وحرف صغير وحرف كبير ورقم)',
                'password.required' => 'حقل كلمة المرور مطلوب.',
                'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
                'password.max' => 'يجب ألا تزبد كلمة المرور عن 30 حرفًا.',

                'image.url' => 'يجب أن تكون الصورة عنوان URL صالحًا.',
                'image.active_url' =>  'الصورة ليست عنوان URL صالحًا.',

               



            ];
        }else{
            return [
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_en.min' => 'The Name ( English ) must be at least 8 Characters.',
                'name_en.max' => 'The Name ( English ) must not be greater than 30 Characters.',
                'name_en.regex' => 'The Name ( English ) format is invalid.',

                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'name_ar.min' => 'The Name ( Arabic ) must be at least 8 Characters.',
                'name_ar.max' => 'The Name ( Arabic ) must not be greater than 30 Characters.',

                'gender.required' => 'The Gender field is required.',
                'gender.in'=>'The selected Gender is invalid.',

                'email.required' => 'The Email field is required.',
                'email.email' => 'The Email must be a valid email address.',
                'email.unique' => 'The Email has already been taken.',

                'password.regex' => 'The Password format is invalid ( must contain at least one special character, a lowercase letter, an uppercase letter, and a number )',
                'password.required_if' => 'The Password field is required.',
                'password.min' => 'The Password must be at least 8 Characters.',
                'password.max' => 'The Password must not be greater than 30 Characters.',

                'image.url' => 'The Image must be a valid URL.',
                'image.active_url' =>  'The Image is not a valid URL.',


            ];
        }
    }
}
