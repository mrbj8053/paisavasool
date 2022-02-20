<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;
use userHelper;

class adminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    function index()
    {






        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['epinsused'] = DB::table('epin')->where('status', 1)->where('applied_at', '>=', $from)->where('applied_at', '<=', $to)->get();
            $arr['directincome']=userHelper::getIncome("Direct","All",$from,$to,true);
            $arr['levelincome']=userHelper::getIncome("Level","All",$from,$to,true);
            $arr['royaltyincome']=userHelper::getIncome("Royalty","All",$from,$to,true);
            $arr['roiincome']=userHelper::getIncome("ROI","All",$from,$to,true);
            $arr['singlelevelincome']=userHelper::getIncome("Single","All",$from,$to,true);
            $arr['withdraw']=userHelper::getWithdraws("All",$from,$to,true);
        } else {
            $arr['epinsused'] = DB::table('epin')->where('status', 1)->get();
            $arr['directincome']=userHelper::getIncome("Direct","All","none","none",true);
            $arr['levelincome']=userHelper::getIncome("Level","All","none","none",true);
            $arr['royaltyincome']=userHelper::getIncome("Royalty","All","none","none",true);
            $arr['roiincome']=userHelper::getIncome("ROI","All","none","none",true);
            $arr['singlelevelincome']=userHelper::getIncome("Single","All","none","none",true);
            $arr['withdraw']=userHelper::getWithdraws("All","none","none",true);
        }
        $arr['users'] = DB::table('users')->get();
        $arr['usersthisweek'] = DB::table('users')->where('created_at', '>=', Carbon::now()->subDays(7))->get();
        $arr['royalmembers'] = DB::table('royalmembers')->count();
        $arr['epinsgenerated'] = DB::table('epin')->get();
        $arr['epinstransferred'] = DB::table('epinrecord')->where('fromuser', 'Admin')->get();;
        $arr['epinspending'] = DB::select('select a.*,b.epin,b.applied_at from epinhistory as a join epin as b on b.id=a.pinid where a.touser="Admin" and a.pinid not in(select pinid from epinhistory where fromuser="Admin") and b.status=0');
        $arr['business']= DB::select("select ifnull(sum(a.entryamount),0) as amount from plans as a join users as b on a.id=b.currentplan  where  b.isactive=1")[0]->amount;
        $arr['todayBusiness']= DB::select("select ifnull(sum(a.entryamount),0) as amount from plans as a join users as b on a.id=b.currentplan  where  b.isactive=1 and DATE_FORMAT(b.activeon,'%Y-%m-%d')=?",[Carbon::now()->format("Y-m-d")])[0]->amount;
        return view('admin.home', $arr);
    }
    /* Epin section start */
    function showEpinPending()
    {
        $ownid = Auth::user()->ownid;
        $arr['epins'] = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser="Admin" and a.pinid not in(select pinid from epinhistory where fromuser="Admin") and b.status=0', [$ownid, $ownid]);
        $arr['users'] = DB::table('users')->where('ownid', '!=', Auth::user()->ownid)->get();
        return view('admin.epinPending', $arr);
    }

    function epinTransfer(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|integer',
            'selectUser' => 'required',
            'epinType' => 'required'
        ]);
        try {
            $planid = Crypt::decrypt($request->epinType);
            $ownid = Auth::user()->ownid;
            $pending = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser="Admin" and a.pinid not in(select pinid from epinhistory where fromuser="Admin") and b.status=0 and b.planid=?', [$planid]);
            if ($request->number <= count($pending) && $request->number > 0) {
                $arr['fromuser'] = "Admin";
                $arr['touser'] = Crypt::decrypt($request->selectUser);
                $arr['count'] = $request->number;
                $arr['created_at'] = Carbon::now();
                $insertId = DB::table('epinrecord')->insertGetId($arr);
                $i = 0;
                foreach ($pending as $item) {
                    $i++;
                    if ($i <= $request->number) {
                        $object['fromuser'] = "Admin";
                        $object['touser'] = Crypt::decrypt($request->selectUser);
                        $object['pinid'] = $item->pinid;
                        $object['refid'] = $insertId;
                        $object['created_at'] = Carbon::now();
                        $insertHistory = DB::table('epinhistory')->insert($object);
                    }
                }
                Session::flash('msgAdmin', $request->number . " E-Pins transferred successfully");
            } else {
                Session::flash('errorAdmin', $request->number . " E-Pins are not availiable");
            }
        } catch (Exception $e) {
            dd($e);
            Session::flash('errorAdmin', "Unable to transfer please try after some time");
        }
        return redirect()->back();
    }

    function showRewardMembers(Request $request)
    {
        $arr["record"]=DB::select("select a.*,b.name,b.mobile,b.name,c.reward as rname from rewardachievers as a join users as b on a.ownid=b.ownid join reward as c on a.reward_id=c.id order by a.id asc");
        return view("admin.rewards",$arr);
    }

    function addRewardManual()
    {
        $arr["user"]=DB::table("users")->get();
        $arr["reward"]=DB::Table("reward")->get();
        $arr["record"]=DB::select("select a.*,b.name,b.mobile,b.name,c.reward as rname from rewardachievers as a join users as b on a.ownid=b.ownid join reward as c on a.reward_id=c.id order by a.id asc");//DB::table("rewardachievers")->get();
        return view("admin.rewardAdd",$arr);
    }
    function addRewardFinal(Request $request)
    {
        $this->validate($request,[
            "selectUser"=>"required|string",
            "reward"=>"required|string",
            "rewardDate"=>"required|string"
            ]);
            $where["ownid"]=$request->selectUser;
            $where["reward_id"]=$request->reward;

        $chkAlready=DB::Table("rewardachievers")->where($where)->get();

        if(count($chkAlready)>0)
        {
            DB::Table("rewardachievers")->where($where)->delete();
            // Session::flash('errorAdmin', "Reward already given for the selected business.");
        }

             $arr["ownid"]=$request->selectUser;
             $arr["reward_id"]=$request->reward;
             $arr["remarks"]="Level manually added by admin";
             $arr["created_at"]=Carbon::now();
             $arr["status"]=1;
             DB::enableQueryLog();
             if(DB::table("rewardachievers")->insert($arr))
             {
                  Session::flash('msgAdmin', $request->number . "Reward assigned successfully");
                  $max=DB::table("rewardachievers")->where("ownid",$request->selectUser)->max("reward_id");

                  DB::table("users")->where("ownid",$request->selectUser)->update(["reward"=>$max,"rewarddate"=>Carbon::now()]);
             }
             else
             {

                 Session::flash('errorAdmin', "Unable to assign rewrd please try after some time.");
             }


        return redirect()->back();
    }

    function showPinTransferred()
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['epins'] = DB::table('epinrecord')->where('fromuser', 'Admin')->whereBetween('created_at', [$from, $to])->get();
        } else {
            $arr['epins'] = DB::table('epinrecord')->where('fromuser', 'Admin')->get();
        }

        return view('admin.epinTransferred', $arr);
    }
    function showEpinUsed()
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['epins'] = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser="Admin" and a.pinid not in(select pinid from epinhistory where fromuser="Admin") and b.status=1 and b.applied_at>=? and b.applied_at<=?', [$from, $to]);
        } else {
            $arr['epins'] = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser="Admin" and a.pinid not in(select pinid from epinhistory where fromuser="Admin") and b.status=1');
        }

        return view('admin.epinUsed', $arr);
    }
    public function generateEpin(Request $request)
    {
        $this->validate($request, [
            'numberpin' => 'required|integer',
            'epinType' => 'required'
        ]);

        try {
            $planid = Crypt::decrypt($request->epinType);
            if ($request->numberpin > 0) {
                $lastRecordId = 0;
                $number = $request->numberpin;
                $generated = 0;
                for ($i = 0; $i < $number; $i++) {
                    $random = $this->getToken(10);
                    $generated++;
                    $chk = DB::table('epin')->where('epin', $random)->get();
                    while (count($chk) > 0) {
                        $random = $this->getToken(10);
                        $chk = DB::table('epin')->where('epin', $random)->get();
                    }
                    $pinrecod['fromuser'] = "From Admin";
                    $pinrecod['touser'] = "Admin";
                    $pinrecod['created_at'] = Carbon::now();
                    $pinrecod['count'] = "0";
                    if ($i == 0)
                        $lastRecordId = DB::table('epinrecord')->insertGetId($pinrecod);
                    //insert into epin
                    $arr['epin'] = $random;
                    $arr['created_at'] = Carbon::now();
                    $arr['planid'] = $planid;
                    $lastid = DB::table('epin')->insertGetId($arr);
                    //insert into epinhistory
                    $history['fromuser'] = "From Admin";
                    $history['touser'] = "Admin";
                    $history['created_at'] = Carbon::now();
                    $history['pinid'] = $lastid;
                    $history['refid'] = $lastRecordId;
                    $insert = DB::table('epinhistory')->insert($history);
                }
                $upRecord['count'] = $generated;
                $upd = DB::table('epinrecord')->where('id', $lastRecordId)->update($upRecord);
                Session::flash("msgAdmin", $generated . " E-pin's generated successfully.");
            } else {
                Session::flash("errorAdmin", "Invalid number of E-pins");
            }
        } catch (Exception $e) {
            Session::flash("errorAdmin", "Invalid pintype");
        }
        return redirect()->back();
    }
    public  function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }
        return $token;
    }

    /*Epin section end */
    /*Users section start */
     function showUsers()
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['users'] = DB::table('users')->whereBetween('created_at', [$from, $to])->where("isactive",1)->orderby("created_at","asc")->get();
        } else {
            $arr['users'] = DB::table('users')->orderby("isactive","desc")->where("isactive",1)->get();
        }

        return view('admin.allUsers', $arr);
    }
    function showUsersInactive()
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['users'] = DB::table('users')->whereBetween('created_at', [$from, $to])->where("isactive",0)->orderby("created_at","asc")->get();
        } else {
            $arr['users'] = DB::table('users')->orderby("isactive","desc")->where("isactive",0)->get();
        }

        return view('admin.allUsersInactive', $arr);
    }


/*Show club cheivers*/
  function showRoyaltyMembers()
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['users'] = DB::table('users')->where('isroyalmember',1)->whereBetween('created_at', [$from, $to])->get();
        } else {
            $arr['users'] = DB::table('users')->where('isroyalmember',1)->get();
        }

        return view('admin.royaltyAchievers', $arr);
    }
    function changeUserStatus($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $user = DB::table('users')->find($decrypted);
            if ($user->status == 1) {
                $upd = DB::table('users')->where('id', $decrypted)->update(['status' => 0]);
                Session::flash("msgAdmin", "User " . $user->name . "(" . $user->ownid . ") id successfully Disabled");
            } else {
                $upd = DB::table('users')->where('id', $decrypted)->update(['status' => 1]);
                Session::flash("msgAdmin", "User " . $user->name . "(" . $user->ownid . ") id successfully Enabled");
            }
        } catch (Exception $e) {
            Session::flash("erroAdmin", "Unable to change status of the user.");
        }

        return redirect()->back();
    }

    function showEditProfile($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $arr['user'] = DB::table('users')->find($decrypted);
            return view('admin.userProfile', $arr);
        } catch (Exception $e) {
            Session::flash('errorAdmin', "Unable to update your profile");
        }
        return redirect()->back();
    }
    function editUserProfile(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'mobile'=>"required|string",
            'level'=>"required"
        ]);
        try {
            $decrypted = Crypt::decrypt($id);
            $arr['name'] = $request->name;
            $arr['dob'] = $request->dob;
            $arr['email'] = $request->email;
            $arr['address'] = $request->address;
            $arr['mobile']=$request->mobile;
            $arr['currentlevel']=$request->level;
            $upd = DB::table('users')->where('id', $decrypted)->update($arr);
            if ($upd)
                Session::flash('msgAdmin', 'Profile updated successfully');
            else
                Session::flash('errorAdmin', "Unable to update your profile");
        } catch (Exception $e) {
            Session::flash('errorAdmin', "Unable to update your profile");
        }
        return redirect()->back();
    }
    function showLevelDetails($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $user = DB::table('users')->find($decrypted);
            $ownid = $user->ownid;
            $arr['members'] = DB::select("SELECT a.ownid,count(a.level) as total,a.level,b.name FROM levelmembers as a join users as b on a.ownid=b.ownid where a.ownid=? and a.level<12 GROUP by a.level,a.ownid,b.name", [$ownid]);
            return view('admin.levelDetails', $arr);
        } catch (Exception $e) {
            Session::flash("errorAdmin", "Unable to get level details");
        }

        return redirect()->back();
    }

    function showKyc()
    {
        $arr['users'] = DB::table('users')->where('isactive',1)->where("kyc","!=",2)->where("kyc","!=",0)->get();
        $arr['title']="KYC Uploaded";
        return view('admin.kycUsers')->with($arr);
    }
    function showKycPendingCnf()
    {
         $arr['users'] = DB::table('users')->where('isactive',1)->where("kyc","=",0)->get();
        $arr['title']="KYC Pending";
        return view('admin.kycUsers')->with($arr);
    }
    function showKycDone()
    {
        $arr['users'] = DB::table('users')->where('kyc',2)->where("isactive",1)->get();
        return view('admin.kycUsersDone')->with($arr);
    }

    function showEditKyc($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $user = DB::table('users')->find($decrypted);
            $arr['user'] = $user;
            return view('admin.editKyc', $arr);
        } catch (Exception  $e) {

            Session::flash('errorAdmin', "Unable to edit kyc");
        }
        return redirect()->back();
    }
    function updateEditKyc($id, Request $request)
    {
        $this->validate($request, [
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
        try {
            $decrypted = Crypt::decrypt($id);
            $user = DB::table('users')->find($decrypted);
            $ownid = $user->ownid;

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
                $qry = "update users set kycmobile='$request->KYCMOBILE',kycname='$request->KYCNAME',kycrelation='$request->KYCRELATION',kycage='$request->KYCAGE',pannumber='$request->PanNumber',accountnumber='$request->AccountNumber',bank='$request->Bank',ifsc='$request->IFSC',branch='$request->Branch',kyc=1" . $addon . " where id=" . $decrypted;
            } else {
                $qry = "update users set kycmobile='$request->KYCMOBILE',kycname='$request->KYCNAME',kycrelation='$request->KYCRELATION',kycage='$request->KYCAGE',pannumber='$request->PanNumber',accountnumber='$request->AccountNumber',bank='$request->Bank',ifsc='$request->IFSC',branch='$request->Branch',kyc=1 where id=" . $decrypted;
            }

            $result = DB::update($qry);
            if ($result)
                Session::flash('msgAdmin', 'Kyc updated successfully');
            else
                Session::flash('errorAdmin', 'Unable to update kyc');
        } catch (Exception $e) {
            Session::flash('errorAdmin', "Unable to update kyc please try after some time");
        }
        return redirect()->back();
    }

    function changeKycStatus($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $upd = DB::table('users')->where('id', $decrypted)->update(['kyc' => 2]);
            if ($upd)
                Session::flash('msgAdmin', "Kyc verified succesfully");
            else
                Session::flash('errorAdmin', "Unable to verify kyc try after some time");
        } catch (Exception $e) {
            Session::flash('errorAdmin', "Uable to change status");
        }
        return redirect()->back();
    }
    /*Users section end */

    /* income start */
    function showIncome($type)
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['income'] =userHelper::getIncome($type,"All",$from,$to);
        } else {
            $arr['income'] =userHelper::getIncome($type,"All","none","none");
        }
        $arr["title"]="$type Income";
        $arr["type"]=$type;
        return view('admin.showIncome')->with($arr);
    }

    function showIncomeDetail($type,$id)
    {
        try {
            $decrypted = Crypt::decrypt($id);

            if ($this->checkFilter()) {
                $from = Session::get('adminfrom') . ' 00:00:00';
                $to = Session::get('adminto') . ' 23:59:59';
                $arr['income'] =userHelper::getIncome($type,$decrypted,$from,$to);
            } else {
                $arr['income'] =userHelper::getIncome($type,$decrypted,"none","none");
            }
        } catch (Exception $e) {
            Session::flash("errorAdmin", "No details found");
            return redirect()->back();
        }
        $arr["title"]=$type;

        return view('admin.showIncomeDetail', $arr);
    }
    /* income end */

    /*User tree start*/
    function showTreePost(Request $request)
    {
        try {
            $name = $request->plan;
            $ownid = Crypt::decrypt($request->id);
            $user = DB::table('users')->where('ownid', $ownid)->get();
            $plans = DB::table("plans")->where('id', '<=', $user[0]->currentplan)->get();
            $planDetails = DB::table('plans')->where('name', $name)->get();
            $parent = DB::table("users")->where('ownid', $ownid)->get();
            $arr['parent'] = $parent[0];
            $arr['plans'] = $plans;
            $arr['all'] = User::all();
            $arr['current'] = $name;
            $arr['childs'] = DB::table("users")->where('parentid', $parent[0]->ownid)->get();
            return view('admin.showTree')->with($arr);
        } catch (Exception $e) {
            $name = "Silver";
            $ownid = "VM862560";
            $user = DB::table('users')->where('ownid', $ownid)->get();

            $plans = DB::table("plans")->where('id', '<=', $user[0]->currentplan)->get();
            $planDetails = DB::table('plans')->where('name', $name)->get();
            $parent = DB::table("users")->where('ownid', $ownid)->get();

            $arr['parent'] = $parent[0];
            $arr['plans'] = $plans;
            $arr['all'] = User::all();
            $arr['current'] = $name;
            $arr['childs'] = DB::table("users")->where('parentid', $parent[0]->ownid)->get();
            return view('admin.showTree')->with($arr);
        }
    }

    /*User tree end*/

    /*Withdraw Section start */
    function showWithdrawPaid()
    {
            $arr['record'] = DB::Table("withdrawrequests")->where("status",1)->orderBy('id', 'DESC')->get();
        return view('admin.withdrawPaid', $arr);
    }

    function showWithdrawPending()
    {
            $arr['record'] =DB::Table("withdrawrequests")->where("status",2)->orderBy('id', 'DESC')->get();

        return view('admin.withdrawPending', $arr);
    }
    function showWithdrawDetail($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $arr['record'] = DB::select('select a.incometype,a.touser,b.name,sum(a.amount) as amount from income as a join users as b on a.touser=b.ownid where a.refid=? group by b.name,a.touser,a.incometype', [$decrypted]);
            return view('admin.withdrawDetails', $arr);
        } catch (Exception $e) {
            dd($e);
            Session::flash("errorAdmin", "Unable to fetch withdraw details");
        }
        return redirect()->back();
    }
    /*Withdraw Section end */

    /*Logout start */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function logout(Request $request)
    {
        $sessionKey = $this->guard()->getName();
        $this->guard()->logout();
        $request->session()->forget($sessionKey);
        return Redirect::route('admin.login');
    }
    /*Logout end */

    /*Withdraw do payment start */
    public function doPayment(Request $request)
    {
        $done = false;
        $smsUser = array();
        $array_list = $request->arr_list;
        $show_date = $request->show_date;
        $proceed = false;
        foreach ($array_list as $value) {
            $decrypted = Crypt::decrypt($value);
            $withInfo = DB::select('select * from withdrawfinal where id=?', [$decrypted]);
            if (in_array($withInfo[0]->ownid, $smsUser)) {
            } else {
                array_push($smsUser, $withInfo[0]->ownid);
            }
            $record=DB::table('withdrawfinal')->find($decrypted);
            $dopay['ownid']=$record->ownid;
            $dopay['amount']=$record->amount*-1;
            $dopay['tds']=$record->tds;
            $dopay['admin']=$record->admin;
            $dopay['net']=$record->net*-1;
            $dopay['remark']=$show_date;
            $dopay['created_at']=Carbon::now();
            $dopay['paytime']=Carbon::now();
            $dopay['type']='c';
            DB::table('withdrawfinal')->insert($dopay);
            $upd = DB::update('update withdrawfinal set status=1,paytime=?,remark=? where id=?', [Carbon::now(), $show_date, $decrypted]);
            if ($upd) {
                $done = true;
            } else {
                $done = false;
            }
        }
        echo $done ? 1 : 0;
    }
    /*Withdraw do payment end */
    /*Change password start */
    function showPasswordForm()
    {
        return view('admin.changePassword');
    }

    function changePassword(Request $request)
    {
        $validate_user = DB::select('select * from admins where email=?', ['admin@mlmhisar.com']);
        if ($validate_user && Hash::check($request->OldPassword, $validate_user[0]->password)) {
            if ($request->NewPassword == $request->ConfirmPassword) {

                $hashedPassword = Hash::make($request->NewPassword, [
                    'rounds' => 12,
                ]);
                $change = DB::update('update admins set password=? where email=?', [$hashedPassword, 'admin@mlmhisar.com']);
                Session::flash('msgAdmin', 'Password changed successfully');
            } else {
                Session::flash('errorAdmin', 'Password and confirm Password not matched');
            }
        } else {
            Session::flash('errorAdmin', 'Incorrect old password');
        }
        return redirect()->back();
    }
    /*Change password end */
    /*Company wallet start */
    function showCompanyWallet()
    {
        if ($this->checkFilter()) {
            $from = Session::get('adminfrom') . ' 00:00:00';
            $to = Session::get('adminto') . ' 23:59:59';
            $arr['record'] = DB::table('wallet')->whereBetween('created_at', [$from, $to])->get();
        } else {
            $arr['record'] = DB::table('wallet')->get();
        }

        return view('admin.wallet', $arr);
    }
    /*Company wallet end */

    /*date filter start */
    public function checkFilter()
    {
        if (Session()->has('adminfrom') && Session::has('adminto'))
            return true;
        else
            return false;
    }
    public function filterApply(Request $request)
    {
        Session::put('adminfrom', $request->fromdate);
        Session::put('adminto', $request->todate);
        return redirect()->route('admin.dashboard.home');
    }
    public function clearFilter()
    {
        Session::forget('adminfrom');
        Session::forget('adminto');
        return redirect()->route('admin.dashboard.home');
    }
    /*date filter end */

    /*Apply withdraw start */
    function applyWithdraw()
    {

        $chk = DB::table('withdrawfinal')->where('created_at', '>=', Carbon::now()->subDay(1))->get();
        if (true/*count($chk) == 0*/) {
               //send club income
            userHelper::sendClubIncome("UD0000000");
            //get all income
            $all = DB::select("SELECT touser,sum(amount) as amount FROM `income`  GROUP by touser order by touser");
            if (count($all) > 0) {

                //update all income
                //DB::table("income")->update(['status'=>1]);
                foreach ($all as $item) {
                        $ownid=$item->touser;
                        $user = DB::table('users')->where('ownid', $ownid)->get();
                        $planDetails = userHelper::getPlanDetails($user[0]->currentplan);
                        $withAmount=DB::table("withdrawfinal")->where('ownid',$ownid)->sum('amount');

                        $actAmount=$item->amount-$withAmount;

                        if (false/*$withAmount >= $planDetails->mylimit*/) {
                            $arr['ownid']   = $ownid;
                            $arr['fromuser']   = $fromid;
                            $arr['remark']   = 'Plan limit reached ';
                            $arr['type']   = 'Plan limit reached ' . $planDetails->entryamount . " plan name is :" . $planDetails->name;
                            DB::table('missincome')->insert($arr);
                        }
                        else
                        {
                            if(false/*$actAmount>=$planDetails->mylimit*/)
                            {
                                $actAmount=$planDetails->mylimit;
                            }
                              $get = DB::table('users')->where('sponsarid', $ownid)->where("isactive",1)->get();
                            if (count($get) >= 3) {
                            $arr['ownid'] = $item->touser;
                            $arr['amount'] = $actAmount;
                            $arr['tds'] =$actAmount * 0.0375;
                            $arr['admin'] = $actAmount * 0.05;
                            $arr['net'] = $actAmount - ($actAmount* 0.0375 + $actAmount * 0.05);
                            $arr['remark'] = "Withdraw applied";
                            $arr['created_at'] = Carbon::now();
                            $insertId=DB::table('withdrawfinal')->insertGetId($arr);
                          //  $upd = Db::table('income')->where('status', 0)->where('touser', $item->touser)->update(['status' => 1, 'refid' => $insertId]);
                        }
                    }
                }

                Session::flash('msgAdmin', "Withdraw Applied Successfully");
            } else {
                Session::flash('errorAdmin', "No income found to apply withdraw");
            }
        } else {
            Session::flash('errorAdmin', "Unable to apply withdraw");
        }

        return redirect()->back();
    }
    /*Apply withdraw end */

    /*Gallery start*/
    public function showGallery()
    {
        $arr['gallery']=DB::select('select * from gallery');
        return view('admin.gallery')->with($arr);
    }
    public function uploadGallery(Request $request)
    {
        $this->validate($request,[
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $imageName = time().'.'.$request->Image->extension();
        $request->Image->move(public_path('Gallery'), $imageName);
        DB::insert('insert into gallery(image,created_at,updated_at) values(?,?,?)',[$imageName,Carbon::now(),Carbon::now()]);
        $arr['gallery']=DB::select('select * from gallery');
        Session::flash("msgAdmin","Image uploaded successfully");

        return redirect()->back();
    }
     public function deleteGallery($id)
    {
        $decrypted=Crypt::decrypt($id);
        $getDetail=DB::select('select * from gallery where id=?',[$decrypted]);
        $file_path = public_path('Gallery/').$getDetail[0]->image;
        DB::delete('delete from gallery where id=?',[$decrypted]);
      try{
          unlink($file_path);

      }catch(Exception $e)
      {
      }
        Session::flash("msgAdmin","Image deleted successfully");
        $arr['gallery']=DB::select('select * from gallery');
        return redirect()->back();
    }
    /*Gallery End*/

    /*Achievers section start */
    function showAchievers()
    {
        $arr['achievers']=DB::select('select * from achievers');
        return view('admin.achievers',$arr);
    }

    function uploadAchievers(Request $request)
    {
        $this->validate($request,[
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name'=>'required'
        ]);
        $imageName = time().'.'.$request->Image->extension();
        $request->Image->move(public_path('Achievers'), $imageName);
        $arr['image']=$imageName;
        $arr['title']=$request->name;
        $ins=DB::table('achievers')->insert($arr);
        Session::flash("msgAdmin","Achiever added successfully");
        return redirect()->back();
    }
    function  deleteAchievers($id){
         $decrypted=Crypt::decrypt($id);
        $getDetail=DB::select('select * from achievers where id=?',[$decrypted]);
        $file_path = public_path('Achievers/').$getDetail[0]->image;
        DB::delete('delete from achievers where id=?',[$decrypted]);
        unlink($file_path);
        Session::flash("msgAdmin","Achiever removed successfully");
        $arr['gallery']=DB::select('select * from gallery');
        return redirect()->back();
    }
    /*Achievers section end*/

    /*E-Pin request section start */
    function showEpinRequest()
    {
        $arr['epins']=DB::table('epinrequest')->orderBy('status','desc')->get();
        return view('admin.epinRequests',$arr);
    }

    function approoveEpinRequest($id)
    {
            try {
                $decrypted = Crypt::decrypt($id);
                $result=DB::table('epinrequest')->find($decrypted);
                $planid =$result->planid;
                if ($result->number > 0) {
                    $lastRecordId = 0;
                    $number = $result->number;
                    $generated = 0;
                    for ($i = 0; $i < $number; $i++) {
                        $random = $this->getToken(10);
                        $generated++;
                        $chk = DB::table('epin')->where('epin', $random)->get();
                        while (count($chk) > 0) {
                            $random = $this->getToken(10);
                            $chk = DB::table('epin')->where('epin', $random)->get();
                        }
                        $pinrecod['fromuser'] = "From Admin";
                        $pinrecod['touser'] = "Admin";
                        $pinrecod['created_at'] = Carbon::now();
                        $pinrecod['count'] = "0";
                        if ($i == 0)
                            $lastRecordId = DB::table('epinrecord')->insertGetId($pinrecod);
                        //insert into epin
                        $arr['epin'] = $random;
                        $arr['created_at'] = Carbon::now();
                        $arr['planid'] = $planid;
                        $lastid = DB::table('epin')->insertGetId($arr);
                        //insert into epinhistory
                        $history['fromuser'] = "From Admin";
                        $history['touser'] = "Admin";
                        $history['created_at'] = Carbon::now();
                        $history['pinid'] = $lastid;
                        $history['refid'] = $lastRecordId;
                        $insert = DB::table('epinhistory')->insert($history);
                    }
                    $upRecord['count'] = $generated;
                    $upd = DB::table('epinrecord')->where('id', $lastRecordId)->update($upRecord);

                    $planid = $result->planid;
                    $ownid = userHelper::getUserById($result->fuserid)->ownid;
                    $pending = DB::select('select a.*,b.epin,b.applied_at,b.planid from epinhistory as a join epin as b on b.id=a.pinid where a.touser="Admin" and a.pinid not in(select pinid from epinhistory where fromuser="Admin") and b.status=0 and b.planid=?', [$planid]);
                    if ($result->number <= count($pending) && $result->number > 0) {
                        $arrr['fromuser'] = "Admin";
                        $arrr['touser'] = $ownid;
                        $arrr['count'] = $result->number;
                        $arrr['created_at'] = Carbon::now();
                        $insertId = DB::table('epinrecord')->insertGetId($arrr);
                        $i = 0;
                        foreach ($pending as $item) {
                            $i++;
                            if ($i <= $result->number) {
                                $object['fromuser'] = "Admin";
                                $object['touser'] = $ownid;
                                $object['pinid'] = $item->pinid;
                                $object['refid'] = $insertId;
                                $object['created_at'] = Carbon::now();
                                $insertHistory = DB::table('epinhistory')->insert($object);
                            }
                        }

                            DB::table('epinrequest')->where('id',$decrypted)->update(['status'=>1]);
                            DB::table('withdrawfinal')->where('id',$result->refid)->update(['status'=>1]);

                        Session::flash('msgAdmin', $result->number . " E-Pins transferred successfully");
                    } else {
                        Session::flash('errorAdmin', $result->number . " E-Pins are not availiable");
                    }


                }





            } catch (Exception $e) {
                dd($e);
                Session::flash("errorAdmin","Unable to approove request !");
            }
            return redirect()->back();
    }

    function declineEpinRequest($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $request=DB::table('epinrequest')->find($decrypted);
            $del=DB::table('withdrawfinal')->where('id',$request->refid)->delete();
            if($del)
             {$upd=DB::table('epinrequest')->where('id',$decrypted)->update(['status'=>2]);
             if($upd)
             Session::flash("msgAdmin","Request declined successfully");
             else
             Session::flash("errorAdmin","Unable to decline request !");}
            else
            Session::flash("errorAdmin","Unable to decline request !");

        } catch (Exception $e) {
            Session::flash("errorAdmin","Unable to decline request !");
        }
        return redirect()->back();
    }

    /*E-Pin request section end */

    /*Manage amount start */
    function showManageAmount()
    {
            $arr['users']=DB::table('users')->get();
            $arr['record']=DB::select("select * from income where fromuser=?  or amount<0",['admin']);
            return view('admin.manageAmount',$arr);
    }

    function manageAmountApply(Request $request)
    {
        $this->validate($request,[
            'selectUser'=>'required|string',
            'amounttype'=>'required|string',
            'amount'=>'required|numeric'
        ]);
        try{
            $decrypted=Crypt::decrypt($request->selectUser);
            $user=DB::table('users')->find($decrypted);
            if($request->amounttype==0)
            {
                $remark="Amount Added by admin";
                $type="Add By Admin";
                $amount=$request->amount;
            }
            else if($request->amounttype==1)
            {
                $remark="Amount Deducted by admin";
                $type="Deduct By Admin";
                $amount=($request->amount)*-1;
            }
            else
            {
            Session::flash("errorAdmin","Invalid amount type!");
            }

            $wt['touser']=$user->ownid;
            $wt['fromuser']="Admin";
            $wt['incometype']=$remark;
            $wt['level']=0;
            $wt['amount']=$amount;
            $wt['remark']=$remark;
            $wt['created_at']=Carbon::now();
            $wt['plan']="By Admin";
            if(DB::table('income')->insert($wt))
            {
                    if($request->amounttype==0)
                    {
                        Session::flash("msgAdmin","Amount Added Successfully !");
                    }
                    else
                    {
                        Session::flash("msgAdmin","Amount deducted successfully !");
                    }
            }
            else
            {

            }

        }
        catch(Exception $e)
        {
            dd($e);
            Session::flash("errorAdmin","Unable to proceed !");
        }
return redirect()->back();


    }
    /*Manage amount end */
    /*Repurchase start*/

    function showRepurchase()
    {

        return view("admin.applyRepurchase");
    }

    function applyRepurchase(Request $request)
    {
        //send repurchase income
            $user=DB::table("users")->find($request->userid);

            if($user->isactive==0)
            {
                  Session::flash("errorAdmin","Unable to do repurchase, User Id is INACTIVE!");
                  return redirect()->back();
            }

                $amount=$request->amount;
                $narration=$request->narration;
                $self=$amount*0.10;


            $ownid= $user->ownid;

            $arr["userid"]=$request->userid;
            $arr["narration"]=$request->narration;
            $arr["amount"]=$request->amount;
            $arr["created_at"]=Carbon::now();
           $refid= DB::table("repurchase")->insertGetId($arr);





            //send to self
                                $levelIncome['fromuser'] = $user->ownid;
                                $levelIncome['touser'] = $user->ownid;
                                $levelIncome['incometype'] ="Repurchase";
                                $levelIncome['amount'] = $self;//fix for self;
                                $levelIncome['plan'] = $amount;
                                $levelIncome['level'] = 1;
                                $levelIncome['created_at'] = Carbon::now();
                                $levelIncome['refid'] = $refid;

                                DB::table('income')->insert($levelIncome);



            $iterate = $user->parentid;
            $k = 2;
            do {
                if ($iterate != '') {
                    $result = DB::select('select * from users where  ownid= ?', [$iterate]);
                    if (count($result) > 0) {
                        /*Set Level Start  */
                        $first = $result[0]->first;
                        $second = $result[0]->second;
                        $third = $result[0]->third;

                        /*Send level income start  */
                        if ($k <= 10) {

                             if($k==2)
                            {
                                $sendAmt=$amount*0.05;
                            }
                            else  if($k==3)
                            {
                                $sendAmt=$amount*0.04;
                            }
                            else  if($k==4)
                            {
                                $sendAmt=$amount*0.02;
                            }
                            else  if($k==5)
                            {
                                $sendAmt=$amount*0.015;
                            }
                            else  if($k==6)
                            {
                                $sendAmt=$amount*0.015;
                            }
                            else  if($k==7)
                            {
                                $sendAmt=$amount*0.01;
                            }
                            else  if($k==8)
                            {
                                $sendAmt=$amount*0.01;
                            }
                            else  if($k==9)
                            {
                                $sendAmt=$amount*0.005;
                            }
                             else  if($k==10)
                            {
                                $sendAmt=$amount*0.005;
                            }



                            if(userHelper::sendIncome($iterate,$ownid,'Repurchase income'.$amount))
                            {
                                //$iteratePlan = userHelper::getPlanDetails($result[0]->currentplan);
                                $levelIncome['fromuser'] = $ownid;
                                $levelIncome['touser'] = $iterate;
                                $levelIncome['incometype'] ="Repurchase";
                                $levelIncome['amount'] = $sendAmt;;
                                $levelIncome['plan'] = $amount;
                                $levelIncome['level'] = $k;
                                $levelIncome['created_at'] = Carbon::now();
                                $levelIncome['refid'] = $refid;
                                DB::table('income')->insert($levelIncome);
                                DB::update('update users set repincome=repincome+? where ownid=?', [$sendAmt, $iterate]);
                            }
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
              Session::flash('msgAdmin', "Repurchase applied  Successfully");
                        return redirect()->back();

    }
    /*repurchase end*/

    /*Package Start */
    public function packageRequest($type=0)
    {
        $arr["record"]=DB::select("select a.name,c.name as userName,b.*,c.mobile from plans as a join tradingpackage as b on a.id=b.planid join users as c on b.ownid=c.ownid where b.status=? order by b.status asc",[$type]);
        $arr["title"]=$type==0?"Pending requests":"Approved requests";
        return view("admin.packages",$arr);
    }
    public function deletePackage($id)
    {
        try
        {
            $id=Crypt::decrypt($id);
            $chk=DB::table("tradingpackage")->where("id",$id)->count();

            if($chk==0)
            {
                Session::flash("errorAdmin","Unable to delete please try after some time!");
            }
            else
            {
                $package=DB::table("tradingpackage")->find($id);
                if($package->status==1)
                {
                    Session::flash("errorAdmin","Unable to proceed, Package is applied.");
                }
                else
                {
                    $del=DB::table('tradingpackage')->where("id",$id)->delete();
                    if($del)
                    {
                        Session::flash("msgAdmin","Package deleted successfully.");
                    }
                    else
                    {
                        Session::flash("errorAdmin","Unable to delete please try after some time. !");
                    }
                }
            }
        }
        catch(Exception $e)
        {
            Session::flash("errorAdmin","Unable to delete please try after some time. !");
        }
        return redirect()->back();
    }
    public function activatePackage($id)
    {
        try
        {
            $id=Crypt::decrypt($id);
            $chk=DB::table("tradingpackage")->where("id",$id)->count();
            if($chk==0)
            {
                Session::flash("errorAdmin","Unable to activate package pleae try after some time ! ");
            }
            else
            {
                 $package=DB::table("tradingpackage")->find($id);
                 if($package->status==1)
                 {
                    Session::flash("errorAdmin","Unable to proceed , Package is already applied .");
                 }
                 else
                 {
                     //first activate the package
                     $upd=DB::table("tradingpackage")->where("id",$id)->update(["status"=>1]);
                     if($upd)
                     {
                         $user=DB::table("users")->where("ownid",$package->ownid)->get();

                         if(count($user)>0)
                         {
                            $user=$user[0];
                            $userPlan=userHelper::getPlanDetails($package->planid);
                            $sponsor=DB::table("users")->where("ownid",$user->sponsarid)->get();

                            if(true)
                            {


                                    $subject="Package Activated successsfully";
                                    $body='<h1>Package Activated</h1>
                                    <p>Congratulations your package of amount '.$userPlan->name.' is activated successfully. </p>
                                    <img src="https://teamblazesstaking.com/logo.png" />';
                                    userHelper::sendMail("info@teamblazesstaking.com",$user->email,$subject,$body);
                               


                                //activate the user
                                $userActivate["isactive"]=1;
                                $userActivate["currentplan"]=$package->planid;
                                $userActivate["activeon"]=Carbon::now();
                                $userActivate["rewarddate"]=Carbon::now();
                                DB::table("users")->where("ownid",$user->ownid)->update($userActivate);



                                //send personal roi
                                $appackage=$userPlan->name;
                                $roiPersonal["ownid"]=$user->ownid;
                                $roiPersonal["amountmax"]=$userPlan->roilimit;
                                $roiPersonal["type"]="ROI";
                                $roiPersonal['sent']=0;
                                $roiPersonal["fromid"]=$user->ownid;
                                $roiPersonal['planid'] =$package->planid;
                                $roiPersonal["created_at"]=Carbon::now();
                                $roiPersonal["remark"]="user personal ROI i.e. 200% of the applied  package $appackage";
                                DB::table("roi")->insert($roiPersonal);
                                
                                
                                //send level income
                                $ownid=$user->ownid;
                        $iterate = $user->sponsarid;
                        $k = 1;
                        do {
                            if ($iterate != '') {
                                $result = DB::select('select * from users where  ownid= ?', [$iterate]);
                                if (count($result) > 0) {
                                    /*Set Level Start  */

                                    /*Send level income start  */
                                    if ($k <= 9) {
                                        $lAmount = 0;
                                        $leadershipAmount=0;
                                        switch ($k) {
                                            case 1:
                                                $lAmount = 5;
                                                $leadershipAmount=0.25;
                                                break;
                                            case 2:
                                                $lAmount = 4;
                                                $leadershipAmount=0.10;
                                                break;
                                            case 3:
                                                $lAmount = 4;
                                                $leadershipAmount=0.05;
                                                break;
                                            case 4:
                                                $lAmount = 3;
                                                $leadershipAmount=0.02;
                                                break;
                                            case 5:
                                                $lAmount = 2;
                                                $leadershipAmount=0.02;
                                                break;
                                            case 6:
                                                $lAmount = 2;
                                                $leadershipAmount=0.02;
                                                break;
                                            case 7:
                                                $lAmount = 2;
                                                $leadershipAmount=0.02;
                                                break;
                                            case 8:
                                                $lAmount = 2;
                                                $leadershipAmount=0.02;
                                                break;
                                            case 9:
                                                $lAmount = 1;
                                                $leadershipAmount=0.02;
                                                break;
                                                

                                        }
                                        $fraction=$lAmount/100;
                                        $lAmount=$fraction*$userPlan->entryamount;
                                        
                                        if($k<3)
                                        {
                                            $bcheck=0;
                                        }
                                        else
                                        {
                                            $bcheck=600;
                                        }

                                        $directBusiness=DB::select("select ifnull(sum(a.entryamount),0) as amount from plans as a join users as b on a.id=b.currentplan where b.sponsarid=?",[$iterate]);
                                        if(count($directBusiness)>0)
                                        {
                                            $directBusiness=$directBusiness[0]->amount;
                                        }
                                        else
                                        {
                                            $directBusiness=0;
                                        }
                                        if ($result[0]->isactive==1  && $result[0]->currentplan>1  && ($bcheck==0 || ($bcheck>0 && $directBusiness>=$bcheck) ) && $lAmount>0) {
                                            $levelIncome['fromuser'] = $ownid;
                                            $levelIncome['touser'] = $iterate;
                                            $levelIncome['incometype'] = "Level";
                                            $levelIncome['amount'] = $lAmount;
                                            $levelIncome['plan'] = $userPlan->name;
                                            $levelIncome['level'] = $k;
                                            $levelIncome['created_at'] = Carbon::now();
                                            DB::table('income')->insert($levelIncome);
                                            DB::update('update users set levelincome=levelincome+? where ownid=?', [$lAmount, $iterate]);
                                            
                                            
                                            //get the direct business if greater then 1000 then send the leadership income
                                            try
                                            {
                                                 $roiAmount=round((($userPlan->roi/22)/100)*$userPlan->entryamount,2);
                                            $dBusiness=Db::select("select sum(a.entryamount) as amount FROM `plans` as a join tradingpackage as b on a.id=b.planid join users as c on b.ownid=c.ownid where c.sponsarid=?",[$iterate]);
                                            if(count($dBusiness)>0)
                                            {
                                                if($dBusiness[0]->amount>=1000)
                                                {
                                                    $leadershipIncome=$roiAmount*$leadershipAmount;
                                                    $lrIncome['fromuser'] = $ownid;
                                                    $lrIncome['touser'] = $iterate;
                                                    $lrIncome['incometype'] = "Leadership";
                                                    $lrIncome['amount'] = $leadershipIncome;
                                                    $lrIncome['plan'] = $userPlan->name;
                                                    $lrIncome['level'] = $k;
                                                    $lrIncome['created_at'] = Carbon::now();
                                                    DB::table('income')->insert($lrIncome);
                                                }
                                            }
                                            }
                                            catch(Exception $e)
                                            {
                                                
                                            }
                                            
                                            
                                            
                                            
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
                                




                            }
                         }
                         else
                         {
                             Session::flash("errorAdmin","Invalid User");
                             return redirect()->back();
                         }

                     }

                        Session::flash("msgAdmin","Account Activated Successfully !");
                 }
            }

        }
        catch(Exception $e)
        {
            Session::flash("errorAdmin","Unable to activate package pleae try after some time !");
        }
        return redirect()->back();
    }
    /*Package End  */
     /*Sale Package Start */
    public function salePackageRequest($type=0)
    {
        $arr["record"]=DB::select("select '$50' as name,c.name as userName,b.*,c.mobile from salepackage as b  join users as c on b.ownid=c.ownid where b.status=? order by b.status asc",[$type]);
        $arr["title"]=$type==0?"Pending requests":"Approved requests";
        return view("admin.salepackages",$arr);
    }
    public function deleteSalePackage($id)
    {
        try
        {
            $id=Crypt::decrypt($id);
            $chk=DB::table("salepackage")->where("id",$id)->count();

            if($chk==0)
            {
                Session::flash("errorAdmin","Unable to delete please try after some time!");
            }
            else
            {
                $package=DB::table("salepackage")->find($id);
                if($package->status==1)
                {
                    Session::flash("errorAdmin","Unable to proceed, Package is applied.");
                }
                else
                {
                    $del=DB::table('salepackage')->where("id",$id)->delete();
                    if($del)
                    {
                        Session::flash("msgAdmin","Package deleted successfully.");
                    }
                    else
                    {
                        Session::flash("errorAdmin","Unable to delete please try after some time. !");
                    }
                }
            }
        }
        catch(Exception $e)
        {
            Session::flash("errorAdmin","Unable to delete please try after some time. !");
        }
        return redirect()->back();
    }
    public function activateSalePackage($id)
    {
        try
        {
            $id=Crypt::decrypt($id);
            $chk=DB::table("salepackage")->where("id",$id)->count();
            if($chk==0)
            {
                Session::flash("errorAdmin","Unable to activate package pleae try after some time ! ");
            }
            else
            {
                 $package=DB::table("salepackage")->find($id);
                 if($package->status==1)
                 {
                    Session::flash("errorAdmin","Unable to proceed , Package is already applied .");
                 }
                 else
                 {
                     //first activate the package
                     $upd=DB::table("salepackage")->where("id",$id)->update(["status"=>1]);
                     if($upd)
                     {
                         
                        
                         }
                         else
                         {
                             Session::flash("errorAdmin","Invalid User");
                             return redirect()->back();
                         }

                     }

                        Session::flash("msgAdmin","Package Activated Successfully !");
                 }
            

        }
        catch(Exception $e)
        {
            Session::flash("errorAdmin","Unable to activate package pleae try after some time !");
        }
        return redirect()->back();
    }
    /*Sale Package End  */

    /* Withdraw Start */
    function showWithdrawApply()
    {

        return view('admin.withdrawApplied');
    }
    function showWithdrawApplyFinal($id,$status)
    {
          try
          {
              $id=Crypt::decrypt($id);
              $with=DB::table("withdrawrequests")->find($id);
              if($status==1)
              {
                  $arr["status"]=1;
                  $arr["approoved_at"]=Carbon::now();
                  
                  $subject="Withdraw Approoved";
                $body='<h1>Withdraw Approoved</h1>
                <p>Your withdraw of amount  '.$with->amount.' is approoved. </p>';
              }
              else
              {
                  $arr["status"]=2;
                  $arr["approoved_at"]=null;
                  
                $subject="Withdraw declined";
                $body='<h1>Withdraw declined</h1>
                <p>Your withdraw of amount  '.$with->amount.' is declined. </p>';

                  
                  DB::table("income")->where("touser",$with->ownid)->where("refid",$id)->delete();
              }
              $user=DB::table("users")->where('ownid',$with->ownid)->first();
             
                userHelper::sendMail("info@teamblazesstaking.com",$user->email,$subject,$body);
              
              Db::table("withdrawrequests")->where("id",$id)->update($arr);
              if($status==1)
               Session::flash("msgAdmin","Withdraw Applied Successfully");
              else
               Session::flash("errorAdmin","Withdraw declined Successfully");
              
          }
          catch(Exception $e)
          {
              dd($e);
              Session::flash("errorAdmin","Unable to apply withdraw please try after some time! ");
          }
            
             return redirect()->back();


    }
    function showClosingDetails($id)
    {
        $closing=DB::table("closingapplied")->find($id);

        $arr["roi"]=DB::Table("income")->whereDate("created_at",$closing->created_at)->where("incometype","ROI")->sum("amount");
        $arr["level"]=DB::Table("income")->whereDate("created_at",$closing->created_at)->where("incometype","Level")->sum("amount");
        $fromClosing=DB::table("closingapplied")->where("created_at","<",$closing->created_at)->orderby("id","desc")->first();
        if(empty($fromClosing))
         $from=$closing->created_at;
         else
        $from=$fromClosing->created_at;

          if(!empty($fromClosing))
        $arr["direct"]=DB::Table("income")->whereDate("created_at",'>',$from)->whereDate("created_at",'<=',$closing->created_at)->where("incometype","Direct")->sum("amount");//
        else
        $arr["direct"]=DB::Table("income")->whereDate("created_at",'<=',$closing->created_at)->whereDate("incometype","Direct")->sum("amount");

        $toDate=Carbon::parse($closing->created_at)->format("Y-m-d")." 00:00:00";


         if(!empty($fromClosing))
       {
           $arr["record"]=DB::select("select a.touser,sum(a.amount) as amount,(select sum(amount)*-1 from income where amount<0 and  cast(created_at  as date)>'$from' and cast(created_at  as date)<='$closing->created_at' and touser=a.touser ) as posted,b.kyc,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank from income as a join users as b on a.touser=b.ownid where amount>0 and cast(a.created_at as date)>? and cast(a.created_at as date)<=? and a.amount>0 group by a.touser,b.kyc,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank,posted",[$from,$toDate]);

       }
        else
          $arr["record"]=DB::select("select a.touser,sum(a.amount) as amount,(select sum(amount)*-1 from income where amount<0 and cast(a.created_at  as date)<='$closing->created_at' and touser=a.touser ) as posted,b.kyc,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank from income as a join users as b on a.touser=b.ownid where  amount>0 and cast(a.created_at as date)<=? and a.amount>0 group by a.touser,b.kyc,b.name,b.accountnumber,b.ifsc,b.branch,b.pannumber,b.bank,posted",[$toDate]);


        $arr["closing"]=$closing;
        return view("admin.closingDetails",$arr);


    }

     function getLevelPercent($level)
    {
        if($level==1)
        {
            return 20;
        }
        else if($level==2)
        {
            return 10;
        }
        else if($level==3)
        {
            return 5;
        }
        else if($level==4)
        {
            return 4;
        }
        else if($level==5)
        {
            return 3;
        }
        else if($level==6)
        {
            return 2;
        }
        else if($level==7)
        {
            return 1;
        }
        else if($level==8)
        {
            return 1;
        }
        else if($level==9)
        {
            return 1;
        }
        else if($level==10)
        {
            return 2;
        }
        else if($level==11)
        {
            return 1;
        }
        else if($level==12)
        {
            return 1;
        }
        else if($level==13)
        {
            return 1;
        }
        else if($level==14)
        {
            return 1;
        }
        else if($level==15)
        {
            return 2;
        }
    }
    /* Withdraw End */

    function deleteKyc($id)
    {
        $arr["kyc"]=0;
        $arr["bank"]="";
        $arr["ifsc"]="";
        $arr["branch"]="";
        $arr["accountnumber"]="";
        $arr["pannumber"]="";
        $arr["panimage"]="";
         $arr["adharimage"]="";
          $arr["adharbackimage"]="";
           $arr["passbookimage"]="";
           $arr["kycmobile"]="";
           $arr["kycname"]="";
           $arr["kycrelation"]="";
           $arr["kycage"]="";

        if(DB::table("users")->where("id",$id)->update($arr))
        {
             Session::flash("msgAdmin","KYC Deleted Successfully");
        }
        else
        {
             Session::flash("errorAdmin","Unable to delete KYC");
        }
        return redirect()->back();
    }
    function postClosing(Request $request)
    {

       $chkArr["touser"]=$request->touser;
       $chkArr["incometype"]="Posted";
       $chkArr["level"]=0;
       $chkArr["amount"]=$request->clamountactual*-1;
       $chkArr["created_at"]=$request->cldate;

        $chk=DB::table("income")->where($chkArr)->count();
        if($chk>0)
        {
            Session::flash("errorAdmin","Already posted");
             return redirect()->back();
        }
       $arr["fromuser"]="VM862560";
       $arr["touser"]=$request->touser;
       $arr["incometype"]="Posted";
       $arr["level"]=0;
       $arr["amount"]=$request->clamountactual*-1;
       $arr["created_at"]=$request->cldate;
       $arr["remark"]="Posted by Admin on date ".Carbon::now();
       $arr["plan"]="Closing Posted";
       if(DB::table("income")->insert($arr))
       {
            Session::flash("msgAdmin","Amount posted Successfully");
       }
       else
       {
            Session::flash("errorAdmin","Unable to post amount");
       }
       return redirect()->back();
    }
    function userPassword()
    {
        return view("admin.changeUserPassword");
    }

    function userPasswordUpdate(Request $request)
    {
        $this->validate($request,[
            "user"=>"required|string",
            "NewPassword"=>"required|string",
            "ConfirmPassword"=>"required|string"
            ]);
            if($request->NewPassword==$request->ConfirmPassword)
            {
                $arr["password"]=Hash::make($request->NewPassword);
                $arr["passwordcrypt"]=Crypt::encrypt($request->NewPassword);
                Db::table("users")->where("id",$request->user)->update($arr);
                Session::flash("msgAdmin","Password changed successfully");
            }
            else
            {
                Session::flash("errorAdmin","Passwords not matched");
            }

           return redirect()->back();
    }
    function showCompanyBusiness()
    {
        $arr["record"]= DB::select("select ifnull(sum(a.entryamount),0) as amount,cast(b.activeon as Date) as createdat from plans as a join users as b on a.id=b.currentplan  where  b.isactive=1 group by createdat order by   cast(createdat as Date) desc" );
                return view("admin.showCompanyBusiness",$arr);
    }
    function userLogin($id,$pass)
    {
       $credentials = [
        'ownid' => $id,
        'password' => $pass,
        ];
   
        // Dump data
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route("home");
        }


    }
    function showCompanyBusinessDetails($jdate)
    {
        $record=DB::select("select a.name,a.ownid,a.sponsarid,a.mobile,b.entryamount from users as a join plans as b on a.currentplan=b.id where a.isactive=1 and cast(activeon as date)=?",[$jdate]);
        $arr["record"]=$record;
        $arr["jdate"]=Carbon::parse($jdate)->format("d/M/Y");
        return view("admin.companyBusinessDetail",$arr);
    }
    function show_zoom_meeting(Request $rest)
    {
        if($rest->id)
        {
            $arr["meeting_id"]=$rest->id;
        }
        else{
            $arr["meeting_id"]=null;
        }
        $arr['zoom_meeting']=DB::select('select * from zoom_meeting');
        return view('admin.zoom_meeting',$arr);
    }
    public function add_zoom_meeting(Request $rest)
    {
        $this->validate($rest, [
            'title' => 'required|string',
            'meeting_id' => 'required',

        ]);

        $array['title'] = $rest->title;
        $array['description'] = $rest->description;
        $array['topic'] = $rest->topic;
        $array['time'] = Carbon::parse($rest->time)->format('Y/m/d  H:i:s');
        $array['passcode'] = $rest->passcode;
        $array['meeting_id'] = $rest->meeting_id;
        $array['link'] = $rest->link;
        $array['created_at'] =Carbon::now();
        if($rest->id==''){
            $ins=DB::table('zoom_meeting')->insert($array);
        }
        else{
            $ins = DB::table('zoom_meeting')->where('id', $rest->id)->update($array);
        }

        if ($ins) {
            if ($rest->id=='') {
                session()->flash('msgAdmin', 'Zoom Meeting Added Successfully.');
            }
            else{
                session()->flash('msgAdmin', 'Zoom Meeting Updated Successfully.');
            }
            return redirect()->route('admin.zoom_meeting.show');
        } else {
            if ($rest->id=='') {
                session()->flash('errorAdmin', 'Unable to add try after some time .');
            }
            else{
                session()->flash('errorAdmin', 'Unable to update try after some time .');
            }
            return redirect()->route('admin.zoom_meeting.show');
        }
    }
    public function delete_zoom_meeting($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $del = DB::delete('delete from zoom_meeting where id=?', [$decrypted]);
            if ($del) {
                session()->flash('msgAdmin', 'Zoom Meeting Deleted Successfully.');
            } else {
                session()->flash('msgAdmin', 'Unable to delete, try after some time ');
            }
            return redirect()->route('admin.zoom_meeting.show');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errorAdmin' => 'Unauthenticated Access']);
        }
    }
    public function show_video()
    {
        $arr['video']=DB::select('select * from video');
        return view('admin.video',$arr);
    }
    public function add_video(Request $rest)
    {
        $this->validate($rest, [
            'title' => 'required',
            'video' => 'required',

        ]);

        $array['title'] = $rest->title;
        $array['video'] = $rest->video;
        $array['created_at'] =Carbon::now();
        $ins=DB::table('video')->insert($array);
        if ($ins) {
            session()->flash('msgAdmin', 'Zoom Meeting Added Successfully.');
        }
        else{
            session()->flash('errorAdmin', 'Unable to add try after some time .');
        }
        return redirect()->route('admin.video');

    }
    public function delete_video($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $del = DB::delete('delete from video where id=?', [$decrypted]);
            if ($del) {
                session()->flash('msgAdmin', 'Video Deleted Successfully.');
            } else {
                session()->flash('errorAdmin', 'Unable to delete, try after some time ');
            }
            return redirect()->route('admin.video');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errorAdmin' => 'Unauthenticated Access']);
        }
    }
    public function show_slider()
    {
       $arr['all_slider']=DB::select('select * from slider');
       return view('admin.slider',$arr);
    }
    public function add_slider(Request $rest)
    {

        $this->validate($rest, [
            'image' => 'required|image',

        ]);
        $imageName = time().'.'.$rest->image->extension();
        $rest->image->move(public_path('Slider'), $imageName);
        $array['image'] = $imageName;
        $array['description'] = $rest->description;
        $array['created_at'] =Carbon::now();
        $ins=DB::table('slider')->insert($array);
        if ($ins) {
            session()->flash('msgAdmin', 'Slider Added Successfully.');
        }
        else{
            session()->flash('msgAdmin', 'Unable to add try after some time .');
        }
        return redirect()->route('admin.slider');

    }
    public function delete_slider($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $del = DB::delete('delete from slider where id=?', [$decrypted]);
            if ($del) {
                session()->flash('msgAdmin', 'Slider Deleted Successfully.');
            } else {
                session()->flash('errorAdmin', 'Unable to delete, try after some time ');
            }
            return redirect()->route('admin.slider');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errorAdmin' => 'Unauthenticated Access']);
        }
    }
    public function showFirmDetails()
    {
        $arr["record"]=DB::table("admins")->find(1);
        return view("admin.firmdetails",$arr);
    }
    public function updateFirmDetails(Request $request)
    {
        $this->validate($request,[
            "news"=>"required|string",
            "usd"=>"required|string",
            "trx"=>"required|string",
            "telegram"=>"required|string",
            "name"=>"required|string",
            "dailytip"=>'requried|string'
            ]);
            
            $arr["news"]=$request->news;
            $arr["usd"]=$request->usd;
            $arr["trx"]=$request->trx;
            $arr["telegram"]=$request->telegram;
            $arr["name"]=$request->name;
            $arr["dailytip"]=$request->dailytip;
            Db::table("admins")->update($arr);
             session()->flash('msgAdmin', 'Details updated Successfully.');
            return redirect()->back();
    }
}
