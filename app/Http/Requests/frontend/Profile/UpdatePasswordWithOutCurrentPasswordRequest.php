<?php

namespace App\Http\Requests\frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordWithOutCurrentPasswordRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    public static function rules()
    {
        return [
            'new_password' => 'required|min:8|max:30|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'

            
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [

                'new_password.regex' => 'تنسيق كلمة المرور الجديدة غير صالح (يجب أن يحتوي على الأقل على حرف خاص واحد وحرف صغير وحرف كبير ورقم)',
                'new_password.required' => 'حقل كلمة المرور الجديدة مطلوب.',
                'new_password.min' => 'يجب ألا تقل كلمة المرور الجديدة عن 8 أحرف.',
                'new_password.max' => 'يجب ألا تزبد كلمة المرور الجديدة عن 30 حرفًا.',
                'new_password.required_with' => 'حقل تأكيد كلمة المرور الجديدة مطلوب عند وجود كلمة المرور الجديدة.',
                'new_password.same' => 'يجب أن تتطابق كلمة المرور الجديدة مع تأكيد كلمة المرور الجديدة.',

                'new_password_confirmation.required' => 'حقل تاكيد كلمة المرور الجديدة مطلوب.',
            ];
        }else{
            return [
                
                'new_password.regex' => 'The New Password format is invalid ( must contain at least one special character, a lowercase letter, an uppercase letter, and a number )',
                'new_password.required' => 'The New Password field is required.',
                'new_password.min' => 'The New Password must be at least 8 Characters.',
                'new_password.max' => 'The New Password must not be greater than 30 Characters.',
                'new_password.required_with' => 'The Confirm New Password field is required when New Password is present.',
                'new_password.same' => 'The New Password and Confirm New Password  must match.',

                'new_password_confirmation.required' => 'The Confirm New Password field is required.',
            ];
        }
    }


}
