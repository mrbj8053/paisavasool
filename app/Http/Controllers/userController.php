<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Catch_;
use userHelper;
use PDF;
use TCPDF as GlobalTCPDF;

class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    //profile
    function showProfile()
    {
        $arr["netIncome"]=DB::table("income")->where("touser",Auth::user()->ownid)->sum("amount");
        return view('user.editprofile',$arr);
    }
    function updateProfile(Request $request)
    {


        $this->validate($request, [
            'name' => 'required|string',
            'dob' => 'required|date',
            'email' => 'required|email',
            'address' => 'required|string'
        ]);



        $arr['name'] = strtoupper($request->name);
        $arr['dob'] = $request->dob;
        $arr['email'] = $request->email;
        $arr['address'] = $request->address;

        if($request->profile)
        {
            $profile = time() . rand(1000, 9999) . '.' . $request->profile->extension();
            $request->profile->move(public_path('profile'), $profile);
            $arr["profile"]=$profile;
        }

        $upd = DB::table('users')->where('id', Auth::user()->id)->update($arr);
        if ($upd)
            Session::flash('msgUser', 'Profile updated successfully');
        else
            Session::flash('errorUser', "Unable to update your profile");

        return redirect()->back();
    }
    //kyc
    public function updateKyc(Request $request)
    {
        $request->validate([
            'AccountNumber' => 'required|string',
            'Bank' => 'required|string|min:3',
            'IFSC' => 'required|string',
            'Branch' => 'required|string|min:3',
            'KYCMOBILE' => 'required',
            'PanImage' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'AdharFront' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'AdharBack' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'Passbook' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $addon = "";

        if ($request->PanImage) {
            //,panimage=?,adharimage=?,adharbackimage=?,passbookimage=?
            $PanImage = time() . rand(1000, 9999) . '.' . $request->PanImage->extension();
            $request->PanImage->move(public_path('kyc'), $PanImage);
            $addon = $addon . ",panimage='$PanImage'";
        }
        if ($request->AdharFront) {

            $AdharFront = time() . rand(1000, 9999) . '.' . $request->AdharFront->extension();
            $request->AdharFront->move(public_path('kyc'), $AdharFront);
            $addon = $addon . ",adharimage='$AdharFront'";
        }
        if ($request->AdharBack) {
            $AdharBack = time() . rand(1000, 9999) . '.' . $request->AdharBack->extension();
            $request->AdharBack->move(public_path('kyc'), $AdharBack);
            $addon = $addon . ",adharbackimage='$AdharBack'";
        }

        if ($request->Passbook) {
            $Passbook = time() . rand(1000, 9999) . '.' . $request->Passbook->extension();
            $request->Passbook->move(public_path('kyc'), $Passbook);
            $addon = $addon . ",passbookimage='$Passbook'";
        }


        if ($addon != "") {
            $qry = "update users set kycmobile='$request->KYCMOBILE',kycname='$request->KYCNAME',kycrelation='$request->KYCRELATION',kycage='$request->KYCAGE',pannumber='$request->PanNumber',accountnumber='$request->AccountNumber',bank='$request->Bank',ifsc='$request->IFSC',branch='$request->Branch',kyc=1" . $addon . " where id=" . Auth::user()->id;
        } else {
            $qry = "update users set kycmobile='$request->KYCMOBILE',kycname='$request->KYCNAME',kycrelation='$request->KYCRELATION',kycage='$request->KYCAGE',pannumber='$request->PanNumber',accountnumber='$request->AccountNumber',bank='$request->Bank',ifsc='$request->IFSC',branch='$request->Branch',kyc=1 where id=" . Auth::user()->id;
        }
        //old 'update users set pannumber=?,accountnumber=?,bank=?,ifsc=?,branch=?,kyc=1,panimage=?,adharimage=?,adharbackimage=?,passbookimage=? where id=?',[$PanNumber,$AccountNumber,$Bank,$IFSC,$Branch,$PanImage,$AdharFront,$AdharBack,$Passbook,Auth::user()->id]

        $result = DB::update($qry);
        if ($result)
            Session::flash('msgUser', 'Kyc updated successfully');
        else
            Session::flash('errorUser', 'Unable to update kyc');


        return redirect('/kyc/show');
    }

    public function changePassword(Request $request)
    {
        $validate_user = DB::select('select * from users where ownid=?', [Auth::user()->ownid]);
        if ($validate_user && Hash::check($request->OldPassword, $validate_user[0]->password)) {
            if ($request->NewPassword == $request->ConfirmPassword) {

                $hashedPassword = Hash::make($request->NewPassword, [
                    'rounds' => 12,
                ]);
                $change = DB::update('update users set password=?,passwordcrypt=? where ownid=?', [$hashedPassword, Crypt::encrypt($request->NewPassword), Auth::user()->ownid]);
                Session::flash('msgUser', 'Password changed successfully');
            } else {
                Session::flash('errorUser', 'Password and confirm password not matched');
            }
        } else {
            Session::flash('errorUser', 'Incorrect old password');
        }

        return redirect()->back();
    }
    public function changetxnpass(Request $request)
    {
        $validate_user = DB::select('select * from users where ownid=?', [Auth::user()->ownid]);
        if (Crypt::decrypt(Auth::user()->txnpassword)==$request->OldPassword) {
            if ($request->NewPassword == $request->ConfirmPassword) {

               
                $change = DB::update('update users set txnpassword=? where ownid=?', [Crypt::encrypt($request->NewPassword), Auth::user()->ownid]);
                Session::flash('msgUser', 'Transaction assword changed successfully');
            } else {
                Session::flash('errorUser', 'Password and confirm password not matched');
            }
        } else {
            Session::flash('errorUser', 'Incorrect old password');
        }

        return redirect()->back();
    }

    //tree
    public function showTree($id, $name)
    {

        try {
            $ownid = Crypt::decrypt($id);
            $plans = DB::table("plans")->where('id', '<=', Auth::user()->currentplan)->get();
            $parent = DB::table("users")->where('ownid', $ownid)->get();

            $arr['parent'] = $parent[0];
            $arr['plans'] = $plans;
            $arr['current'] = $name;
            $arr['childs']=DB::select("select *,(select ifnull(sum(a.entryamount),0) from plans as a join users as b on a.id=b.currentplan join levelmembers as c on b.ownid=c.child where c.ownid=users.ownid and b.isactive=1) as amount from users where parentid=?",[$parent[0]->ownid]);
          //  $arr['childs'] = DB::table("users")->where('parentid', $parent[0]->ownid)->get();
            return view('user.myTree')->with($arr);
        } catch (Exception $e) {

            $ownid = Auth::user()->ownid;
            $plans = DB::table("plans")->where('id', '<=', Auth::user()->currentplan)->get();
            $planDetails = DB::table('plans')->where('name', $name)->get();
            $parent = DB::table("users")->where('ownid', $ownid)->get();

            $arr['parent'] = $parent[0];
            $arr['plans'] = $plans;
            $arr['current'] = $name;
            $arr['childs']=DB::select("select *,(select ifnull(sum(a.entryamount),0) from plans as a join users as b on a.id=b.currentplan join levelmembers as c on b.ownid=c.child where c.ownid=users.ownid and b.isactive=1) as amount from users where parentid=?",[$parent[0]->ownid]);
            //$arr['childs'] = DB::table("users")->where('parentid', $parent[0]->ownid)->get();
            return view('user.myTree')->with($arr);
        }
    }


    //downline
    public function showDownline()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . '00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr["levelCount"]=DB::select('select count(a.ownid) as count,a.level  from levelmembers as a join users b on a.child=b.ownid where a.level<10 and a.ownid = ? and a.created_at between ? and ? group by a.level', [Auth::user()->ownid, $from, $to]);
            $arr['record'] = DB::select('select b.*,a.level,ifnull(c.entryamount,0) as plan  from levelmembers as a join users b on a.child=b.ownid left join  plans as c  on b.currentplan=c.id where a.level<10 and a.ownid = ? and a.created_at between ? and ?  order by a.level asc', [Auth::user()->ownid, $from, $to]);
        } else {
            $arr['levelCount'] = DB::select('select count(a.ownid) as count,a.level  from levelmembers as a join users b on a.child=b.ownid where a.level<10 and a.ownid = ?  group by a.level', [Auth::user()->ownid]);
            $arr['record'] = DB::select('select b.*,a.level,ifnull(c.entryamount,0) as plan  from levelmembers as a join users b on a.child=b.ownid left join  plans as c  on b.currentplan=c.id where a.ownid = ? and a.level<10  order by a.level asc ', [Auth::user()->ownid]);
        }

        return view("user.downline", $arr);
    }

    //withdraw
    function withdrawDetails($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $arr['record'] = DB::select('select a.incometype,a.touser,b.name,sum(a.amount) as amount from income as a join users as b on a.touser=b.ownid where a.refid=? group by b.name,a.touser,a.incometype', [$decrypted]);
            return view('user.withdrawDetails', $arr);
        } catch (Exception $e) {
            Session::flash("errorAdmin", "Unable to fetch withdraw details");
        }
        return redirect()->back();
    }
    function upgradePlan(Request $request)
    {
        $this->validate($request, [
            'upgradePin' => 'required|string'
        ]);
        $epin = $request->upgradePin;
        $chk = DB::table('epin')->where('epin', $epin)->where('status', 0)->get();
        if (count($chk) > 0) {
            $currentPlan = Auth::user()->currentplan;
            if ($chk[0]->planid - $currentPlan == 1) {
                $totalAmount = Auth::user()->directincome + Auth::user()->levelincome + Auth::user()->clubincome;
                $planDetails = userHelper::getPlanDetails($currentPlan);
                $newPlanDetails = userHelper::getPlanDetails($chk[0]->planid);
                if ($totalAmount >= $planDetails->incomelimit) {
                    /*Change E-Pin Status */
                    DB::table('epin')->where('epin', $epin)->update(['status' => 1]);
                    /*Insert into the wallet  */
                    $wallet['ownid'] = Auth::user()->ownid;
                    $wallet['plan'] = $newPlanDetails->name;
                    $wallet['amount'] = $newPlanDetails->clubincome;
                    $wallet['created_at'] = Carbon::now();
                    DB::table('wallet')->insert($wallet);

                    /* Insert into db for our referance */
                    $ref['ownid'] = Auth::user()->ownid;
                    $ref['previousplan'] = $currentPlan;
                    $ref['newplan'] = $newPlanDetails->id;
                    $ref['epin'] = $epin;
                    $ref['created_at'] = Carbon::now();
                    DB::table('upgraderef')->insert($ref);
                    /* change user status */
                    DB::table('users')->where('id', Auth::user()->id)->update(['currentplan' => $newPlanDetails->id]);
                    /*Upgrade Plan */
                    userHelper::insertUpgradeMember($epin, Auth::user()->ownid, 'UD0000000', $newPlanDetails->tablename, $newPlanDetails);



                    Session::flash('msgUser', "Congratulations your plan was upgraded successfully.");
                } else {
                    Session::flash('errorUser', "You need to achieve current plan income limit to upgrade to the next plan , the limit is " . $planDetails->incomelimit);
                }
            } else {
                Session::flash('errorUser', "Invalid epin unable to upgrade");
            }
        } else {
            Session::flash('errorUser', "Invalid epin unable to upgrade");
        }
        return redirect()->back();
    }

    public function checkFilter()
    {
        if (Session::has('userfrom') && Session::has('userto'))
            return true;
        else
            return false;
    }
    public function clearFilter()
    {
        Session::forget('userfrom');
        Session::forget('userto');
        return redirect()->route('home');
    }
    public function filterApply(Request $request)
    {
        Session::put('userfrom', $request->fromdate);
        Session::put('userto', $request->todate);
        return redirect()->route('home');
    }

    //direct income
    function showUserIncome($type="Ledger Summary")
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = userHelper::getIncome($type, Auth::user()->ownid, $from, $to);
        } else
            $arr['record'] = userHelper::getIncome($type, Auth::user()->ownid);

        $arr['title'] = "Trading Report";//$type;
        return view('user.showIncome', $arr);
    } 
    //trading
    function showUserTrading()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = userHelper::getIncome("ROI", Auth::user()->ownid, $from, $to);
        } else
            $arr['record'] = userHelper::getIncome("ROI", Auth::user()->ownid);

        $arr['title'] = " Income";
        return view('user.showTrade', $arr);
    }

    //withdraw

    function withdrawPaid()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = DB::table("withdrawrequests")->where("ownid",Auth::user()->ownid)->where("created_at",'>=',$from)->where("created_at","<=",$to)->get();
        } else
                       $arr['record'] = DB::table("withdrawrequests")->where("ownid",Auth::user()->ownid)->get();

              $total=Db::table("income")->where("touser",Auth::user()->ownid)->sum("amount")-Db::table("withdrawrequests")->where("ownid",Auth::user()->ownid)->sum("amount");
              $arr["total"]=$total;
        return view('user.withdrawPaid', $arr);
    }

    function withdrawPending()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = userHelper::getWithdraws(Auth::user()->ownid, 0, $from, $to);
        } else
            $arr['record'] = userHelper::getWithdraws(Auth::user()->ownid, 0);
        return view('user.withdrawPending', $arr);
    }

    //epin request
    function showEpinRequest()
    {
        $arr['plans'] = DB::table('plans')->get();
        $arr['epins'] = DB::table('epinrequest')->where('fuserid', Auth::user()->id)->get();
        $arr['with'] = DB::table('withdrawfinal')->where('ownid', Auth::user()->ownid)->sum('amount');
        return view('user.epinRequest', $arr);
    }
    function applyEpinRequest(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|numeric',
            'package' => 'required|string'
        ]);
        try {
            $decrypted = Crypt::decrypt($request->package);
            $plan = userHelper::getPlanDetails($decrypted);
            $withNet = DB::table('withdrawfinal')->where('ownid', Auth::user()->ownid)->sum('net');
            $withAmount = DB::table('withdrawfinal')->where('ownid', Auth::user()->ownid)->sum('amount');

            if ($withNet >= $plan->entryamount * $request->number) {

                $amt = $plan->entryamount * $request->number;
                $wt['ownid'] = Auth::user()->ownid;
                $wt['amount'] = $amt * -1;
                $wt['tds'] = $amt * 0.0375;
                $wt['admin'] = $amt * 0.05;
                $wt['net'] = ($amt - ($amt * 0.0375) - ($amt * 0.05)) * -1;
                $wt['remark'] = "Epin Request";
                $wt['created_at'] = Carbon::now();
                $wt['status'] = 0;
                $wt['type'] = "e";
                $wt['insertby'] = "admin";
                $insertId = DB::table('withdrawfinal')->insertGetId($wt);

                $arr['fuserid'] = Auth::user()->id;
                $arr['number'] = $request->number;
                $arr['planid'] = $decrypted;
                $arr['amount'] = $plan->entryamount * $request->number;
                $arr['created_at'] = Carbon::now();
                $arr['refid'] = $insertId;
                if (DB::table('epinrequest')->insert($arr))
                    Session::flash('msgUser', "E-Pin Request applied successfully");
                else
                    Session::flash('errorUser', "Unable to apply request please try after some time");
            } else {
                Session::flash('errorUser', "Balance not availiable");
            }
        } catch (Exception $e) {
            dd($e);
            Session::flash('errorUser', "Unable to apply request please try after some time");
        }
        return redirect()->back();
    }
    function alldirects()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = DB::table("users")->where("sponsarid", Auth::user()->ownid)->whereBetween("created_at", [$from, $to])->get();
        } else
            $arr["record"] = DB::table("users")->where("sponsarid", Auth::user()->ownid)->get();

        return view('user.alldirects', $arr);
    }
    function activedirects()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = DB::table("users")->where("sponsarid", Auth::user()->ownid)->where("isactive", 1)->whereBetween("activeon", [$from, $to])->get();
        } else
            $arr["record"] = DB::table("users")->where("sponsarid", Auth::user()->ownid)->where("isactive", 1)->get();

        return view('user.activedirect', $arr);
    }

    function inactivedirects()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = DB::table("users")->where("sponsarid", Auth::user()->ownid)->where("isactive", 0)->whereBetween("created_at", [$from, $to])->get();
        } else
            $arr["record"] = DB::table("users")->where("sponsarid", Auth::user()->ownid)->where("isactive", 0)->get();


        $arr["epins"]=count(DB::select('select a.*,b.epin,b.applied_at from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=0',[Auth::user()->ownid,Auth::user()->ownid]));
        return view('user.inactivedirect', $arr);
    }
    function checkleadership()
    {
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['record'] = DB::select(
                "select a.ownid,a.name,a.sponsarid ,ifnull(count(b.name),0) as total from users as a
              left join users as b on a.ownid=b.sponsarid where a.sponsarid=? and created_at>=? and created_at<=? group by  a.ownid,a.name,a.sponsarid",
                [Auth::user()->ownid, $from, $to]
            );
        } else
            $arr["record"] = DB::select(
                "select a.ownid,a.name,a.sponsarid,ifnull(count(b.name),0) as total from users as a
        left join users as b on a.ownid=b.sponsarid where a.sponsarid=?  group by  a.ownid,a.name,a.sponsarid",
                [Auth::user()->ownid]
            );

        return view('user.checkleadership', $arr);
    }
    function register2()
    {
        return view('user.register2');
    }
    //epin
    function epinUsed()
    {
        $ownid = Auth::user()->ownid;
        if ($this->checkFilter()) {
            $from = Session::get('userfrom') . ' 00:00:00';
            $to = Session::get('userto') . ' 23:59:59';
            $arr['epins'] = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=1 and b.applied_at>=? and b.applied_at<=?', [$ownid, $ownid, $from, $to]);
        } else {
            $arr['epins'] = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=1', [$ownid, $ownid]);
        }

        return view('user.epinUsed', $arr);
    }
    function epinPending()
    {
        $ownid = Auth::user()->ownid;
        $arr['epins'] = DB::select('select a.pinid,b.epin,b.planid,sum(type) from (

select 1 as type ,pinid from epinhistory where touser=?
UNION ALL
select -1 as type ,pinid from epinhistory where fromuser=?
    ) as a  join epin as b on b.id=a.pinid   where  b.status=0 GROUP by a.pinid,b.epin,b.planid HAVING SUM(type)>0', [$ownid, $ownid]);
        $arr['users'] = DB::table('users')->where('ownid', '!=', Auth::user()->ownid)->get();
        return view('user.epinPending', $arr);
    }

    function epinTransfer(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|integer',
            'selectUser' => 'required'
        ]);
        try {
            $ownid = Auth::user()->ownid;
            $pending = DB::select('select a.pinid,b.epin,b.planid,sum(type) from (

select 1 as type ,pinid from epinhistory where touser=?
UNION ALL
select -1 as type ,pinid from epinhistory where fromuser=?
    ) as a  join epin as b on b.id=a.pinid   where  b.status=0 GROUP by a.pinid,b.epin,b.planid HAVING SUM(type)>0', [$ownid, $ownid]);
            if ($request->number <= count($pending) && $request->number > 0) {
                $arr['fromuser'] = Auth::user()->ownid;
                $arr['touser'] = Crypt::decrypt($request->selectUser);
                $arr['count'] = $request->number;
                $arr['created_at'] = Carbon::now();
                $insertId = DB::table('epinrecord')->insertGetId($arr);
                $i = 1;
                foreach ($pending as $item) {
                    if ($i <= $request->number) {
                        $i++;
                        $object['fromuser'] = Auth::user()->ownid;
                        $object['touser'] = Crypt::decrypt($request->selectUser);
                        $object['pinid'] = $item->pinid;
                        $object['refid'] = $insertId;
                        $object["created_at"]=Carbon::now();
                        $insertHistory = DB::table('epinhistory')->insert($object);
                    }
                }
                Session::flash('msgUser', $request->number . " E-Pins transferred successfully");
            } else {
                Session::flash('errorUser', $request->number . " E-Pins are not availiable");
            }
        } catch (Exception $e) {
            Session::flash('errorUser', "Unable to transfer please try after some time");
        }
        return redirect()->back();
    }




    function usedepins()
    {
        return view('user.usedepins');
    }

    function transferepindet()
    {
        return view('user.transferepindetail');
    }

    function transferepin()
    {
        return view('user.transferepin');
    }

    function addbeneficiary()
    {
        return view('user.addbeneficiary');
    }
    function moneytransfer()
    {
        return view('user.moneytransfer');
    }
    function royaltyachive()
    {
        $arr["record"]=DB::select("select a.ownid,b.name from royalmembers as a join users as b on a.ownid=b.ownid ");
        return view('user.royaltyachive',$arr);
    }
    function leadershipachivers()
    {
          $arr["record"]=DB::select("select a.ownid,b.name from leadershipmembers as a join users as b on a.ownid=b.ownid");
        return view('user.leadershipachivers',$arr);
    }
    function checkTxn(Request $request)
    {
        if($request->txnPassword)
        {
            if($request->txnPassword==Auth::user()->txnpassword)
            {
                $arr["total"]=Db::table("income")->where("touser",Auth::user()->ownid)->sum("amount")-Db::table("withdrawrequests")->where("ownid",Auth::user()->ownid)->sum("amount");
                return view("user.applyWithdraw",$arr);
            }
            else
            {
                Session::flash('errorUser', "Invalid Transaction password.");
            }
        }
        else
        {
             Session::flash('errorUser', "Invalid Transaction password.");
        }
        return redirect()->back();
    }
    function applyWithdraw(Request $request)
    {
        if($request->amount && $request->amount>=300)
        {
            $total=Db::table("income")->where("touser",Auth::user()->ownid)->sum("amount")-Db::table("withdrawrequests")->where("ownid",Auth::user()->ownid)->sum("amount");
            if($request->amount>=$total)
            {
                  Session::flash('errorUser', "Insufficient balance in your wallet , availiable balance is $total.");
            }
            else
            {
                if(DB::table("withdrawrequests")->where("ownid",Auth::user()->ownid)->where("status",0)->count()>0)
                {
                     Session::flash('errorUser', "Please wait until you previous withdraw is cleared");
                }
                else
                {
                    $arr["ownid"]=Auth::user()->ownid;
                    $arr["amount"]=$request->amount;
                    $arr["tds"]=$total*0.05;
                    $arr["admin"]=$total*0.10;
                    $arr["net"]=$total-(($total*0.05)+($total*0.10));
                    $arr["created_at"]=Carbon::now();
                    if(Db::table("withdrawrequests")->insert($arr))
                    {
                         Session::flash('msgUser', "Withdraw request applied successfully");
                         return redirect()->route("user.withdraw.paid");
                    }
                    else
                    {
                         Session::flash('errorUser', "Unable to apply please try after some time.");
                    }
                }

            }
        }
        else
        {
            Session::flash('errorUser', "Invalid amount.");
        }
       return Redirect()->back()->withInput();
    }


    public function recievedEpin()
    {
        return view("user.recievedEpinDetails");
    }

    public function requestTradingPackage(Request $request)
    {
            $this->validate($request,[
                'package'=>"required|exists:plans,id",
                'txnid'=>'required|string',
                'paymentmode'=>'required|string',
                'screenshot'=>'required|image'
            ]);

            //check if another pack is applied or not
            $chk=DB::table("tradingpackage")->where("ownid",Auth::user()->ownid)->where('status',0)->count();
            if($chk>0)
            {
                Session::flash('errorUser', "Package already applied.");
            }
            else
            {
                $arr["planid"]=$request->package;
                $arr["txnid"]=$request->txnid;
                $arr["pmode"]=$request->paymentmode;

                //upload image
                $screenshot = time() . rand(1000, 9999) . '.' . $request->screenshot->extension();
                $request->screenshot->move(public_path('screenshot'), $screenshot);




                $arr["image"]=$screenshot;
                $arr["created_at"]=Carbon::now();
                $arr["ownid"]=Auth::user()->ownid;
                $ins=DB::table('tradingpackage')->insert($arr);
                if($ins)
                {
                    Session::flash('msgUser',"Applied For Package Successfully");
                }
                else
                {
                    Session::flash('errorUser', "Unable to apply for package please try after some time.");
                }


            }
            return redirect()->back();

    }
     public function requestSalePackage(Request $request)
    {
            $this->validate($request,[
                'package'=>"required|string",
                'txnid'=>'required|string',
                'paymentmode'=>'required|string',
                'screenshot'=>'required|image'
            ]);

            //check if another pack is applied or not
            $chk=DB::table("salepackage")->where("ownid",Auth::user()->ownid)->where('status',0)->count();
            if($chk>0)
            {
                Session::flash('errorUser', "Package already applied.");
            }
            else
            {
                $arr["planid"]=$request->package;
                $arr["txnid"]=$request->txnid;
                $arr["pmode"]=$request->paymentmode;

                //upload image
                $screenshot = time() . rand(1000, 9999) . '.' . $request->screenshot->extension();
                $request->screenshot->move(public_path('screenshot'), $screenshot);




                $arr["image"]=$screenshot;
                $arr["created_at"]=Carbon::now();
                $arr["ownid"]=Auth::user()->ownid;
                $ins=DB::table('salepackage')->insert($arr);
                if($ins)
                {
                    Session::flash('msgUser',"Applied For Package Successfully");
                }
                else
                {
                    Session::flash('errorUser', "Unable to apply for package please try after some time.");
                }


            }
            return redirect()->back();

    }
    /*Show withdraw details start*/
     function showWithdrawApply($type='Basic')
    {
        if($type=='Basic')
        $arr["balance"]=DB::table("income")->where("incometype","ROI")->where("touser",Auth::user()->ownid)->sum('amount');
        else
        $arr["balance"]=DB::table("income")->where("incometype",'!=',"ROI")->where("touser",Auth::user()->ownid)->sum('amount');
        $arr["type"]=$type;
        return view('user.withdrawApplied',$arr);
    }
    function withdrawApplyFinal(Request $request)
    {
        $this->validate($request,[
            "txnPassword"=>'required|string',
            "address"=>'required|string',
            "amount"=>'required|numeric|min:10',
            "type"=>'required|string',
            "addressType"=>'required|string'
            ]);
            
            if($request->type=='Basic' || $request->type=='Promotion')
            {
                if($request->amount<10)
                {
                    Session::flash('errorUser', "Invalid amount, amount should be greater then $ 10 ");
                }
                else
                {
                    try
                    {
                        if($request->txnPassword==Crypt::decrypt(Auth::user()->txnpassword))
                        {
                            if($request->type=='Basic')
                            $balance=DB::table("income")->where("incometype","ROI")->where("touser",Auth::user()->ownid)->sum('amount');
                            else
                            $balance=DB::table("income")->where("incometype",'!=',"ROI")->where("touser",Auth::user()->ownid)->sum('amount');
                            
                            if($request->amount>$balance)
                            {
                                 Session::flash('errorUser', "Enter amount balance is not availiable, Availiable balance is $balance");
                            }
                            else
                            {
                                $wihtdraw["ownid"]=Auth::user()->ownid;
                                $wihtdraw["amount"]=$request->amount;
                                $wihtdraw["tds"]=0;
                                $wihtdraw["admin"]=0;
                                $wihtdraw["net"]=$request->amount;
                                $wihtdraw["created_at"]=Carbon::now();
                                $wihtdraw["type"]=$request->type;
                                $wihtdraw["address"]=$request->address;
                                $wihtdraw["addresstype"]=$request->addressType;
                                $ins=DB::table('withdrawrequests')->insertGetId($wihtdraw);
                                 
                                $income['refid'] =$ins;
                                $income['created_at'] =Carbon::now();
                                $income['amount'] =$request->amount*-1;
                                $income['level'] =0;
                                $income['incometype'] =$request->type=='Basic'?'ROI':'Level';
                                $income['touser'] =Auth::user()->ownid;
                                $income['fromuser'] =Auth::user()->ownid;
                                $income['plan'] =Auth::user()->currentplan;
                                
                                $insert=DB::table("income")->insert($income);
                                
                                if($insert)
                                {
                                     $subject="Withdraw Applied";
                                    $body='<h1>Withdraw Applied</h1>
                                    <p>Your withdraw of amount  '.$request->amount.' is applied successfully. </p>';
                                      userHelper::sendMail("info@teamblazesstaking.com",Auth::user()->email,$subject,$body);
                                      Session::flash('msgUser', "Withdraw applied successfully");
                                }
                                else
                                {
                                      Session::flash('errorUser', "Unable to apply please try after some time.");
                                }
                                
                                 
                                 
                            }
                            
                            
                            
                           
                        }
                        else
                        {
                            Session::flash('errorUser', "Invalid Trsansaction password");
                        }
                    }
                    catch(Exception $e)
                    {
                        dd($e);
                        Session::flash('errorUser', "Invalid Trsansaction password");
                    }
                    
                }
            }
            else
            {
                Session::flash('errorUser', "Unable to proceed, please try after some time.");
            }
            
            return redirect()->back();
    }
    function showClosingDetails($id)
    {
        $closing=DB::table("closingapplied")->find($id);

        $arr["roi"]=DB::Table("income")->where("touser",Auth::user()->ownid)->whereDate("created_at",$closing->created_at)->where("incometype","ROI")->sum("amount");
        $arr["level"]=DB::Table("income")->where("touser",Auth::user()->ownid)->whereDate("created_at",$closing->created_at)->where("incometype","Level")->sum("amount");
        $fromClosing=DB::table("closingapplied")->where("created_at","<",$closing->created_at)->orderby("id","desc")->first();
         if(empty($fromClosing))
         $from=$closing->created_at;
         else
        $from=$fromClosing->created_at;




           if(!empty($fromClosing))
        $arr["direct"]=DB::Table("income")->where("touser",Auth::user()->ownid)->whereDate("created_at",'>',$from)->where("created_at",'<=',$closing->created_at)->where("incometype","Direct")->sum("amount");
        else
        $arr["direct"]=DB::Table("income")->where("touser",Auth::user()->ownid)->where("created_at",'<=',$closing->created_at)->where("incometype","Direct")->sum("amount");

        $userid=Auth::user()->ownid;
        if(!empty($fromClosing))
       {

           DB::enableQueryLog();
           $arr["record"]=DB::select("select a.touser,sum(a.amount) as amount,(select sum(amount)*-1 from income where amount<0 and created_at>'$from' and created_at<='$closing->created_at' and touser='$userid' ) as posted,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank from income as a join users as b on a.touser=b.ownid where a.created_at>? and a.created_at<=? and a.touser=? and a.amount>0 group by a.touser,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank",[$from,$closing->created_at,Auth::user()->ownid]);

        //dd(DB::getQueryLog());
        }else
          $arr["record"]=DB::select("select a.touser,sum(a.amount) as amount,(select sum(amount)*-1 from income where amount<0 and created_at<='$closing->created_at' and touser='$userid' ) as posted,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank from income as a join users as b on a.touser=b.ownid where  a.created_at<=? and a.touser=? and a.amount>0 group by a.touser,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank",[Carbon::parse($closing->created_at)->format("Y-m-d 24:00:00"),Auth::user()->ownid]);

        $arr["closing"]=$closing;
        return view("user.closingDetails",$arr);

    }
    /*Show withdraw detail end */

    public function applyA4print()
    {
        $paperSize=array(100);

        $pdf=new MYTCPDF("P","mm",$paperSize,true,"utf-8",false);
        $padding=0.4;

           $html='<table style="border-bottom:1px solid #222;">

         <tbody>
         <tr style="">
             <td style="font-size:15px;"><b>Pay To</b></td>
             <td style="font-size:15px;"><b>Bill TO</b></td>

         </tr>
         <tr style="">
         <td style="font-size:11px;">Name : name</td>
         <td style="font-size:11px;">Company : name</td>
         </tr>
         <tr style="">
         <td style="font-size:11px;">Address : Sirsa</td>
         <td style="font-size:11px;">Address : Sirsa</td>
         </tr>
         <tr style="">
         <td style="font-size:11px;">City/State : Sirsa</td>
         <td style="font-size:11px;">City/State : Sirsa</td>
         </tr>
         <tr style="">
         <td style="font-size:11px;">Phone : 1234567891</td>
         <td style="font-size:11px;">Phone : 1234567891</td>
         </tr>
         <tr>
         <td></td>
         </tr>';

         $html.='
         <table style="border-bottom:1px solid #ccc;">
         <thead style="">
         <tr>
         <th style="font-size:11px;"><strong>Sr.</strong></th>
         <th style="font-size:11px;"><strong>&nbsp;Item Name</strong></th>
         <th style="font-size:11px ;"><strong>Qty</strong></th>
         <th style="font-size:11px;"><strong>Total</strong></th>
         </tr>
         </thead>
         </table>';
         $html.='<table style="">';
         $html.='<tbody style="text-align:center;">';
           $html.='<tr>
            <td style="width:30px;font-size:11px text-align:center;"></td>
            <td style="font-size:11px text-align:center;"></td>
            <td style="font-size:11px text-align:center;"></td>
            <td style="font-size:11px; text-align:right;"></td>
           </tr>';



        $html.='</tbody>
         </table>';
        $html.='<table style="padding-left:150px;border-top:1px solid #ccc;">
        <tbody>
        <tr>
        <td style="font-size:11px;text-align:center;">Total</td>
        <td style="font-size:11px;">1000</td>
        </tr>';
        $html.='<tr>
       <td  style="width:100%;font-size:11px text-align:center;"><h6 style="text-align:center"></h6></td>
      </tr>';
         $html.='<tr>
         <td  style="width:100%;font-size:11px text-align:center;"><h6 style="text-align:center"></h6></td>
        </tr>';


           $html.='</tbody>
            </table>';
           $html.='<table style="">
           <tbody style="text-align:center">
          ';
           $html.='<tr>
          <td  style="font-size:11px text-align:center;"><h6 style="text-align:center"></h6></td>
         </tr>';
           $html.='<tr style="text-align:center">
           <td  style="font-size:11px text-align:center;"><h6 style="text-align:center"><i>Designed And Developed By Einix Infotech</i></h6></td>

          </tr>';
          $html.='</tbody>
           </table>';
                // <!--footer--!>
        $footerCredits = '<h6 style="text-align:center"><i>Designed And Developed By Einix Infotech</i></h6>';
      //  dd($footerCredits);
         //<!--Logo Set--!>


         $pageNumber = '<h6 style="text-align:center">'.'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages().'</h6>';
         $pdf->footerCredits = $footerCredits;
         $pdf->pagenumber = $pageNumber;
         $pdf->SetMargins(5,5,5,false);
         $pdf->setCellPadding( $padding );
            // $pdf->setHeaderData($this->getHeader());

         $pdf->SetTitle('');
         $pdf->AddPage();

            /*--Header start----**/
            $htmlHeader='<table>
            <tbody>
            <tr style="text-align:center;">
             <td>
             <img  src="http://localhost/sandeep_mlm/public/website/logo.png"/>
             </td>
            </tr>
            <tr style="padding-left:400px;">
                <td style="width:50px;border-bottom:2px solid #222;font-size:13px;"><b>Invoice</b></td>
            </tr>
            <tr style="display:block;">
                <td style="width:100px;border-bottom:1px solid #ccc;font-size:13px;"><b>Date :</b></td>
            </tr>
            <tr style="display:block;">
                <td style="width:100px;border-bottom:1px solid #ccc;font-size:13px;"><b>Invoice No :</b></td>
                <td style=""><b></b></td>
            </tr>
            <tr style="display:block;">
                 <td style=""><b></b></td>
            </tr>';
             $htmlHeader.='</tbody></table>';
            //$htmlHeader.= '<h3 style="background:#000;width:76.2mm;"><u style="text-align:center;">Car Wash</u></h3>';
            /*--Header end ----**/
         $pdf->writeHTML($htmlHeader.$html, true, false, true, false, '');
         ob_end_clean();

         $pdf->Output('hello_world.pdf');
    }
    function sharePage()
    {
        return view("user.share");
    }
}

class MYTCPDF extends GlobalTCPDF
{
    // <tr >
    //         <td colspan="2"><b>Date :</b> 15-May-2021  <br> <b>Party</b> : CASH</td>

    //         <td colspan="2">

    //             <b>Place</b> :                                                         <br>  <b>Vechicle No</b> : HR 39E 0369
    //         </td>

    //     </tr>
    //Page header
    public function Header() {

        // $html = '<h3><u>Gate Pass</u></h3>';
        // $html2='<p>Golden Frozen Fruits</p>';
        // $html3='<table>
        // <tbody><tr>
        //     <td colspan="3" style="border:1px solid #000;"><b>&nbsp;GatePass No :</b><br> <b>&nbsp;Date :</b> 15-May-2021  <br> <b>&nbsp;Party</b> : CASH</td>
        //     <td colspan="6" style="border:1px solid #000;"><b>&nbsp; &nbsp;Place</b> : <br>  <b>Vehicle No</b> : HR 39E 0369</td>
        // </tr></tbody></table>';
        // $this->setCellMargins(53,0,0,0);
        // $this->writeHTMLCell(148,10,39,0,$html);
        // $this->writeHTMLCell(148,10,33,8,$html2);
        // $this->writeHTMLCell(148,10,0,16,$html3,1);

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        // $this->SetY(-15);
        // $html = '<h6 style="text-align:center"><i>Designed And Developed By Einix Infotech</i></h6>';
        // $this->writeHTML($html, true, false, true, false, '');
        // // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    

}
