<?php
    namespace App\Http\RepoInterfaces\dashboard;
    interface UploadsInterface{
        public function SaveImage($image);
        public function SaveImages($images);
    }