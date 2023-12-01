<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\ReservationInterface;
use App\Http\Resources\dashboard\ReservationResource;
use App\Models\Reservation;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReservationRepo implements ReservationInterface
{
       
    public $reservation;
    public function __construct()
    {
        $this->reservation = new Reservation();
    }

    public function getAllPendingReservation($start_date,$end_date,$search){
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $reservations = $this->reservation->where('status','Pending')->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){
                    $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
                });
            });
        }else{
            $reservations = $this->reservation->where('status','Pending');
        }
        
        if($start_date == null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($end_date){
                $query->whereDate('return',$end_date);
            });
        }
        if($start_date != null && $end_date == null){
            $reservations = $reservations->where(function(Builder $query) use($start_date){
                $query->whereDate('pickup',$start_date);
            });
        }

        if($start_date != null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($start_date,$end_date){
                $query->whereDate('pickup','>=',$start_date)->whereDate('return','<=',$end_date);
            });
        }
        if($search != null){
            $reservations = $reservations->where(function(Builder $query) use($search){
                $query->whereHas('User',function(Builder $query) use($search){
                    $query->where('name','LIKE','%'.$search.'%')
                    ->orWhere('email',$search)
                    ->orWhere('mobile','LIKE','%'.$search.'%');
                })
                ->orWhere('uuid',$search);
            });
            
        }
        $reservations = $reservations->latest()->paginate(10);
        $data = [
            'Reservations' => ReservationResource::collection($reservations),
            'Pagination' => [
                'total'       => $reservations->total(),
                'count'       => $reservations->count(),
                'perPage'     => $reservations->perPage(),
                'currentPage' => $reservations->currentPage(),
                'totalPages'  => $reservations->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process of obtaining all pending reservations was successful' : $message = 'تمت عملية الحصول على كافة الحجوزات المعلقة بنجاح ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllOngoingReservation($start_date,$end_date,$search){
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $reservations = $this->reservation->where('status','Ongoing')->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){
                    $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
                });
            });
        }else{
            $reservations = $this->reservation->where('status','Ongoing');
        }
        if($start_date == null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($end_date){
                $query->whereDate('return',$end_date);
            });
        }
        if($start_date != null && $end_date == null){
            $reservations = $reservations->where(function(Builder $query) use($start_date){
                $query->whereDate('pickup',$start_date);
            });
        }

        if($start_date != null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($start_date,$end_date){
                $query->whereDate('pickup','>=',$start_date)->whereDate('return','<=',$end_date);
            });
        }
        if($search != null){
            $reservations = $reservations->where(function(Builder $query) use($search){
                $query->whereHas('User',function(Builder $query) use($search){
                    $query->where('name','LIKE','%'.$search.'%')
                    ->orWhere('email',$search)
                    ->orWhere('mobile','LIKE','%'.$search.'%');
                })
                ->orWhere('uuid',$search);
            });
            
        }
        $reservations = $reservations->latest()->paginate(10);
        $data = [
            'Reservations' => ReservationResource::collection($reservations),
            'Pagination' => [
                'total'       => $reservations->total(),
                'count'       => $reservations->count(),
                'perPage'     => $reservations->perPage(),
                'currentPage' => $reservations->currentPage(),
                'totalPages'  => $reservations->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process of obtaining all ongoing reservations was successful' : $message = 'تمت عملية الحصول على كافة الحجوزات المستمرة بنجاح ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllCompletedReservation($start_date,$end_date,$search){
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $reservations = $this->reservation->where('status','Completed')->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){
                    $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
                });
            });
        }else{
            $reservations = $this->reservation->where('status','Completed');
        }
        if($start_date == null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($end_date){
                $query->whereDate('return',$end_date);
            });
        }
        if($start_date != null && $end_date == null){
            $reservations = $reservations->where(function(Builder $query) use($start_date){
                $query->whereDate('pickup',$start_date);
            });
        }

        if($start_date != null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($start_date,$end_date){
                $query->whereDate('pickup','>=',$start_date)->whereDate('return','<=',$end_date);
            });
        }
        if($search != null){
            $reservations = $reservations->where(function(Builder $query) use($search){
                $query->whereHas('User',function(Builder $query) use($search){
                    $query->where('name','LIKE','%'.$search.'%')
                    ->orWhere('email',$search)
                    ->orWhere('mobile','LIKE','%'.$search.'%');
                })
                ->orWhere('uuid',$search);
            });
            
        }
        $reservations = $reservations->latest()->paginate(10);
        $data = [
            'Reservations' => ReservationResource::collection($reservations),
            'Pagination' => [
                'total'       => $reservations->total(),
                'count'       => $reservations->count(),
                'perPage'     => $reservations->perPage(),
                'currentPage' => $reservations->currentPage(),
                'totalPages'  => $reservations->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process of obtaining all completed reservations was successful' : $message = 'تمت عملية الحصول على جميع الحجوزات المكتملة بنجاح ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function getAllCancelledReservation($start_date,$end_date,$search){
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $reservations = $this->reservation->where('status','Cancelled')->whereHas('Car',function(Builder $query){
                $query->whereHas('Branch',function(Builder $query){
                    $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
                });
            });
        }else{
            $reservations = $this->reservation->where('status','Cancelled');
        }
        if($start_date == null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($end_date){
                $query->whereDate('return',$end_date);
            });
        }
        if($start_date != null && $end_date == null){
            $reservations = $reservations->where(function(Builder $query) use($start_date){
                $query->whereDate('pickup',$start_date);
            });
        }

        if($start_date != null && $end_date != null){
            $reservations = $reservations->where(function(Builder $query) use($start_date,$end_date){
                $query->whereDate('pickup','>=',$start_date)->whereDate('return','<=',$end_date);
            });
        }
        if($search != null){
            $reservations = $reservations->where(function(Builder $query) use($search){
                $query->whereHas('User',function(Builder $query) use($search){
                    $query->where('name','LIKE','%'.$search.'%')
                    ->orWhere('email',$search)
                    ->orWhere('mobile','LIKE','%'.$search.'%');
                })
                ->orWhere('uuid',$search);
            });
            
        }
        $reservations = $reservations->latest()->paginate(10);
        $data = [
            'Reservations' => ReservationResource::collection($reservations),
            'Pagination' => [
                'total'       => $reservations->total(),
                'count'       => $reservations->count(),
                'perPage'     => $reservations->perPage(),
                'currentPage' => $reservations->currentPage(),
                'totalPages'  => $reservations->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process of obtaining all cancelled reservations was successful' : $message = 'تمت عملية الحصول على جميع الحجوزات الملغاة بنجاح ';

        return Helper::ResponseData($data,$message,true,200);
    }
   

    

    

                    
}