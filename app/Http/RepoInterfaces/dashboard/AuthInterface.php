<?php
    namespace App\Http\RepoInterfaces\dashboard;
    interface AuthInterface{
        public function Login($data=[]);
        public function SendVerificationCode($data);
        public function ActiveAccount($data);
        public function ForgetPassword($data);
        public function ResetAccount($data);
        public function NotFound();
        public function Guest(); 
    }