<?php

namespace App\Http\Requests\frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    
    public function authorize()
    {
        return false;
    }


    public static function rules()
    {
        return [
            'name' => 'required|min:8|max:30',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile|regex:/971([\d]{9})/',
            'gender'=> 'required|in:Male,Female,Other',
            'register_type' => 'required|in:Email,Apple,Gmail',
            'nationality' => 'required',
            'Documents' => 'array',
            'Documents.*' => 'required|url',
            
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
                'email.email' => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا.',
                'email.unique' => 'تم أخذ البريد الإلكتروني بالفعل.',

                'mobile.required' => 'حقل الهاتف المحمول مطلوب.',
                'mobile.unique' => 'تم أخذ الهاتف المحمول بالفعل.',
                'mobile.regex' => 'يجب عليك استخدام رقم هاتف إماراتي',

                'password.regex' => 'تنسيق كلمة المرور غير صالح (يجب أن يحتوي على الأقل على حرف خاص واحد وحرف صغير وحرف كبير ورقم)',
                'password.required' => 'حقل كلمة المرور مطلوب.',
                'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
                'password.max' => 'يجب ألا تزبد كلمة المرور عن 30 حرفًا.',
                

                'gender.required' => 'حقل الجنس مطلوب.',
                'gender.in'=>'الجنس المحدد غير صالح.',


                'register_type.required' => 'حقل نوع التسجيل مطلوب.',
                'register_type.in' => ' نوع التسجيل غير صالح.',

                'nationality.required' => 'حقل الجنسية مطلوب.',

                'Documents.required' => 'حقل صور الوثائق مطلوب.',
                'Documents.array' => 'صيغة حقل صور الوثائق خطأ.',
                'Documents.*.required' => 'حقل صورة الوثيقة مطلوبة.',
                'Documents.*.url' => 'يجب أن تكون صورة الوثيقة عنوان URL صالحًا.',
                'Documents.*.active_url' =>  'صورة الوثيقة ليست عنوان URL صالحًا.',


            ];
        }else{
            return [
                'name.required' => 'The Name field is required.',
                'name.min' => 'The Name must be at least 8 Characters.',
                'name.max' => 'The Name must not be greater than 30 Characters.',
                'name.regex' => 'The Name format is invalid.',


                

                'email.required' => 'The Email field is required.',
                'email.email' => 'The Email must be a valid email address.',
                'email.unique' => 'The Email has already been taken.',

                'mobile.required' => 'The Mobile field is required.',
                'mobile.unique' => 'The Mobile has already been taken.',
                'mobile.regex' => 'You must use an Emirati mobile number',

                'password.regex' => 'The Password format is invalid ( must contain at least one special character, a lowercase letter, an uppercase letter, and a number )',
                'password.required_if' => 'The Password field is required.',
                'password.min' => 'The Password must be at least 8 Characters.',
                'password.max' => 'The Password must not be greater than 30 Characters.',

                'gender.required' => 'The Gender field is required.',
                'gender.in'=>'The selected Gender is invalid.',

                'register_type.required' => 'The Register Type field is required.',
                'register_type.in'=>'The selected Register Type is invalid.',


                'nationality.required' => 'The Nationality field is required.',

                'Documents.required' => 'The Documents field is required.',
                'Documents.array' => 'The Documents field is invalid.',
                'Documents.*.required' => 'The Document field is required.',
                'Documents.*.url' => 'The Document field must be a valid URL.',
                'Documents.*.active_url' =>  'The Document field is not a valid URL.',

            ];
        }
    }

   
}
