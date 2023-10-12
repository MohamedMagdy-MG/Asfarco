<?php
    namespace App\Http\RepoInterfaces\mobile;
    interface UploadsInterface{
        public function SaveImage($image);
        public function SaveImages($images);
    }