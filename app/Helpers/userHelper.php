<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Exception;

class userHelper
{

 public static function sendMail($from = "info@teamblazesstaking.com", $to = "info@teamblazesstaking.com", $subject, $body)
    {
        try
        {
    //     $email = $to;


    //     $headers = "From: $from\r\n";
    //     $headers .= "Reply-To: $from\r\n";
    //     $headers .= "Content-Type: text/html";
    //     // send email
    //   (mail($email, $subject, $body, $headers));
    //$from = "einixtestings@gmail.com";
      $headers = "From: $from\r\n";
        $headers .= "Reply-To: $from\r\n";
        $headers .= "Content-Type: text/html";
        // send email
        //echo $to.'====>'.$subject.'=>'.$body.'=>'.$headers;
     $send = (mail($to,$subject, $body, $headers));
      //echo "Basic Email Sent. Check your inbox.";
        }
        catch(Exception $e)
        {
            
        }
       
    }
    public static function getNews()
    {
        return DB::Table("news")->get();
    }
    public static function setRewards()
    {

     /* $jdates=DB::select("select * from tempdates order by cast(jdate as date) asc");
     foreach($jdates as $jd)
     {


      $record=DB::table("users")->where("activeon","<=",$jd->jdate)->where("isactive",1)->orderby("activeon","asc")->get();//DB::select("select distinct ownid,id from temprewarduser");
        foreach($record as $rc)
        {
            $checkId=DB::table("users")->where("ownid",$rc->ownid)->first();
            if($checkId->isactive==1)
            {


            $userid=$rc->ownid;
            $selfBusiness=DB::table("plans")->where("id",$checkId->currentplan)->sum("entryamount");
            $achievedLevel=$checkId->reward;
            $joiningDate=$checkId->activeon;

            $nextLevel=DB::table("reward")->where("id",">",$achievedLevel)->orderby("id","asc")->first();
            if(!empty($nextLevel))
            {
                $targetBusiness=$nextLevel->business_count;
            $endDate=$nextLevel->time;


            $from = Carbon::createFromFormat('Y-m-d H:s:i',$checkId->rewarddate);
            $to =$jd->jdate;// Carbon::now()->format('Y-m-d H:s:i');

            $diff_in_days = $from->diffInDays($to);


                 if($diff_in_days>$endDate)
                   {
                       //insert skip entry and update reward
                       $insertReward["ownid"]=$userid;
                       $insertReward["reward_id"]=$nextLevel->id;
                       $insertReward["remarks"]="Level skipped due to excess days that are $diff_in_days from $from and $to for  ".$nextLevel->business;
                       $insertReward["created_at"]=$to;
                       $insertReward["status"]=0;
                       DB::table("rewardachievers")->insert($insertReward);
                       DB::table("users")->where("ownid",$userid)->update(["reward"=>$nextLevel->id,"rewarddate"=>$to]);
                       DB::table("tempdates")->where("jdate",$jd->jdate)->delete();


                   }
                   else
                   {
                         $result=array();
            $getDirect=DB::select("SELECT a.name,a.ownid,a.activeon,a.isactive,b.entryamount as selfBusines from users as a join plans as b on a.currentplan =b.id and a.sponsarid='$userid' ");//DB::Table("users")->select(["name","ownid","activeon","isactive","currentplan"])->where(["sponsarid"=>$userid])->get();
            if(count($getDirect)>=2)
            {


                $power["business"]=0;
                $power["userid"]=0;
                $totalBusiness=0;
                $directBusiness=0;

                foreach($getDirect as $user)
                {
                    if($user->isactive==1)
                    {
                        $directBusiness+=$user->selfBusines;
                    }

                    $business=DB::select("select sum(c.entryamount) as amount from levelmembers as a join users as b on a.child=b.ownid and b.isactive=1 join plans as c on b.currentplan=c.id where a.ownid='$user->ownid' and cast(b.activeon as Date)<=?",[$to]);
                     //$business=DB::select("select sum(a.entryamount) as amount from plans as a join users as b on b.currentplan=a.id join levelmembers as c on c.ownid=b.ownid where c.ownid=?  and cast(b.activeon as Date)<=?",[$user->ownid,$user->ownid,$userid,$to]);
                    if(count($business)>0)
                    {
                        $amount=$business[0]->amount;
                        $totalBusiness+=$amount;

                        if($amount>$power["business"])
                        {
                            $power["business"]=$amount;
                            $power["userid"]=$user->ownid;
                        }

                    }

                }


                $result["powerBusiness"]= $power["business"];
                $result["powerId"]=$power["userid"];
                $result["pendingBusiness"]=$totalBusiness-$power["business"];


                $fourtyReward=$targetBusiness*0.4;
                $sixstyReward=$targetBusiness*0.6;

                if( $result["powerBusiness"]>$fourtyReward)
                {
                    $result["powerBusiness"]=$fourtyReward;
                }

                if($result["pendingBusiness"]>$sixstyReward)
                {
                    $result["pendingBusiness"]=$sixstyReward;
                }


               //$sixsty= $result["powerBusiness"]*0.4;
              // $fourty= $result["pendingBusiness"]*0.6;
               $totalBusiness=round($result["powerBusiness"]+$result["pendingBusiness"]);



               if($totalBusiness>=$targetBusiness || $directBusiness>=$targetBusiness)
               {

                    //check laready achieved or not
                       $ct=DB::table("users")->where("ownid",$userid)->where("reward",$nextLevel->id)->count();
                       if($ct<=0)
                       {
                                 //update reward in user table and send entry in reward
                               $insertReward["ownid"]=$userid;
                               $insertReward["reward_id"]=$nextLevel->id;
                               $insertReward["remarks"]="Level achieved due to  days that are $diff_in_days from $from and $to for  ".$nextLevel->business." direct business is ".$directBusiness." power business is  ".$result["powerBusiness"]." and power id is ".$result["powerId"]." sixsty is $sixstyReward nand fourty is $fourtyReward total is $totalBusiness";
                               $insertReward["created_at"]=$to;
                               $insertReward["status"]=1;
                               DB::table("rewardachievers")->insert($insertReward);
                               DB::table("users")->where("ownid",$userid)->update(["reward"=>$nextLevel->id,"rewarddate"=>$to]);
                       }
               }







            }
            else
            {
                echo "directNotActive".$userid;
            }
               // DB::table("temprewarduser")->where("id",$rc->id)->delete();

            }
                   }





        }
        }
       DB::table("tempdates")->where("jdate",$jd->jdate)->delete();
     } */
    }

    public static function getClosings()
    {
        return DB::table("closingapplied")->get();
    }
public static function checkPackage($ownid)
{
    return DB::table('tradingpackage')->where("ownid",$ownid)->get();
}
public static function checkPackageSale($ownid)
{
    return DB::table('salepackage')->where("ownid",$ownid)->get();
}

public static function getEpinTransferHistory($fromuser)
{
    return DB::select("select a.*,b.name from epinrecord as a join users as b on a.touser=b.ownid where a.fromuser =?",[$fromuser]);
}
public static function getEpinRecievedHistory($touser)
{
    return DB::select("select a.*,b.name from epinrecord as a join users as b on a.fromuser=b.ownid where a.touser =?",[$touser]);
}
    public static function getAllUser()
    {
        return DB::table("users")->select(["id","ownid","sponsarid","parentid","name","mobile"])->get();
    }
     public static function getAllActiveUser()
    {
        return DB::table("users")->select(["id","ownid","sponsarid","parentid","name","mobile"])->where("isactive",1)->get();
    }
     public static function getRepruchase()
    {
        return DB::select("select a.*,b.name,b.ownid from repurchase as a join users as b on a.userid=b.id");
    }

    public static function getAchievers()
    {
        return DB::table('achievers')->get();
    }
    public static function getGallery()
    {
        return DB::table('gallery')->get();
    }
    public static function sendClubIncome($from)
    {
         $getWallet=DB::table("wallet")->where('status',0)->sum('amount');
                if($getWallet!=0)
                {
                    DB::table('wallet')->update(['status'=>1]);
                    $getAll=DB::table('users')->where('isclubmember',1)->get();
                    if(count($getAll)>0)
                    {
                                $divide=count($getAll);
                                $amount=$getWallet/$divide;
                                foreach($getAll as $user)
                                {
                                    $clubIncome['fromuser']=$from;
                                    $clubIncome['touser']=$user->ownid;
                                    $clubIncome['incometype']="Club";
                                    $clubIncome['amount']=round($amount,2);
                                    $clubIncome['created_at']=Carbon::now();
                                    $clubIncome['Plan']="Club Income";
                                    DB::table('income')->insert($clubIncome);
                                     $upd=DB::update("update users set clubincome=clubincome+? where ownid=?",[round($amount,2),$user->ownid]);
                                }
                    }
                    else
                    {

                    }
                }
    }


    public static function getIncome($type,$ownid="All",$from="none",$to="none",$sum=false)
    {
        if($type=="Ledger Summary")
        {
            $operator="!=";
        }
        else
        {
            $operator="=";
        }

        if($ownid=="All")
        {
            if($sum)
            {
                if($from=="none" && $to=="none")
                return DB::table("income","a")
                ->select('a.id','a.fromuser','a.level','a.incometype','a.remark','a.created_at','a.plan','a.amount','b.name','a.touser')
                ->join("users as b",'a.fromuser','=','b.ownid')
                ->where('a.incometype',"$operator",$type)->sum("a.amount");
                else
                return DB::table("income","a")
                ->select('a.id','a.fromuser','a.level','a.incometype','a.remark','a.created_at','a.plan','a.amount','b.name','a.touser','a.touser')
                ->join("users as b",'a.fromuser','=','b.ownid')
                ->where('a.incometype',"$operator",$type)->whereBetween('a.created_at',[$from,$to])->sum("a.amount");
            }
            else
            {
                if($from=="none" && $to=="none")
                return  DB::select("select b.ownid,b.name,sum(a.amount) as amount from income as a join users as b on a.touser=b.ownid where a.incometype$operator? group by b.ownid,b.name ",[$type]);
                else
                return  DB::select("select b.ownid,b.name,sum(a.amount) as amount from income as a join users as b on a.touser=b.ownid where a.incometype$operator? and a.created_at>=? and a.created_at<=? group by b.ownid,b.name ",[$type,$from,$to]);

            }
            }

        else
        {
            if($sum)
            {
                if($from=="none" && $to=="none")
                return DB::table("income","a")
                ->select('a.id','a.fromuser','a.incometype','a.remark','a.level','a.created_at','a.plan','a.amount','b.name','a.touser')
                ->join("users as b",'a.fromuser','=','b.ownid')
                ->where('a.incometype',"$operator",$type)->where('a.touser',$ownid)->sum("a.amount");
                else
                return DB::table("income","a")
                ->select('a.id','a.fromuser','a.incometype','a.remark','a.level','a.created_at','a.plan','a.amount','b.name','a.touser')
                ->join("users as b",'a.fromuser','=','b.ownid')
                ->where('a.incometype',"$operator",$type)->where('a.touser',$ownid)->whereBetween('a.created_at',[$from,$to])->sum("a.amount");
            }
            else
            {
                if($from=="none" && $to=="none")
                return DB::table("income","a")
                ->select('a.id','a.fromuser','a.incometype','a.remark','a.level','a.created_at','a.plan','a.amount','b.name','a.touser')
                ->leftjoin("users as b",'a.fromuser','=','b.ownid')
                ->where('a.incometype',"$operator",$type)->where('a.touser',$ownid)->get();
                else
                return DB::table("income","a")
                ->select('a.id','a.fromuser','a.incometype','a.remark','a.level','a.created_at','a.plan','a.amount',DB::raw("ifnull(b.name,'Admin'"),'a.touser')
                ->leftjoin("users as b",'a.fromuser','=','b.ownid')
                ->where('a.incometype',"$operator",$type)->where('a.touser',$ownid)->whereBetween('a.created_at',[$from,$to])->get();
            }

        }
    }


static function getUserById($id)
{
    return DB::table('users')->select(['name','ownid'])->find($id);
}
    public static function getUserDetail($ownid)
    {
        try {
            $res = DB::table('users')->where("ownid", $ownid)->select(['ownid','name', 'mobile','isactive'])->get()[0];
            return $res;
        } catch (Exception $e) {
            $object['name'] = "Root";
            $object['mobile'] = "";
            return $object;
        }
    }
    public static function getWithdraws($type = "All",$from="none",$to="none",$sum=false)
    {
        if($sum)
        {
            if($from=="none" && $to=="none")
            {
                if($type=="All")
                $res = DB::table('income')->where('amount','<', 0)->sum("amount");
                else
                $res = DB::table('income')->where("touser",$type)->where('amount','<', 0)->sum("amount");

            }
            else
            {
                 if($type=="All")
                 $res = DB::table('income')->where('amount','<', 0)->where('created_at','>=',$from)->where('created_at','<=',$to)->orderBy("id")->sum("amount");
                else
                $res = DB::table('income')->where('amount','<', 0)->where("touser",$type)->where('created_at','>=',$from)->where('created_at','<=',$to)->orderBy("id")->sum("amount");

            }
        }
        else
        {
            if($from=="none" && $to=="none")
            {
                if($type=="All")
                $res = DB::table('income')->where('amount','<', 0)->get();
                else
                $res = DB::table('income')->where("touser",$type)->where('amount','<', 0)->get();

            }
            else
            {
                 if($type=="All")
                 $res = DB::table('income')->where('amount','<', 0)->where('created_at','>=',$from)->where('created_at','<=',$to)->orderBy("id")->get();
                else
                $res = DB::table('income')->where('amount','<', 0)->where("touser",$type)->where('created_at','>=',$from)->where('created_at','<=',$to)->orderBy("id")->get();

            }
        }

        return $res;
    }

    static function getPlanDetails($planid)
    {
        return DB::table('plans')->find($planid);
    }

    static function getPlans()
    {
        return DB::table('plans')->get();
    }

    static function sendIncome($ownid, $fromid,$remark)
    {

            $user = DB::table('users')->where('ownid', $ownid)->get();
            $planDetails = userHelper::getPlanDetails($user[0]->currentplan);
            if (($user[0]->directincome + $user[0]->levelincome + $user[0]->clubincome) >= $planDetails->mylimit) {
                $arr['ownid']   = $ownid;
                $arr['fromuser']   = $fromid;
                $arr['remark']   = 'Plan limit reached ';
                $arr['type']   = 'Plan limit reached ' . $planDetails->entryamount . " plan name is :" . $planDetails->name;
                //DB::table('missincome')->insert($arr);
                return true;
            } else {
                $fromdata = DB::table('users')->where('ownid', $fromid)->get();
                if ($planDetails->id >= $fromdata[0]->currentplan) {
                    return true;
                } else {
                    $crPlanData=userHelper::getPlanDetails($fromdata[0]->currentplan);
                    $arr['ownid']   = $ownid;
                    $arr['fromuser']   = $fromid;
                    $arr['remark']   = "Sponsar user plan is less then from user plan amount is direct ".$crPlanData->directincome." or level ".$crPlanData->levelincome;
                    $arr['type']   = 'Sponsar is ' . $ownid . ' sponsar plan is ' . $user[0]->currentplan . ' from user plan is ' . $fromdata[0]->currentplan;
                    DB::table('missincome')->insert($arr);
                    return true;
                }
            }

    }

    public static function insertUpgradeMember($epin, $ownid, $sponsarid, $table, $plan)
    {
        $sponsarid = strtoupper($sponsarid);
        //handle further process
        userHelper::getmin($ownid,'UD0000000', $sponsarid, $table,$epin,$plan->id);
    }
    public static function getmin($ownid, $checkid, $sponsarid, $table,$epin,$planid)
    {
        $getFullChecker = DB::select('select * from '.$table.' where ownid= ?', [$checkid]);
        if ($getFullChecker[0]->level == 0) {
            if (userHelper::insert($ownid, $checkid, $sponsarid, $getFullChecker,$table,$epin,$planid)) {
               echo "upgrade successfull";
            } else {
                echo "Unable to upgrade";
            }
        } else {
            //sabhi ke level nikalo
            $getFullChilds = DB::select('select * from '.$table.' where parentid = ?', [$checkid]);
            $i = 0;
            $minlevel = $getFullChilds[0]->level;
            $choosenId = $getFullChilds[0]->ownid;
            while ($i < count($getFullChilds)) {
                if ($getFullChilds[$i]->level < $minlevel) {
                    $minlevel = $getFullChilds[$i]->level;
                    $choosenId = $getFullChilds[$i]->ownid;
                }
                $i++;
            }
            userHelper::getmin($ownid, $choosenId, $sponsarid, $table,$epin,$planid);
        }
    }
    static function insert($ownid, $parentid, $sponsarid, $getFullChecker, $table, $epin, $planid)
    {
        if ($getFullChecker[0]->first == '') {
            $place = "first";
        } elseif ($getFullChecker[0]->second == '') {
            $place = "second";
        } elseif ($getFullChecker[0]->third == '') {
            $place = "third";
        } else {
            return false;
        }

        //insert into db
        $usrInsert['epin'] = $epin;
        $usrInsert['ownid'] = $ownid;
        $usrInsert['sponsarid'] = strtoupper($sponsarid);
        $usrInsert['parentid'] = strtoupper($parentid);
        $usrInsert['created_at'] = Carbon::now();
        $result = DB::table($table)->insert($usrInsert);
        if ($result) {
            //plan id jisme aya uski h
            $planDetails = userHelper::getPlanDetails($planid);
            //update the parent
            DB::update('update '.$table.' set  ' . $place . ' = ? where ownid = ?', [$ownid, $parentid]);

            //send direct income of the sponsar entry send to parent because in case of upgrades the frst level person is my direct
            if (userHelper::sendIncome($parentid, $ownid,'direct income'.$planDetails->directincome)) {
                $sponsarData = DB::table('users')->where('ownid', $sponsarid)->get();
                $sponsarPlan = userHelper::getPlanDetails($sponsarData[0]->currentplan);
                DB::update('update users set directincome=directincome+? where ownid=?', [$planDetails->directincome, $sponsarid]);
                $directIncome['fromuser'] = $ownid;
                $directIncome['touser'] = $parentid;
                $directIncome['amount'] = $planDetails->directincome;
                $directIncome['incometype'] = "Direct";
                $directIncome['plan'] = $planDetails->name;
                $directIncome['created_at'] = Carbon::now();
                DB::table('income')->insert($directIncome);
            }
            //send direct income end

            //use do while loop to set level , send level income and set level members
            $iterate = $parentid;
            $k = 1;
            do {
                if ($iterate != '') {
                    $result = DB::select('select * from ' . $table . ' where  ownid= ?', [$iterate]);
                    if (count($result) > 0) {
                        /*Set Level Start  */
                        $first = $result[0]->first;
                        $second = $result[0]->second;
                        $third = $result[0]->third;
                        if ($first != '' && $second != '' && $third != '') {
                            $getChilds = DB::select('select * from ' . $table . ' where parentid = ?', [$iterate]);
                            $levelSet = $getChilds[0]->level;
                            $j = 0;
                            while ($j < count($getChilds)) {
                                if ($getChilds[$j]->level < $levelSet) {
                                    $levelSet = $getChilds[$j]->level;
                                }
                                $j++;
                            }
                            //set level
                            if ($levelSet == 0) {
                                DB::update('update ' . $table . ' set level =1 where ownid = ?', [$iterate]);
                            } else
                                DB::update('update ' . $table . ' set level =?+1 where ownid = ?', [$levelSet, $iterate]);
                        } else {
                            DB::update('update ' . $table . ' set level =0 where ownid = ?', [$iterate]);
                        }
                        /*Set Level End  */
                        /*Send level income start  */
                        if ($k <= 5) {
                            if (userHelper::sendIncome($iterate, $ownid,'level income'.$planDetails->levelincome)) {
                                //$iteratePlan = userHelper::getPlanDetails($result[0]->currentplan);
                                $levelIncome['fromuser'] = $ownid;
                                $levelIncome['touser'] = $iterate;
                                $levelIncome['amount'] = $planDetails->levelincome; //fix for silver;
                                $levelIncome['incometype'] = "Level";
                                $levelIncome['plan'] = $planDetails->name;
                                $levelIncome['level'] = $k;
                                $levelIncome['created_at'] = Carbon::now();
                                DB::table('income')->insert($levelIncome);
                                DB::update('update users set levelincome=levelincome+? where ownid=?', [$planDetails->levelincome, $iterate]);
                            }
                        }
                        /*Send level income end  */
                        /*Set Level Members Start */
                        DB::insert('insert into levelmembers (level,ownid,child,created_at,plan) values (?,?,?,?,?)', [$k, $iterate, $ownid, Carbon::now(), $planDetails->id]);
                        /*Set Level Members End*/
                        try {
                            $iterate = $result[0]->parentid;
                            //set level member and teambusiness for the parent
                        } catch (Exception $ex) {
                            return false;
                        }
                        $k++;
                    }
                }
            } while ($result);
            return true;
        } else {
            return false;
        }
    }

   public static function get_zoom_meeting($id)
   {
       return DB::table('zoom_meeting')->find($id);
   }
   public static function get_videos()
   {
       return DB::table('video')->get();
   }
   public static function get_zoommeetingall()
   {
       return DB::table('zoom_meeting')->get();
   }
   public static function get_all_slider()
   {
       return DB::table('slider')->get();
   }
   public static function getWithdraw($ownid,$type="User")
   {
       if($type=="User")
       $arr["record"]= DB::Table("withdrawrequests")->where("ownid",$ownid)->orderBy('id', 'DESC')->get();
       else
       $arr["record"]= DB::Table("withdrawrequests")->where("status",0)->orderBy('id', 'DESC')->get();
       
       
       $arr["total"]= DB::Table("withdrawrequests")->where("ownid",$ownid)->where("status","!=",2)->sum('amount');
       return $arr;
   }
   public static function getDailyROI($ownid)
   {
       return DB::select("SELECT name,case when sent<amountmax then cast(b.roi/22 as decimal(11,2)) else 0  	end as daily FROM `roi` as a join plans as b on a.planid=b.id where a.ownid=?",[$ownid]);
   }
   public static function getPlatforms()
   {
       return DB::table("achievers")->get();
   }
   public static function getFirm()
   {
       return DB::Table("admins")->find(1);
   }

}
