<?php
    namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\AnalysisInterface;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AnalysisRepo implements AnalysisInterface{
    public $user;
    public $admin;
    public $branches;
    public $reservation;
    public $branch;
    public $car;
    public function __construct()
    {
        $this->user = new User();
        $this->admin = new Admin();
        $this->branches = new Branch();
        $this->reservation = new Reservation();
        $this->branch = new Branch();
        $this->car = new Car();
    }

    public function Cards(){
        if(Auth::guard('dashboard')->user()->role == 'Admin'){
            $No_Admins = $this->admin->where('role','Admin')->count();
            $No_BranchEmployees = $this->admin->where('role','Branch Employee')->count();
            $No_BranchManagers = $this->admin->where('role','Branch Manager')->count();
            $No_Managers = $this->admin->where('role','Manager')->count();
            $No_PendingUsers = $this->user->where('verify_document',false)->where('verify_document_at',null)->where('email_verified_at','!=',null)->whereHas('Documents')->count();
            $No_SuspendUsers = $this->user->where('active',false)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
            $No_UnVerificationsUsers = $this->user->where('email_verified_at',null)->count();
            $No_ActiveUsers = $this->user->where('active',true)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
            $No_Active_Cars = $this->car->where('active',true)->count();
            $No_Deactive_Cars = $this->car->where('active',false)->count();
            $No_Cars = $this->car->count();
    
            $Today_OnGoing_Reservations = $this->reservation->where('status','Pending')->whereDate('pickup',Carbon::today())->count();
            $Today_Cancelled_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->count();
    
            $Today_Income_Reservations = $this->reservation->where('status','!=','Cancelled')->whereDate('created_at',Carbon::today())->get();
            $Total_Today_Income_Visa = 0;
            $Total_Today_Income_Cash = 0;
            foreach($Today_Income_Reservations as $Today_Income_Reservation){
                if($Today_Income_Reservation->payment_mode == "Visa"){
                    $Total_Today_Income_Visa = $Total_Today_Income_Visa + $Today_Income_Reservation->Price->total;
                }
                else{
                    $Total_Today_Income_Cash = $Total_Today_Income_Cash + $Today_Income_Reservation->Price->total;

                }
            }
            $Today_Refund_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->get();
            $Total_Today_Refund_Visa = 0;
            $Total_Today_Refund_Cash = 0;
            foreach($Today_Refund_Reservations as $Today_Refund_Reservation){
                if($Today_Refund_Reservation->payment_mode == "Visa"){
                    $Total_Today_Refund_Visa = $Total_Today_Refund_Visa + $Today_Refund_Reservation->Price->total;
                }
                else{
                    $Total_Today_Refund_Cash = $Total_Today_Refund_Cash + $Today_Refund_Reservation->Price->total;

                }
            }
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
    
    
            $data = [  
                'No_Admins' => $No_Admins,
                'No_BranchEmployees' => $No_BranchEmployees,
                'No_BranchManagers' => $No_BranchManagers,
                'No_Managers' => $No_Managers,
                'No_PendingUsers' => $No_PendingUsers,
                'No_SuspendUsers' => $No_SuspendUsers,
                'No_UnVerificationsUsers' => $No_UnVerificationsUsers,
                'No_ActiveUsers' => $No_ActiveUsers,
                'No_Active_Cars' => $No_Active_Cars,
                'No_Deactive_Cars' => $No_Deactive_Cars,
                'No_Cars' => $No_Cars,
                'Today_OnGoing_Reservations' => $Today_OnGoing_Reservations,
                'Today_Cancelled_Reservations' => $Today_Cancelled_Reservations,
                'Total_Today_Income_Visa' => $Total_Today_Income_Visa,
                'Total_Today_Income_Cash' => $Total_Today_Income_Cash,
                'Total_Today_Refund_Visa' => $Total_Today_Refund_Visa,
                'Total_Today_Refund_Cash' => $Total_Today_Refund_Cash,
            ];
        }
        else if(Auth::guard('dashboard')->user()->role == 'Manager'){
            $No_BranchEmployees = $this->admin->where('role','Branch Employee')->count();
            $No_BranchManagers = $this->admin->where('role','Branch Manager')->count();
            $No_PendingUsers = $this->user->where('verify_document',false)->where('verify_document_at',null)->where('email_verified_at','!=',null)->whereHas('Documents')->count();
            $No_SuspendUsers = $this->user->where('active',false)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
            $No_UnVerificationsUsers = $this->user->where('email_verified_at',null)->count();
            $No_ActiveUsers = $this->user->where('active',true)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
            $No_Active_Cars = $this->car->where('active',true)->count();
            $No_Deactive_Cars = $this->car->where('active',false)->count();
            $No_Cars = $this->car->count();
    
            $Today_OnGoing_Reservations = $this->reservation->where('status','Pending')->whereDate('pickup',Carbon::today())->count();
            $Today_Cancelled_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->count();
    
            $Today_Income_Reservations = $this->reservation->where('status','!=','Cancelled')->whereDate('created_at',Carbon::today())->get();
            $Total_Today_Income_Visa = 0;
            $Total_Today_Income_Cash = 0;
            foreach($Today_Income_Reservations as $Today_Income_Reservation){
                if($Today_Income_Reservation->payment_mode == "Visa"){
                    $Total_Today_Income_Visa = $Total_Today_Income_Visa + $Today_Income_Reservation->Price->total;
                }
                else{
                    $Total_Today_Income_Cash = $Total_Today_Income_Cash + $Today_Income_Reservation->Price->total;

                }
            }
            $Today_Refund_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->get();
            $Total_Today_Refund_Visa = 0;
            $Total_Today_Refund_Cash = 0;
            foreach($Today_Refund_Reservations as $Today_Refund_Reservation){
                if($Today_Refund_Reservation->payment_mode == "Visa"){
                    $Total_Today_Refund_Visa = $Total_Today_Refund_Visa + $Today_Refund_Reservation->Price->total;
                }
                else{
                    $Total_Today_Refund_Cash = $Total_Today_Refund_Cash + $Today_Refund_Reservation->Price->total;

                }
            }
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
    
    
            $data = [  
                'No_BranchEmployees' => $No_BranchEmployees,
                'No_BranchManagers' => $No_BranchManagers,
                'No_PendingUsers' => $No_PendingUsers,
                'No_SuspendUsers' => $No_SuspendUsers,
                'No_UnVerificationsUsers' => $No_UnVerificationsUsers,
                'No_ActiveUsers' => $No_ActiveUsers,
                'No_Active_Cars' => $No_Active_Cars,
                'No_Deactive_Cars' => $No_Deactive_Cars,
                'No_Cars' => $No_Cars,
                'Today_OnGoing_Reservations' => $Today_OnGoing_Reservations,
                'Today_Cancelled_Reservations' => $Today_Cancelled_Reservations,
                'Total_Today_Income_Visa' => $Total_Today_Income_Visa,
                'Total_Today_Income_Cash' => $Total_Today_Income_Cash,
                'Total_Today_Refund_Visa' => $Total_Today_Refund_Visa,
                'Total_Today_Refund_Cash' => $Total_Today_Refund_Cash,
            ];
        }
        else if(Auth::guard('dashboard')->user()->role == 'Branch Manager'){
            $No_BranchEmployees = $this->admin->where('role','Branch Employee')->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();
            $No_PendingUsers = $this->user->where('verify_document',false)->where('verify_document_at',null)->where('email_verified_at','!=',null)->whereHas('Documents')->count();
            $No_SuspendUsers = $this->user->where('active',false)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
            $No_UnVerificationsUsers = $this->user->where('email_verified_at',null)->count();
            $No_ActiveUsers = $this->user->where('active',true)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();


            $No_Active_Cars = $this->car->where('active',true)->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();
            $No_Deactive_Cars = $this->car->where('active',false)->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();
            $No_Cars = $this->car->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();

            $Today_OnGoing_Reservations = $this->reservation->where('status','Pending')->whereDate('pickup',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->count();

            
            $Today_Cancelled_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->count();

            $Today_Income_Reservations = $this->reservation->where('status','!=','Cancelled')->whereDate('created_at',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->get();

            $Total_Today_Income_Visa = 0;
            $Total_Today_Income_Cash = 0;
            foreach($Today_Income_Reservations as $Today_Income_Reservation){
                if($Today_Income_Reservation->payment_mode == "Visa"){
                    $Total_Today_Income_Visa = $Total_Today_Income_Visa + $Today_Income_Reservation->Price->total;
                }
                else{
                    $Total_Today_Income_Cash = $Total_Today_Income_Cash + $Today_Income_Reservation->Price->total;

                }
            }
            $Today_Refund_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->get();
            $Total_Today_Refund_Visa = 0;
            $Total_Today_Refund_Cash = 0;
            foreach($Today_Refund_Reservations as $Today_Refund_Reservation){
                if($Today_Refund_Reservation->payment_mode == "Visa"){
                    $Total_Today_Refund_Visa = $Total_Today_Refund_Visa + $Today_Refund_Reservation->Price->total;
                }
                else{
                    $Total_Today_Refund_Cash = $Total_Today_Refund_Cash + $Today_Refund_Reservation->Price->total;

                }
            }
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';


            $data = [  
                'No_BranchEmployees' => $No_BranchEmployees,
                'No_PendingUsers' => $No_PendingUsers,
                'No_SuspendUsers' => $No_SuspendUsers,
                'No_UnVerificationsUsers' => $No_UnVerificationsUsers,
                'No_ActiveUsers' => $No_ActiveUsers,
                'No_Active_Cars' => $No_Active_Cars,
                'No_Deactive_Cars' => $No_Deactive_Cars,
                'No_Cars' => $No_Cars,
                'Today_OnGoing_Reservations' => $Today_OnGoing_Reservations,
                'Today_Cancelled_Reservations' => $Today_Cancelled_Reservations,
                'Total_Today_Income_Visa' => $Total_Today_Income_Visa,
                'Total_Today_Income_Cash' => $Total_Today_Income_Cash,
                'Total_Today_Refund_Visa' => $Total_Today_Refund_Visa,
                'Total_Today_Refund_Cash' => $Total_Today_Refund_Cash,
            ];
        }
        else{
            $No_PendingUsers = $this->user->where('verify_document',false)->where('verify_document_at',null)->where('email_verified_at','!=',null)->whereHas('Documents')->count();
            $No_SuspendUsers = $this->user->where('active',false)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();
            $No_UnVerificationsUsers = $this->user->where('email_verified_at',null)->count();
            $No_ActiveUsers = $this->user->where('active',true)->where('email_verified_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null)->count();


            $No_Active_Cars = $this->car->where('active',true)->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();
            $No_Deactive_Cars = $this->car->where('active',false)->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();
            $No_Cars = $this->car->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);})->count();

            $Today_OnGoing_Reservations = $this->reservation->where('status','Pending')->whereDate('pickup',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->count();

            
            $Today_Cancelled_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->count();

            $Today_Income_Reservations = $this->reservation->where('status','!=','Cancelled')->whereDate('created_at',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->get();

            $Total_Today_Income_Visa = 0;
            $Total_Today_Income_Cash = 0;
            foreach($Today_Income_Reservations as $Today_Income_Reservation){
                if($Today_Income_Reservation->payment_mode == "Visa"){
                    $Total_Today_Income_Visa = $Total_Today_Income_Visa + $Today_Income_Reservation->Price->total;
                }
                else{
                    $Total_Today_Income_Cash = $Total_Today_Income_Cash + $Today_Income_Reservation->Price->total;

                }
            }
            $Today_Refund_Reservations = $this->reservation->where('status','Cancelled')->whereDate('cancelled_on',Carbon::today())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->get();
            $Total_Today_Refund_Visa = 0;
            $Total_Today_Refund_Cash = 0;
            foreach($Today_Refund_Reservations as $Today_Refund_Reservation){
                if($Today_Refund_Reservation->payment_mode == "Visa"){
                    $Total_Today_Refund_Visa = $Total_Today_Refund_Visa + $Today_Refund_Reservation->Price->total;
                }
                else{
                    $Total_Today_Refund_Cash = $Total_Today_Refund_Cash + $Today_Refund_Reservation->Price->total;

                }
            }
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';


            $data = [  
                'No_PendingUsers' => $No_PendingUsers,
                'No_SuspendUsers' => $No_SuspendUsers,
                'No_UnVerificationsUsers' => $No_UnVerificationsUsers,
                'No_ActiveUsers' => $No_ActiveUsers,
                'No_Active_Cars' => $No_Active_Cars,
                'No_Deactive_Cars' => $No_Deactive_Cars,
                'No_Cars' => $No_Cars,
                'Today_OnGoing_Reservations' => $Today_OnGoing_Reservations,
                'Today_Cancelled_Reservations' => $Today_Cancelled_Reservations,
                'Total_Today_Income_Visa' => $Total_Today_Income_Visa,
                'Total_Today_Income_Cash' => $Total_Today_Income_Cash,
                'Total_Today_Refund_Visa' => $Total_Today_Refund_Visa,
                'Total_Today_Refund_Cash' => $Total_Today_Refund_Cash,
            ];
        }
        
        $language == 'en' ? $message = 'Get Analysis Cards Operation Success' : $message = 'نجحت عملية الحصول كروت التحليل ';
        return Helper::ResponseData($data,$message,true,200);
    }

    public function Charts($year){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if(Auth::guard('dashboard')->user()->role == 'Admin' || Auth::guard('dashboard')->user()->role == 'Manager'){
            if($year == 'All'){
                $completed_data = [];
                $completed_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $completed_data_sum = $completed_data_sum + $this->reservation->where('status','Completed')->whereMonth('return',$month)->count();
                    array_push($completed_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Completed')->whereMonth('return',$month)->count(),
                    ]);
                }
                $cancelled_data = [];
                $cancelled_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $cancelled_data_sum = $cancelled_data_sum + $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->count();
                    array_push($cancelled_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->count(),
                    ]);
                }
            }
            else{
                if($year == null){
                    $year = Carbon::now()->year;
                }
                $completed_data = [];
                $completed_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $completed_data_sum = $completed_data_sum + $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereYear('return',$year)->count();
                    array_push($completed_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereYear('return',$year)->count(),
                    ]);
                }
                $cancelled_data = [];
                $cancelled_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $cancelled_data_sum = $cancelled_data_sum + $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereYear('cancelled_on',$year)->count();
                    array_push($cancelled_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereYear('cancelled_on',$year)->count(),
                    ]);
                }
            }
            
            $data = [
                'completed' => $completed_data,
                'completed_sum' => $completed_data_sum,
                'cancelled' => $cancelled_data,
                'cancelled_sum' => $cancelled_data_sum,
            ];
        }
        else{
            if($year == 'All'){
                $completed_data = [];
                $completed_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $completed_data_sum = $completed_data_sum + $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereHas('Car',function(Builder $query){
                        $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                    })->count();
                    array_push($completed_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereHas('Car',function(Builder $query){
                            $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                        })->count(),
                    ]);
                }
                $cancelled_data = [];
                $cancelled_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $cancelled_data_sum = $cancelled_data_sum + $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereHas('Car',function(Builder $query){
                        $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                    })->count();
                    array_push($cancelled_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereHas('Car',function(Builder $query){
                            $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                        })->count(),
                    ]);
                }
            }
            else{
                if($year == null){
                    $year = Carbon::now()->year;
                }
                $completed_data = [];
                $completed_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $completed_data_sum = $completed_data_sum + $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereYear('return',$year)->whereHas('Car',function(Builder $query){
                        $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                    })->count();
                    array_push($completed_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereYear('return',$year)->whereHas('Car',function(Builder $query){
                            $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                        })->count(),
                    ]);
                }
                $cancelled_data = [];
                $cancelled_data_sum = 0;
                for ($month = 1; $month <= 12; $month++) { 
                    $cancelled_data_sum = $cancelled_data_sum + $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereYear('cancelled_on',$year)->whereHas('Car',function(Builder $query){
                        $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                    })->count();
                    array_push($cancelled_data,[
                        'month' => $month,
                        'count' => $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereYear('cancelled_on',$year)->whereHas('Car',function(Builder $query){
                            $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
                        })->count(),
                    ]);
                }
            }
            
            $data = [
                'completed' => $completed_data,
                'completed_sum' => $completed_data_sum,
                'cancelled' => $cancelled_data,
                'cancelled_sum' => $cancelled_data_sum,
            ];
        }
        
        
        $language == 'en' ? $message = 'Get the success of the analysis charts process' : $message = 'نجاح عملية الحصول علي مخططات التحليل ';
        return Helper::ResponseData($data,$message,true,200);
    }

    public function BranchCharts($year){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if(Auth::guard('dashboard')->user()->role == 'Admin' || Auth::guard('dashboard')->user()->role == 'Manager'){
            $branches = $this->branch->where('active',true)->get();
        }else{
            $branches = $this->branch->where('active',true)->where('uuid',Auth::guard('dashboard')->user()->branch_id)->get();
        }
        
        $data = [];
        foreach ($branches as $branch) {
            $completed_total_sum = 0;
            $cancelled_total_sum = 0;
            if($year == 'All'){
                $result_data = [];
                
                for ($month = 1; $month <= 12; $month++) { 
                    $total = 0;
                    $reservations = $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereHas('Car',function(Builder $query)use($branch){
                        $query->whereHas('Branch',function(Builder $query)use($branch){$query->where('uuid',$branch->uuid);});
                    })->get();
                    foreach ($reservations as $reservation) {
                        $completed_total = $total + $reservation->Price->total;
                    }
                    $reservations = $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereHas('Car',function(Builder $query)use($branch){
                        $query->whereHas('Branch',function(Builder $query)use($branch){$query->where('uuid',$branch->uuid);});
                    })->get();
                    foreach ($reservations as $reservation) {
                        $cancelled_total = $total + $reservation->Price->total;
                    }
                    $completed_total_sum = $completed_total_sum + $completed_total;
                    $cancelled_total_sum = $cancelled_total_sum + $cancelled_total;
                    array_push($result_data,[
                        'month' => $month,
                        'total' => [
                            'completed' => $completed_total,
                            'cancelled' => $cancelled_total
                        ],
                    ]);
                }

                
               
            }
            else{
                if($year == null){
                    $year = Carbon::now()->year;
                }

                $result_data = [];
                
                for ($month = 1; $month <= 12; $month++) { 
                    $completed_total = 0;
                    $cancelled_total = 0;
                    $reservations = $this->reservation->where('status','Completed')->whereMonth('return',$month)->whereYear('return',$year)->whereHas('Car',function(Builder $query)use($branch){
                        $query->whereHas('Branch',function(Builder $query)use($branch){$query->where('uuid',$branch->uuid);});
                    })->get();
                    foreach ($reservations as $reservation) {
                        $completed_total = $completed_total + $reservation->Price->total;
                    }
                    $reservations = $this->reservation->where('status','Cancelled')->whereMonth('cancelled_on',$month)->whereYear('cancelled_on',$year)->whereHas('Car',function(Builder $query)use($branch){
                        $query->whereHas('Branch',function(Builder $query)use($branch){$query->where('uuid',$branch->uuid);});
                    })->get();
                    foreach ($reservations as $reservation) {
                        $cancelled_total = $cancelled_total + $reservation->Price->total;
                    }
                    $completed_total_sum = $completed_total_sum + $completed_total;
                    $cancelled_total_sum = $cancelled_total_sum + $cancelled_total;
                    array_push($result_data,[
                        'month' => $month,
                        'total' => [
                            'completed' => $completed_total,
                            'cancelled' => $cancelled_total
                        ],
                    ]);
                }

            }
            
            array_push($data , [
                'name' => $language == 'ar' ? $branch->name_ar : $branch->name_en,
                'result' => $result_data,
                'completed_total_sum' => $completed_total_sum,
                'cancelled_total_sum' => $cancelled_total_sum
            ]);
        }
        
        
        
        
        
        $language == 'en' ? $message = 'Get the success of the analysis brach reservations chart process' : $message = 'نجاح عملية الحصول علي مخططات تحليل حجوزات الفروع ';
        return Helper::ResponseData($data,$message,true,200);
    }

    function dateDiffInDays($date1, $date2) 
    {
        $diff = strtotime($date2) - strtotime($date1);
        if(is_integer(abs($diff / 86400))){
            return abs($diff / 86400);
        } else{
            $number = explode(('.'),abs($diff / 86400));
            return (int)$number[0] + 1;

        }
    }
    public function LatestOnGoing(){
        $data = [];
        
        if(Auth::guard('dashboard')->user()->role == 'Admin' || Auth::guard('dashboard')->user()->role == 'Manager'){
            $reservations = $this->reservation->where('status','Ongoing')->whereDate('pickup',Carbon::today())->where('pickup','<=',Carbon::now()->toDateTimeString())->latest()->take(4)->get();
        }else{
            $reservations = $this->reservation->where('status','Ongoing')->whereDate('pickup',Carbon::today())->where('pickup','<=',Carbon::now()->toDateTimeString())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->latest()->take(4)->get();
        }
        
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';

        foreach ($reservations as $reservation) {
            array_push($data,[
                'user' => $reservation->User->name,
                'car' => $language == "ar" ? $reservation->Car->name_ar  : $reservation->Car->name_en,
                'color' => $language == "ar" ? $reservation->Color->name_ar  : $reservation->Color->name_en,
                'total' => $reservation->Price->total,
                'mode' => $reservation->mode,
                'days' => $this->dateDiffInDays($reservation->pickup,$reservation->return),
                'branch' => $language == "ar" ? $reservation->Car->Branch->name_ar  : $reservation->Car->Branch->name_en

            ]);
        }
        
        
        $language == 'en' ? $message = 'Get the success of the latest ongoing reservations table process' : $message = 'نجاح عملية الحصول علي جدول الحجوزات المستمرة ';
        return Helper::ResponseData($data,$message,true,200);
    }

    public function LatestCompleted(){
        $data = [];
        $reservations = $this->reservation->where('status','Completed')->whereDate('return',Carbon::today())->where('return','<=',Carbon::now()->toDateTimeString())->latest()->take(4)->get();
        
        
        if(Auth::guard('dashboard')->user()->role == 'Admin' || Auth::guard('dashboard')->user()->role == 'Manager'){
            $reservations = $this->reservation->where('status','Completed')->whereDate('return',Carbon::today())->where('return','<=',Carbon::now()->toDateTimeString())->latest()->take(4)->get();
        }else{
            $reservations = $this->reservation->where('status','Completed')->whereDate('return',Carbon::today())->where('return','<=',Carbon::now()->toDateTimeString())->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){$query->where('uuid',Auth::guard('dashboard')->user()->branch_id);});
            })->latest()->take(4)->get();

           
        }
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';

        foreach ($reservations as $reservation) {
            array_push($data,[
                'user' => $reservation->User->name,
                'car' => $language == "ar" ? $reservation->Car->name_ar  : $reservation->Car->name_en,
                'color' => $language == "ar" ? $reservation->Color->name_ar  : $reservation->Color->name_en,
                'total' => $reservation->Price->total,
                'mode' => $reservation->mode,
                'days' => $this->dateDiffInDays($reservation->pickup,$reservation->return),
                'branch' => $language == "ar" ? $reservation->Car->Branch->name_ar  : $reservation->Car->Branch->name_en

            ]);
        }
        
        
        $language == 'en' ? $message = 'Get the success of the latest completed reservations table process' : $message = 'نجاح عملية الحصول علي جدول الحجوزات الأخيرة المكتملة ';
        return Helper::ResponseData($data,$message,true,200);
    }

    
}