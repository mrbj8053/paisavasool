<?php

namespace App\Http\Controllers;

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

class ajaxController extends Controller
{

    public function test()
    {
        $day = date('D');
        dd($day);
       
        //  //send roi singole leg income  and level income
        
        // $getAllSingle=DB::table("roi")->where('amountmax','>',0)->get();
        // foreach($getAllSingle as $single)
        // {
        //     if($single->remaining>0 && $single->sent<$single->amountmax)
        //     {
        //         $plan=userHelper::getPlanDetails($single->planid);
        //         $amount=round((($plan->roi/22)/100)*$plan->entryamount,2);
           
        //         //now send finally single leg income income 
        //         $sendSingleLegIncome["fromuser"]=$single->ownid;
        //         $sendSingleLegIncome["touser"]=$single->ownid;
        //         $sendSingleLegIncome["incometype"]=$single->type;
        //         $sendSingleLegIncome["level"]=$single->refid;
        //         $sendSingleLegIncome["amount"]=$amount;
        //         $sendSingleLegIncome["created_at"]=Carbon::now();
        //         $sendSingleLegIncome["remark"]= $single->type." income recieved.";
        //         $sendSingleLegIncome["plan"]=$plan->name;
        //         DB::table("income")->insert($sendSingleLegIncome);
                
        //         //reduce one day 
                
        //         DB::update("update roi set remaining=remaining-1,sent=sent+? where id =?",[$amount,$single->id]);
        //     }
        // }
    
        
    }
   

    public function getSponsar(Request $request)
    {
        
        $result = DB::select('select name from users where ownid=? and currentplan=?', [$request->sponsarid,$request->plan]);
        if (count($result) > 0) {
            return $result[0]->name;
        } else
            return false;
    }
    function register(Request $request)
    {
       
        $this->validate($request, [
            'inviteCode' => 'required|max:9|min:9|exists:users,ownid',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|min:10|max:10|unique:users,mobile',
            'password' => 'required|min:6|max:50',
            'txnPassword'=>'required|min:6|max:50'
        ]);
    
    


        $proceed = true;
        $result = DB::select('select * from users where ownid=? ', [$request->inviteCode]);
        if (count($result) <= 0) {
         $proceed=false;
         Session::flash('erroUser', "Invalid Sponsar Id");
        }

        //check mobile current limit is 1 only
        $checkMobile = User::where('mobile', $request->Mobile)->get();
        if (false/*$checkMobile->count() > 0*/) {
            $proceed = false;
            Session::flash('erroUser', "Mobile number already used.");
        }
        if ($proceed) {
            $this->proceedRegister($request);
        } else
            return redirect()->back()->withInput(['txnPassword'=>$request->txnPassword,'inviteCode' => $request->inviteCode, 'Epin' => $request->Epin, 'name' => $request->name, 'Email' => $request->Email, 'mobile' => $request->mobile, 'password' => $request->password, 'DOB' => $request->DOB]);
    }

    function activateUser($epin,$type="self",$fromadmin=false)
    {
        if($fromadmin)
     {   $errorBase="msgAdmin";
        $msgBase= "msgAdmin";

     }
        else
        {
         $errorBase="erroUser";
        $msgBase= "msgUser";

        }
        //
        try {

            if(Crypt::decrypt($epin)=="random")
            {
                if(!$fromadmin)
                $userEpin=DB::select('select a.*,b.epin,b.applied_at from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=0',[Auth::user()->ownid,Auth::user()->ownid]);
                else
                 $userEpin=DB::select('select a.*,b.epin,b.applied_at from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=0',["TS0000000","TS0000000"]);

                if(count($userEpin)>0)
                {
                    $epin=$userEpin[0]->epin;
                }
                else
                {
                    Session::flash($errorBase, "No Epins availiable to activate the user");
                    return redirect()->back();
                }
            }





            if($type=="self")
            $userid = Auth::user()->id;
            else
            $userid=Crypt::decrypt($type);
            $user = DB::table("users")->find($userid);
            if ($user) {
                if ($user->isactive == 0) {

                    $epinDetails = DB::table('epin')->where("epin", $epin)->where("status", 0)->get();
                    if (count($epinDetails) == 0) {
                        Session::flash($errorBase, "Invalid Epin");
                        return redirect()->back();
                    }
                    //change Epin status
                    $epinStatus["status"] = 1;
                    $epinStatus["applied_at"] = Carbon::now();
                    DB::table('epin')->where("id", $epinDetails[0]->id)->update($epinStatus);

                    //now activate the user

                    //get invoice number
                    $inv=DB::table("users")->where("isactive",1)->orderBy('invoice', 'desc')->first()->invoice+1;




                    $currentPlan = $epinDetails[0]->planid;
                    $arr['isactive'] = 1;
                    $arr['activeon'] = Carbon::now();
                    $arr['currentplan'] = $epinDetails[0]->planid;
                    $arr["invoice"]=$inv;
                    $upd = DB::table('users')->where("id", $user->id)->update($arr);











                    if ($upd) {
                        $sponsarid = $user->sponsarid;
                        $ownid = $user->ownid;
                        $planDetails = userHelper::getPlanDetails($currentPlan);
                        $parentid = $user->parentid;
                        //send royalty members when 55 direct completed in 15 bdays

                        $sponsarData = DB::table('users')->where('ownid', $sponsarid)->get();
                        $get = DB::table("users")->where('sponsarid', $sponsarid)->where('isactive', 1)->where("activeon",'>=',Carbon::now()->subDays(15))->get();
                        if (count($get) >= 55 && $sponsarData[0]->isroyalmember == 0) {
                            DB::table("users")->where('ownid', $sponsarid)->update(['isroyalmember' => 1]);

                            $royalMem["ownid"] = $sponsarid;
                            $royalMem["created_at"] = Carbon::now();
                            $royalMem["refid"] = $user->ownid;
                            DB::table('royalmembers')->insert($royalMem);
                        }


                        //send direct income of the sponsar entry
                        $sponsarData = DB::table('users')->where('ownid', $sponsarid)->get();

                        if (count($sponsarData)>0 && $sponsarData[0]->isactive == 1) {




                                 DB::update('update users set directincome=directincome+? where ownid=?', [$planDetails->directincome, $sponsarid]);
                            $directIncome['fromuser'] = $ownid;
                            $directIncome['touser'] = $sponsarid;
                            $directIncome['amount'] = 30;
                            $directIncome['incometype'] = 'Direct';
                            $directIncome['plan'] = $planDetails->name;
                            $directIncome['created_at'] = Carbon::now();
                             $directIncome['remark'] = "Direct Income";
                            DB::table('income')->insert($directIncome);


                        }
                        //send direct income end


                        //send levelincome
                        $iterate = $parentid;
                        $k = 1;
                        do {
                            if ($iterate != '') {
                                $result = DB::select('select * from users where  ownid= ?', [$iterate]);
                                if (count($result) > 0) {
                                    /*Set Level Start  */

                                    /*Send level income start  */
                                    if ($k <= 6) {
                                        $lAmount = 0;
                                        switch ($k) {
                                            case 1:
                                                $lAmount = 30;
                                                break;
                                            case 2:
                                                $lAmount = 10;
                                                break;
                                            case 3:
                                                $lAmount = 5;
                                                break;
                                            case 4:
                                                $lAmount = 2;
                                                break;
                                            case 5:
                                                $lAmount = 2;
                                                break;
                                            case 6:
                                                $lAmount = 1;
                                                break;

                                        }


                                        if ($result[0]->isactive==1 && $lAmount>0) {
                                            $levelIncome['fromuser'] = $ownid;
                                            $levelIncome['touser'] = $iterate;
                                            $levelIncome['incometype'] = "Level";
                                            $levelIncome['amount'] = $lAmount;
                                            $levelIncome['plan'] = $planDetails->name;
                                            $levelIncome['level'] = $k;
                                            $levelIncome['created_at'] = Carbon::now();
                                            DB::table('income')->insert($levelIncome);
                                            DB::update('update users set levelincome=levelincome+? where ownid=?', [$lAmount, $iterate]);
                                        } else {
                                            if($lAmount>0)
                                            {
                                                $arr['ownid']   = $iterate;
                                                $arr['fromuser']   = $ownid;
                                                $arr['remark']   = "Sponsar id is not actiavted and hence Level income " . $lAmount . " skipped for level " .$k;
                                                $arr['type']   = "Sponsar id is not actiavted and hence Level income " . $lAmount . " skipped for level " .$k;
                                                DB::table('missincome')->insert($arr);
                                            }

                                        }
                                    }
                                    else
                                    {
                                        break;
                                    }
                                    /*Send level income end  */

                                    try {
                                        $iterate = $result[0]->parentid;
                                    } catch (Exception $ex) {
                                        break;
                                    }
                                    $k++;
                                }
                            }
                        } while ($result);

                        //now insert the ROI income
                        // $roiIncome["ownid"]=$user->ownid;
                        // $roiIncome["amount"]=10;
                        // $roiIncome["remaining"]=30;
                        // $roiIncome["remark"]="Roi income for 30 Day";
                        // $roiIncome["refid"]=$user->ownid;
                        // DB::table('roi')->insert($roiIncome);

                        Session::flash($msgBase, "Id Activated Successfully");
                        return redirect()->back();
                    } else {
                        Session::flash('errorUser', "Invalid user");
                        return redirect()->back();
                    }
                } else {
                    Session::flash($errorBase, "Account already active");
                    return redirect()->back();
                }
            } else {
                Session::flash($errorBase, "Invalid user");
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e);
            Session::flash($errorBase, "Invalid user");
            return redirect()->back();
        }
    }
    function proceedRegister(Request $request)
    {
         //set epin status first to used so that another cannot use it in the processing time
        // DB::table('epin')->where('epin', $request->Epin)->update(['status' => 1, 'applied_at' => Carbon::now()]);
        //generate 7 digit random user id and verify against db
        $ownid = "TB" . mt_rand(1000000, 9999999);
        $chkOwnid = DB::select('select * from users where ownid = ?', [$ownid]);
        while (count($chkOwnid) > 0) {
            $ownid = "TB" . mt_rand(1000000, 9999999);
            $chkOwnid = DB::select('select * from users where ownid = ?', [$ownid]);
        }
        //handle further process

        if ($this->insert($ownid, $request->inviteCode,$request->inviteCode, $request)) {
            $arr['user'] = DB::table('users')->where('ownid', $ownid)->get()[0];
             $subject="Registered successfully";
        $body='<h1>Registered successfully</h1>
        <p>Congratulations your account on Team Blazes Staking is created successfully,find your registration details below</p>
        <p><strong>User ID :</strong>'.$ownid.' </p>
        <p><strong>Mobile :</strong>'.$request->mobile.' </p>
        <p><strong>Password :</strong>'.$request->password.' </p>
        <p><strong>Transaction Password :</strong>'.$request->txnPassword.' </p>
        <p><strong>Invite Code :</strong>'.strtoupper($request->inviteCode).' </p>
        <img src="https://teamblazesstaking.com/logo.png" />';
        userHelper::sendMail("info@teamblazesstaking.com",$request->email,$subject,$body);
            echo '<script>document.location.href="' . route('register.success', ['id' => $ownid]) . '";</script>';
        } else {
            echo "Unable to register please try after some time ";
        }
       

        
    }
    function getmin($ownid, $checkid, $sponsarid, $getUser)
    {
        
       
        $getFullChecker = DB::select('select * from users where ownid= ?', [$checkid]);
        if ($getFullChecker[0]->level == 0) {
            if ($this->insert($ownid, $checkid, $sponsarid, $getFullChecker, $getUser)) {
                $arr['user'] = DB::table('users')->where('ownid', $ownid)->get()[0];
                echo '<script>document.location.href="' . route('register.success', ['id' => $ownid]) . '";</script>';
            } else {
                echo "Unable to register please try after some time ";
            }
        } else {
            //sabhi ke level nikalo
            $getFullChilds = DB::select('select * from users where parentid = ?', [$checkid]);
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
            $this->getmin($ownid, $choosenId, $sponsarid, $getUser);
        }
    }

    function insert($ownid, $parentid, $sponsarid, $getUser)
    { 
        
       
        //insert into db
        $insqry = new User();
        //$insqry->name = $getUser->name;
        $insqry->email = $getUser->email;
        $insqry->password = Hash::make($getUser->password);
        $insqry->ownid = $ownid;
        $insqry->sponsarid = strtoupper($getUser->inviteCode);
        $insqry->parentid = strtoupper($parentid);
        $insqry->mobile = $getUser->mobile;
        $insqry->epin = ' ';
        $insqry->isactive=0;
        $insqry->currentplan=0;
        $insqry->txnpassword=Crypt::encrypt($getUser->txnPassword);
        $insqry->passwordcrypt = Crypt::encrypt($getUser->password);
        
        $result = $insqry->save();
        if ($result) {
           


            //insert into company wallet
            // DB::table('wallet')->insert(['ownid' => $ownid, 'plan' => $planDetails->name, 'amount' => $planDetails->clubincome, 'created_at' => Carbon::now()]);

            //use do while loop to set level , send level income and set level members
            $iterate = $parentid;
            $k = 1;
            do {
                if ($iterate != '') {
                    $result = DB::select('select * from users where  ownid= ?', [$iterate]);
                    if (count($result) > 0) {
                       
                        /*Set Level Members Start */
                        DB::insert('insert into levelmembers (level,ownid,child,created_at,plan) values (?,?,?,?,?)', [$k, $iterate, $ownid, Carbon::now(),0]);
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
    //register success
    function registerSuccess($ownid)
    {

        $arr['user'] = DB::table('users')->where('ownid', $ownid)->get()[0];
        return view('registerSuccess', $arr);
    }
    
    function forgotPassword(Request $request)
    {
        
        
        $this->validate($request,[
            'userid'=>"required|string"
            ]);
            
            $user=DB::Table("users")->where("ownid",$request->userid)->first();
            if($user)
            {
                
                 try
            {
                $api_key = '260ED8FCD0D41B';
                $contacts = $user->mobile;
                $from = 'VSNMRT';
                $template_id= '1207162592001673224';
                $pass=Crypt::decrypt($user->passwordcrypt);
                $sms_text = urlencode("Welcome  dear, $user->name your User ID is $user->ownid and Password is $pass for login. Regards Vision Market Thanks. ");
                
                $api_url = "http://sms.erbansal.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id;
                
                //Submit to server
                
               // $response = file_get_contents( $api_url);
                Session::flash('msgUser', "Credentials sent on mobile successfully.");
                
            }
            catch(Exception $e)
            {
                Session::flash('errorUser', "Unable to reach server please try after some time.");
            }
            
                 
            }
            else
            {
                 Session::flash('errorUser', "Invalid userid.");
            }
            return redirect()->back();
    }
    
}
