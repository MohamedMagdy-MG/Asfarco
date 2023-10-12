<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\BranchManagerInterface;
use App\Http\Resources\dashboard\BranchCustomResource;
use App\Http\Resources\dashboard\BranchManagerResource;
use App\Mail\InvitationsEmail;
use App\Models\Admin;
use App\Models\Avatar;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class BranchManagerRepo implements BranchManagerInterface
{
       
    public $branchManager;
    public $branch;
    public $avatar;
    public function __construct()
    {
        $this->branchManager = new Admin();
        $this->branch = new Branch();
        $this->avatar = new Avatar();
    }

    public function getAllBranchManagers($search,$branch){
        
        $branchManagers = $this->branchManager->where('role','Branch Manager');
        if($branch != null){
            $branchManagers = $branchManagers->where(function(Builder $query) use($branch){
                $query->whereHas('Branch',function(Builder $query) use($branch){
                    $query->where('uuid',$branch);
                });
               
            });
            
        }
        if($search != null){
            $branchManagers = $branchManagers->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('email',$search);
            });
            
        }
        
        $branchManagers = $branchManagers->latest()->paginate(10);
        $data = [
            'BranchManagers' => BranchManagerResource::collection($branchManagers),
            'Pagination' => [
                'total'       => $branchManagers->total(),
                'count'       => $branchManagers->count(),
                'perPage'     => $branchManagers->perPage(),
                'currentPage' => $branchManagers->currentPage(),
                'totalPages'  => $branchManagers->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Branch Mangers Operation Success' : $message = 'نجحت عملية الحصول علي كل مدراء الفروع ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllBranches($search){
        
        $branches = $this->branch;
        
        if($search != null){
            $branches = $branches->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('email',$search);
            });
            
        }
        
        $branches = $branches->latest()->get();
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Branches Operation Success' : $message = 'نجحت عملية الحصول علي كل الفروع ';

        return Helper::ResponseData(BranchCustomResource::collection($branches),$message,true,200);
    }

    public function Add($data = []){ 
        
        $branch = $this->branch->where('uuid',$data['branch'])->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Branch Not Found' : $message = 'فرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }
        
        if($data['image'] == null){
            $avatar = $this->avatar->where('gender',$data['gender'])->inRandomOrder()->first();
            $data['image'] = $avatar->image;
        } 
        $branchManagerData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'image' => $data['image'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(10)),
            'role' => 'Branch Manager',
            'branch_id' => $data['branch']
        ];
        $branchManager = $this->branchManager->create($branchManagerData);
        

        $data = [
            'link' => "https://admin.asfarcogroup.com/verification?e=".Crypt::encryptString($branchManager->email),
            'email' => $branchManager->email
        ];
        Mail::to($data['email'])->send(new InvitationsEmail($data));
        
        

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Branch Manager Operation Success' : $message = 'نجحت عملية اضافة مدير الفرع';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $branchManager = $this->branchManager->where('uuid',$id)->first();
        if(!$branchManager){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Branch Manager Not Found' : $message = 'مدير الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $branchManager->forceDelete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Branch Manager Operation Success' : $message = 'نجحت عملية حذف مدير الفرع';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function Active($id){   
        
        $branchManager = $this->branchManager->where('uuid',$id)->first();
        if(!$branchManager){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Branch Manager Not Found' : $message = 'مدير الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        if($branchManager->active == true){
            $branchManager->update([
                'active' => false
            ]);
        }
        else{
            if($branchManager->Branch->active == false){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'User branch is inactive' : $message = 'فرع المستخدم غير نشط';
                return Helper::ResponseData(null,$message,false,400);
            }
            $branchManager->update([
                'active' => true
            ]);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Change Branch Manager Status Operation Success' : $message = 'نجحت عملية تعديل حالة مدير الفرع';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

                    
}