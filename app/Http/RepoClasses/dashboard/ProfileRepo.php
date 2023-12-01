<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\ProfileInterface;
use App\Http\Resources\dashboard\NotificationsResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileRepo implements ProfileInterface
{
    public $notification;
    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function Profile() {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get Profile Data Operation Success' : $message = 'نجحت عملية استعادة بيانات الملف الشخصي';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
        ],$message,true,200);
    }

    public function UpdateProfile($data = []){
        $savedData = [];
        if($data['name_en'] != null){
            $savedData['name_en'] = $data['name_en'];
        }
        if($data['name_ar'] != null){
            $savedData['name_ar'] = $data['name_ar'];
        }
        if($data['gender'] != null){
            $savedData['gender'] = $data['gender'];
        }
        
        if($data['email'] != null ){
            $savedData['email'] = $data['email'];
        }
        if($data['image'] != null){
            $savedData['image'] = $data['image'];
        }
        if($data['password'] != null){
            $savedData['password'] = Hash::make($data['password']);
        }
        Auth::guard('dashboard')->user()->update($savedData);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Upadte Profile Data Operation Success' : $message = 'نجحت عملية تحديث الملف الشخصي';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
        ],$message,true,200);
    }

    public function UpdateFirebaseToken($firebasetoken){
      
        Auth::guard('dashboard')->user()->update([
            "firebasetoken" => $firebasetoken
        ]);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Upadte FirebaseToken Data Operation Success' : $message = 'نجحت عملية تحديث رمز Firebase';
        return Helper::ResponseData(null,$message,true,200);
    }

    public function UpdateLanguage($language){
      
        Auth::guard('dashboard')->user()->update([
            "language" => $language
        ]);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "Upadte Lnaguage Data Operation Success" : $message = 'نجحت عملية تحديث لغة المستخدم ';
        return Helper::ResponseData(null,$message,true,200);
    }

    public function getAllNotificationsCount(){

        $Pending_Reservation = $this->notification->where('model','Pending_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Ongoing_Reservation = $this->notification->where('model','Ongoing_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Completed_Reservation = $this->notification->where('model','Completed_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Cancelled_Reservation = $this->notification->where('model','Cancelled_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Registeration = $this->notification->where('model','Registeration')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Verification = $this->notification->where('model','Verification')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $UnreadNotifications = $this->notification->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $latestNotifications = $this->notification->where('admin_id',Auth::guard('dashboard')->user()->uuid)->take(10)->latest()->get();


        $data = [
            'Pending_Reservation' => $Pending_Reservation,
            'Ongoing_Reservation' => $Ongoing_Reservation,
            'Completed_Reservation' => $Completed_Reservation,
            'Cancelled_Reservation' => $Cancelled_Reservation,
            'Registeration' => $Registeration,
            'Verification' => $Verification,
            'UnreadNotifications' => $UnreadNotifications,
            'Notifications' => NotificationsResource::collection($latestNotifications)
        ];


        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get News Notifications Operation Success' : $message = 'نجحت عملية الحصول علي احدث الاشعارات ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllNotifications(){
        
        $notification = $this->notification->where('admin_id',Auth::guard('dashboard')->user()->uuid);
        $notification = $notification->latest()->paginate(10);
        $data = [
            'Notifications' => NotificationsResource::collection($notification),
            'Pagination' => [
                'total'       => $notification->total(),
                'count'       => $notification->count(),
                'perPage'     => $notification->perPage(),
                'currentPage' => $notification->currentPage(),
                'totalPages'  => $notification->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Notifications Operation Success' : $message = 'نجحت عملية الحصول علي كل الاشعارات ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function Delete($id){   
        
        $notification = $this->notification->where('uuid',$id)->first();
        if(!$notification){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Notification Not Found' : $message = 'الاشعار غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }
        $notification->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Notification Operation Success' : $message = 'نجحت عملية حذف الاشعار';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function ReadAll($model){   
        if($model == 'All'){
            $notification = $this->notification->where('admin_id',Auth::guard('dashboard')->user()->uuid)->where('is_read',false)->get();

        }else{
            $notification = $this->notification->where('admin_id',Auth::guard('dashboard')->user()->uuid)->where('model',$model)->where('is_read',false)->get();

        }
      
        foreach ($notification as $adminNotification) {
            $adminNotification->update([
                'is_read' => true
            ]);
        }

        $Pending_Reservation = $this->notification->where('model','Pending_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Ongoing_Reservation = $this->notification->where('model','Ongoing_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Completed_Reservation = $this->notification->where('model','Completed_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Cancelled_Reservation = $this->notification->where('model','Cancelled_Reservation')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Registeration = $this->notification->where('model','Registeration')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $Verification = $this->notification->where('model','Verification')->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $UnreadNotifications = $this->notification->where('is_read',false)->where('admin_id',Auth::guard('dashboard')->user()->uuid)->count();
        $latestNotifications = $this->notification->where('admin_id',Auth::guard('dashboard')->user()->uuid)->take(10)->latest()->get();


        $data = [
            'Pending_Reservation' => $Pending_Reservation,
            'Ongoing_Reservation' => $Ongoing_Reservation,
            'Completed_Reservation' => $Completed_Reservation,
            'Cancelled_Reservation' => $Cancelled_Reservation,
            'Registeration' => $Registeration,
            'Verification' => $Verification,
            'UnreadNotifications' => $UnreadNotifications,
            'Notifications' => NotificationsResource::collection($latestNotifications)
        ];



        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Read All Notification Operation Success' : $message = 'نجحت عملية قراءة كل الاشعارات';

        return Helper::ResponseData($data,$message,true,200);

        

    }





    

    public function Logout(){
        Auth::guard('dashboard')->logout();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Logout Operation Success' : $message = 'نجحت عملية تسجيل الخروج';

        return Helper::ResponseData(null,$message,true,200);

    }
                    
}