<?php

namespace App\Http\Requests\dashboard\Car;

use Illuminate\Foundation\Http\FormRequest;

class AddCarRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'bags' => 'required|integer',
            'passengers' => 'required|integer',
            'doors' => 'required|integer',
            'daily' => 'required|numeric',
            'daily_discount' => 'required|integer',
            'weekly' => 'required|numeric',
            'weekly_discount' => 'required|integer',
            'monthly' => 'required|numeric',
            'monthly_discount' => 'required|integer',
            'yearly' => 'required|numeric',
            'yearly_discount' => 'required|integer',
            'category_id' => 'required',
            'fuel_id' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'model_year_id' => 'required',
            'transmission_id' => 'required',
            'branch_id' => 'required',
            'Images' => 'array',
            'Images.*' => 'required|url|active_url',
            'Features' => 'array',
            'Features.*' => 'required',
            'AdditionalFeatures' => 'array',
            'AdditionalFeatures.*.name_en' => 'required',
            'AdditionalFeatures.*.name_ar' => 'required',
            'AdditionalFeatures.*.price' => 'required|numeric',
            'Colors' => 'array',
            'Colors.*.color_id' => 'required',
            'Colors.*.total' => 'required|integer',
            'airport_transfer_service' => 'required|boolean',
            'airport_transfer_service_price' => 'required|numeric',
            'deliver_to_my_location' => 'required|boolean',
            'deliver_to_my_location_price' => 'required|numeric',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
                'description_en.required' => 'حقل الوصف (باللغة الإنجليزية) مطلوب.',
                'description_ar.required' => 'حقل الوصف (باللغة العربية) مطلوب.',
                'bags.required' => 'حقل عدد الشنط مطلوب.',
                'bags.integer' => 'صيغة حقل عدد الشنط خطأ.',
                'passengers.required' => 'حقل عدد الركاب مطلوب.',
                'passengers.integer' => 'صيغة حقل عدد الركاب خطأ.',
                'doors.required' => 'حقل عدد الابواب مطلوب.',
                'doors.integer' => 'صيغة حقل عدد الابواب خطأ.',
                'daily.required' => 'حقل الايجار اليومي مطلوب.',
                'daily.numeric' => 'صيغة حقل الايجار اليومي خطأ.',
                'daily_discount.required' => 'حقل الخصم علي الايجار اليومي مطلوب.',
                'daily_discount.integer' => 'صيغة حقل الخصم علي الايجار اليومي خطأ.',
                'weekly.required' => 'حقل الايجار الاسبوعي مطلوب.',
                'weekly.numeric' => 'صيغة حقل الايجار الاسبوعي خطأ.',
                'weekly_discount.required' => 'حقل الخصم علي الايجار الاسبوعي مطلوب.',
                'weekly_discount.integer' => 'صيغة حقل الخصم علي الايجار الاسبوعي خطأ.',
                'monthly.required' => 'حقل الايجار الشهري مطلوب.',
                'monthly.numeric' => 'صيغة حقل الايجار الشهري خطأ.',
                'monthly_discount.required' => 'حقل الخصم علي الايجار الشهري مطلوب.',
                'monthly_discount.integer' => 'صيغة حقل الخصم علي الايجار الشهري خطأ.',

                'yearly.required' => 'حقل الايجار السنوي مطلوب.',
                'yearly.numeric' => 'صيغة حقل الايجار السنوي خطأ.',
                'yearly_discount.required' => 'حقل الخصم علي الايجار السنوي مطلوب.',
                'yearly_discount.integer' => 'صيغة حقل الخصم علي الايجار السنوي خطأ.',


                'category_id.required' => 'حقل القسم مطلوب.',
                'fuel_id.required' => 'حقل نوع الوقود مطلوب.',
                'brand_id.required' => 'حقل الماركة مطلوب.',
                'model_id.required' => 'حقل الطراز مطلوب.',
                'model_year_id.required' => 'حقل سنة الصنع مطلوب.',
                'transmission_id.required' => 'حقل ناقل الحركة مطلوب.',
                'branch_id.required' => 'حقل الفرع مطلوب.',
                'Images.required' => 'حقل صور السيارة مطلوب.',
                'Images.array' => 'صيغة حقل صور السيارة خطأ.',
                'Images.*.required' => 'حقل صورة السيارة مطلوبة.',
                'Images.*.url' => 'يجب أن تكون صورة السيارة عنوان URL صالحًا.',
                'Images.*.active_url' =>  'صورة السيارة ليست عنوان URL صالحًا.',
                'Features.required' => 'حقل مميزات السيارة مطلوب.',
                'Features.array' => 'صيغة حقل مميزات السيارة خطأ.',
                'Features.*.required' => 'حقل ميزة السيارة مطلوبة.',
                'AdditionalFeatures.required' => 'حقل ميزات إضافية للسيارة مطلوب.',
                'AdditionalFeatures.array' => 'صيغة حقل ميزات إضافية للسيارة خطأ.',
                'AdditionalFeatures.*.name_en.required' => 'حقل اسم الميزة الاضافية (باللغة الإنجليزية) مطلوب.',
                'AdditionalFeatures.*.name_ar.required' => 'حقل اسم الميزة الاضافية (باللغة العربية) مطلوب.',
                'AdditionalFeatures.*.price.required' => 'حقل سعر الميزة الاضافية مطلوب.',
                'AdditionalFeatures.*.price.numeric' => 'صيغة حقل سعر الميزة الاضافية خطأ.',
                'Colors.required' => 'حقل الوان السيارة مطلوب.',
                'Colors.array' => 'صيغة حقل الوان السيارة خطأ.',
                'Colors.*.color_id.required' => 'حقل لون السيارة مطلوب.',
                'Colors.*.total.required' => 'حقل عدد السيارات مطلوب.',
                'Colors.*.total.integer' => 'صيغة حقل عدد السيارات خطأ.',
                'airport_transfer_service.required' => 'حقل خدمة نقل المطار مطلوب.',
                'airport_transfer_service.boolean' => 'صيغة حقل خدمة نقل المطار خطأ.',
                'airport_transfer_service_price.required' => 'حقل سعر خدمة نقل المطار مطلوب.',
                'airport_transfer_service_price.numeric' => 'صيغة حقل سعر خدمة نقل المطار خطأ.',
                'deliver_to_my_location.required' => 'حقل خدمة التسليم إلى موقعي مطلوب.',
                'deliver_to_my_location.boolean' => 'صيغة حقل خدمة التسليم إلى موقعي خطأ.',
                'deliver_to_my_location_price.required' => 'حقل سعر خدمة التسليم إلى موقعي مطلوب.',
                'deliver_to_my_location_price.numeric' => 'صيغة حقل سعر خدمة التسليم إلى موقعي خطأ.',

            ];
        }else{
            return [
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'latitude.required' => 'The Latitude field is required.',
                'latitude.numeric' => 'The Latitude field is invalid.',
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'description_en.required' => 'The Description ( English ) field is required.',
                'description_ar.required' => 'The Description ( Arabic ) field is required.',
                'bags.required' => 'The Bags Count field is required.',
                'bags.integer' => 'The Bags Count field is invalid.',
                'passengers.required' => 'The Passengers Count field is required.',
                'passengers.integer' => 'The Passengers Count field is invalid.',
                'doors.required' => 'The Doors Count field is required.',
                'doors.integer' => 'The Doors Count field is invalid.',
                'daily.required' => 'The Daily field is required.',
                'daily.numeric' => 'The Daily field is invalid.',
                'daily_discount.required' => 'The Daily Discount field is required.',
                'daily_discount.integer' => 'The Daily Discount field is invalid.',
                'weekly.required' => 'The Weekly field is required.',
                'weekly.numeric' => 'The Weekly field is invalid.',
                'weekly_discount.required' => 'The Weekly Discount field is required.',
                'weekly_discount.integer' => 'The Weekly Discount field is invalid.',
                'monthly.required' => 'The Monthly field is required.',
                'monthly.numeric' => 'The Monthly field is invalid.',
                'monthly_discount.required' => 'The Monthly Discount field is required.',
                'monthly_discount.integer' => 'The Monthly Discount field is invalid.',

                'yearly.required' => 'The Yearly field is required.',
                'yearly.numeric' => 'The Yearly field is invalid.',
                'yearly_discount.required' => 'The Yearly Discount field is required.',
                'yearly_discount.integer' => 'The Yearly Discount field is invalid.',


                'category_id.required' => 'The Category field is required.',
                'fuel_id.required' => 'The Fuel Type field is required.',
                'brand_id.required' => 'The Brand field is required.',
                'model_id.required' => 'The Model field is required.',
                'model_year_id.required' => 'The Model Year field is required.',
                'transmission_id.required' => 'The Transmission field is required.',
                'branch_id.required' => 'The Branch field is required.',
                'Images.required' => 'The Images field is required.',
                'Images.array' => 'The Images field is invalid.',
                'Images.*.required' => 'The Image field is required.',
                'Images.*.url' => 'The Image field must be a valid URL.',
                'Images.*.active_url' =>  'The Image field is not a valid URL.',
                'Features.required' => 'The Features field is required.',
                'Features.array' => 'The Features field is invalid.',
                'Features.*.required' => 'The Feature field is required.',
                'AdditionalFeatures.required' => 'The Additional Features field is required.',
                'AdditionalFeatures.array' => 'The Additional Features field is invalid',
                'AdditionalFeatures.*.name_en.required' => 'The Additional Feature Name ( English ) field is required.',
                'AdditionalFeatures.*.name_ar.required' => 'The Additional Feature Name ( Arabic ) field is required.',
                'AdditionalFeatures.*.price.required' => 'The Additional Feature Price field is required.',
                'AdditionalFeatures.*.price.numeric' => 'The Additional Feature Price field is invalid.',
                'Colors.required' => 'The Colors field is required.',
                'Colors.array' => 'The Colors field is invalid.',
                'Colors.*.color_id.required' => 'The Color field is required.',
                'Colors.*.total.required' => 'The Total Of Color field is required.',
                'Colors.*.total.integer' => 'The Total Of Color field is invalid.',
                
                'airport_transfer_service.required' => 'The Airport Transfer Service field is required.',
                'airport_transfer_service.boolean' => 'The Airport Transfer Service field is invalid.',
                'airport_transfer_service_price.required' => 'The Airport Transfer Service price field is required.',
                'airport_transfer_service_price.numeric' => 'The Airport Transfer Service price field is invalid.',
                'deliver_to_my_location.required' => 'The Deliver To My Location Service field is required.',
                'deliver_to_my_location.boolean' => 'The Deliver To My Location Service field is invalid.',
                'deliver_to_my_location_price.required' => 'The Deliver To My Location Service price field is required.',
                'deliver_to_my_location_price.numeric' => 'The Deliver To My Location Service price field is invalid.',




            ];
        }
    }
}
