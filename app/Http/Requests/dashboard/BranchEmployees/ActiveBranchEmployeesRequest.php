<?php

namespace App\Http\Requests\dashboard\BranchEmployees;

use Illuminate\Foundation\Http\FormRequest;

class ActiveBranchEmployeesRequest extends FormRequest
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
                'id.required' =>'حقل معرف موظف الفرع مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Branch Employee ID field is required.',
            ];
        }
    }
}
