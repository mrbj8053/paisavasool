<?php
namespace App\Console\Commands;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use userHelper;

use Illuminate\Console\Command;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
     public function handle()
    {
        \Log::info("Cron is working fine!");
     
        $this->sendCroneIncomes();
      
        $this->info('incomemyCron:Cron Cummand Run successfully!');
    }
      public function sendCroneIncomes()
    {
        
       $day = date('D');
        if($day!='Sat' && $day!='Sun')
        {
            
        
        
        
        //send roi singole leg income  and level income
        
        $getAllSingle=DB::table("roi")->where('amountmax','>',0)->get();
        foreach($getAllSingle as $single)
        {
            if($single->remaining>0 && $single->sent<$single->amountmax)
            {
                $plan=userHelper::getPlanDetails($single->planid);
                $amount=round((($plan->roi/22)/100)*$plan->entryamount,2);
           
                //now send finally single leg income income 
                $sendSingleLegIncome["fromuser"]=$single->ownid;
                $sendSingleLegIncome["touser"]=$single->ownid;
                $sendSingleLegIncome["incometype"]=$single->type;
                $sendSingleLegIncome["level"]=$single->refid;
                $sendSingleLegIncome["amount"]=$amount;
                $sendSingleLegIncome["created_at"]=Carbon::now();
                $sendSingleLegIncome["remark"]= $single->type." income recieved.";
                $sendSingleLegIncome["plan"]=$plan->name;
                DB::table("income")->insert($sendSingleLegIncome);
                
                //reduce one day 
                
                DB::update("update roi set remaining=remaining-1,sent=sent+? where id =?",[$amount,$single->id]);
            }
        }
        }
        
        
    }
    
    public function checkFiveDirect($ownid)
    {
        $record=DB::table("users")->where("sponsarid",$ownid)->where("isactive",1)->count();
        if($record>=5)
            return true;
        else
            return false;
    }
}
