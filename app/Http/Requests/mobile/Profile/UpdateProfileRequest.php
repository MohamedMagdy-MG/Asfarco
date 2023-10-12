<?php

namespace App\Http\Requests\mobile\Profile;

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
            'mobile' => 'nullable|unique:users,mobile|regex:/971([\d]{9})/',
            'gender'=> 'nullable|in:Male,Female,Other',
            'image' => 'nullable',
            'nationality' => 'nullable',
            'Documents' => 'nullable',
            'Documents.*' => 'nullable',
            
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

                'mobile.required' => 'حقل الهاتف المحمول مطلوب.',
                'mobile.unique' => 'تم أخذ الهاتف المحمول بالفعل.',
                'mobile.regex' => 'يجب عليك استخدام رقم هاتف إماراتي',


                'gender.required' => 'حقل الجنس مطلوب.',
                'gender.in'=>'الجنس المحدد غير صالح.',

                'image.active_url' =>  'صورة المستخدم ليست عنوان URL صالحًا.',
                'image.required' => 'حقل صورة المستخدم مطلوبة.',
                'image.url' => 'يجب أن تكون صورة المستخدم عنوان URL صالحًا.',

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




                'mobile.required' => 'The Mobile field is required.',
                'mobile.unique' => 'The Mobile has already been taken.',
                'mobile.regex' => 'You must use an Emirati mobile number',

                'gender.required' => 'The Gender field is required.',
                'gender.in'=>'The selected Gender is invalid.',

                'image.required' => 'The Image field is required.',
                'image.url' => 'The Image field must be a valid URL.',
                'image.active_url' =>  'The Image field is not a valid URL.',


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
