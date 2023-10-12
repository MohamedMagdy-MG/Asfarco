<?php
    namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\AnalysisInterface;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\User;

class AnalysisRepo implements AnalysisInterface{
    public $user;
    public $admin;
    public $branches;
    public function __construct()
    {
        $this->user = new User();
        $this->admin = new Admin();
        $this->branches = new Branch();
    }

    public function Cards(){
        $No_Admins = $this->admin->where('role','Admin')->count();
        $No_BranchEmployees = $this->admin->where('role','Branch Employee')->count();
        $No_BranchManagers = $this->admin->where('role','Branch Manager')->count();
        $No_Managers = $this->admin->where('role','Manager')->count();
        $No_PendingUsers = $this->user->where('verify_document',false)->where('verify_document_at','==',null)->where('email_verified_at','!=',null)->where('Verify_at','!=',null)->count();
        $No_SuspendUsers = $this->user->where('active',false)->where('email_verified_at','!=',null)->where('Verify_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
        $No_UnVerificationsUsers = $this->user->where('email_verified_at','==',null)->where('Verify_at','==',null)->where('verify_document',false)->where('verify_document_at','==',null)->count();
        $No_ActiveUsers = $this->user->where('active',true)->where('email_verified_at','!=',null)->where('Verify_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';


        $data = [
            [
                'name' => $language == 'ar' ? 'عدد مسئولي النظام' : 'Number Of System Administrator',
                'value' => $No_Admins
            ],
            [
                'name' => $language == 'ar' ? 'عدد المدراء' : 'Number Of Manager',
                'value' => $No_Managers
            ],
            [
                'name' => $language == 'ar' ? 'عدد مسئولي الفرع' : 'Number Of Branch Managers',
                'value' => $No_BranchManagers
            ],
            [
                'name' => $language == 'ar' ? 'عدد موظفين الفرع' : 'Number Of Branch Employees',
                'value' => $No_BranchEmployees
            ],
            [
                'name' => $language == 'ar' ? 'عدد المستخدمين النشطين' : 'Number of Active Users',
                'value' => $No_ActiveUsers
            ],
            [
                'name' => $language == 'ar' ? 'عدد المستخدمين الذين ينتظرون الموافقة' : 'Number of Users Awaiting Approval',
                'value' => $No_PendingUsers
            ],
            [
                'name' => $language == 'ar' ? 'عدد المستخدمين المعلقين' : 'Number Of Suspend Users',
                'value' => $No_SuspendUsers
            ],
            [
                'name' => $language == 'ar' ? 'عدد المستخدمين الذين لم يتم التحقق منهم ' : 'Number Of Unverified Users',
                'value' => $No_UnVerificationsUsers
            ],

            
           
        ];
        $language == 'en' ? $message = 'Get Analysis Cards Operation Success' : $message = 'نجحت عملية الحصول كروت التحليل ';
        return Helper::ResponseData($data,$message,true,200);
    }
}