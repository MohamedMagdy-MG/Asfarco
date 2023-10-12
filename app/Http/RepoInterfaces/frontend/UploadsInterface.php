<?php
    namespace App\Http\RepoInterfaces\frontend;
    interface UploadsInterface{
        public function SaveImage($image);
        public function SaveImages($images);
    }