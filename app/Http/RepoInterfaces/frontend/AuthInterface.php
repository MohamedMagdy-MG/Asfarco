<?php
    namespace App\Http\RepoInterfaces\frontend;
    interface AuthInterface{
        public function getAllCities();
        public function getAllNationalities();
        public function Login($data=[]);
        public function Register($data = []);
        public function SendVerificationCode($data);
        public function ActiveAccount($data);
        public function ForgetPassword($data);
        public function ResetAccount($data);
        public function NotFound();
        public function Guest(); 
    }