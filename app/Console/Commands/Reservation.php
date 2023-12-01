<?php


namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Reservation as ModelsReservation;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class Reservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:reservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Reservation to Ongoing,Completed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $reservation;
    public function __construct()
    {
        $this->reservation = new ModelsReservation();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $startTime = Carbon::parse(Carbon::now(new DateTimeZone('Asia/Dubai'))->toDateTimeString());
        $finishTime = Carbon::parse(Carbon::now(new DateTimeZone('Asia/Dubai'))->toDateTimeString());

        $completed_reservations = $this->reservation->where('status','Ongoing')->get();
        foreach($completed_reservations as $reservation){
            $totalDuration = $finishTime->diffInSeconds($reservation->return);
            if($totalDuration < 60 ){
                $reservation->update([
                    'status' => 'Completed'
                ]);
                
                //Notification
                $notification_data = [
                    'model' => 'Completed_Reservation',
                    'title_en' => 'Asfarco - Reservation',
                    'title_ar' => 'اسفاركو - الحجوزات',
                    'message_en' => "User ".$reservation->User->name."'s in a ".$reservation->Car->name_en." car ended",
                    'message_ar' => "انتهت رحلة المستخدم ".$reservation->User->name." بسيارة ".$reservation->Car->name_ar,

                    'branch_id' => $reservation->Car->branch_id
                ];
                Helper::sendNotifyToDashboard($notification_data);
            }
            
        }
        
        $ongoing_reservations = $this->reservation->where('status','Pending')->get();
        foreach($ongoing_reservations as $reservation){
            $totalDuration = $startTime->diffInSeconds($reservation->pickup);
            if($totalDuration < 60 ){
                $reservation->update([
                    'status' => 'Ongoing'
                ]);

                //Notification
                $notification_data = [
                    'model' => 'Ongoing_Reservation',
                    'title_en' => 'Asfarco - Reservation',
                    'title_ar' => 'اسفاركو - الحجوزات',
                    'message_en' => "User ".$reservation->User->name."'s journey began with a ".$reservation->Car->name_en." car",
                    'message_ar' => "بدأت رحلة المستخدم ".$reservation->User->name." بسيارة ".$reservation->Car->name_ar,
                    'branch_id' => $reservation->Car->branch_id
                ];
                Helper::sendNotifyToDashboard($notification_data);
            }
            
           
        }

        
       

        
        
    }
}