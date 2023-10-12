<?php
namespace App\Http\RepoClasses\dashboard;

use App\Http\RepoInterfaces\dashboard\UploadsInterface;

class UploadsRepo implements UploadsInterface{

  
    public function SaveImage($image) {
        $imageName = null;
        if(is_file($image)){
            $imageName = 'media/'.time().'.'.$image->getClientOriginalExtension();
            $image->move('media',$imageName);
        }


        $name = $image->getClientOriginalName();



        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Image Operation Success' : $message = 'نجحت عملية اضافة الصورة';

        return response()->json([
            'data' => [
                'image' => env('APP_URL').$imageName,
                'name' => $name,
            ],
            'message' => $message,
            'status' => true,
            'error' => []
        ])->setStatusCode(200)
        ->withHeaders([
            'Access-Control-Allow-Origin' , '*'
        ]);
    }

    public function SaveImages($images) {
        $data = [];
        foreach ($images as $index => $image) {
            $imageName = null;
            if(is_file($image)){
                $imageName = 'media/'.'-'.$index.'-'.time().'.'.$image->getClientOriginalExtension();
               
                $image->move('media',$imageName);

                $name = $image->getClientOriginalName();
                array_push($data,
                    env('APP_URL').$imageName
                );
            }


            

        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Image Operation Success' : $message = 'نجحت عملية اضافة الصورة';

        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => true,
            'error' => []
        ])->setStatusCode(200)
        ->withHeaders([
            'Access-Control-Allow-Origin' , '*'
        ]);
    }

  

   
  
}