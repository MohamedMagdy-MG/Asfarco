<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {

        //     return route('login');
        // }else{
        //     request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        //     $language == 'en' ? $message = 'Logout Operation Success' : $message = 'نجحت عملية تسجيل الخروج';

        //     return Helper::ResponseData(null,$message,true,200);
        // }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'You Must Login First!' : $message = 'يجب عليك تسجيل الدخول أولا!';
        abort(Helper::ResponseData(null,$message,false,401));

    }
}
