<?php

namespace App\Http\Requests\dashboard\BranchManagers;

use Illuminate\Foundation\Http\FormRequest;

class ActiveBranchManagersRequest extends FormRequest
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
                'id.required' =>'حقل معرف مدير الفرع مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Branch Manager ID field is required.',
            ];
        }
    }
}
