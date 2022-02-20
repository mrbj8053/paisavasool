<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use userHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {



        $ownid=Auth::user()->ownid;
        if($this->checkFilter())
        {
            $from =Session::get('userfrom').' 00:00:00';
            $to =Session::get('userto').' 23:59:59';
            $arr['epinUsed']=DB::select('select a.*,b.epin,b.applied_at from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=1 and b.applied_at>=? and b.applied_at<=?',[$ownid,$ownid,$from,$to]);
            $arr['direct']=DB::table('users')->where('sponsarid',$ownid)->where('created_at','>=',$from)->where('created_at','<=',$to)->count();
            $arr['directactive']=DB::table('users')->where('sponsarid',$ownid)->where("isactive",1)->where('created_at','>=',$from)->where('created_at','<=',$to)->count();
            $arr['directincome']=userHelper::getIncome("Direct",Auth::user()->ownid,$from,$to,true);
            $arr['levelincome']=userHelper::getIncome("Level",Auth::user()->ownid,$from,$to,true);
            $arr['roiincome']=userHelper::getIncome("ROI",Auth::user()->ownid,$from,$to,true);
            $arr['withdraw']=userHelper::getWithdraws(Auth::user()->ownid,$from,$to,true);

        }
        else
        {
            $arr['epinUsed']=DB::select('select a.*,b.epin,b.applied_at from epinhistory as a join epin as b on b.id=a.pinid where a.touser=? and a.pinid not in(select pinid from epinhistory where fromuser=?) and b.status=1',[$ownid,$ownid]);
            $arr['direct']=DB::table('users')->where('sponsarid',$ownid)->count();
            $arr['directactive']=DB::table('users')->where('sponsarid',$ownid)->where("isactive",1)->count();
            $arr['directincome']=userHelper::getIncome("Direct",Auth::user()->ownid,"none","none",true);
            $arr['levelincome']=userHelper::getIncome("Level",Auth::user()->ownid,"none","none",true);
            $arr['roiincome']=userHelper::getIncome("ROI",Auth::user()->ownid,"none","none",true);
            $arr['withdraw']=userHelper::getWithdraws(Auth::user()->ownid,"none","none",true);
           
           

        }
        $arr['epins']=DB::table('epinrecord')->where('touser',$ownid)->sum('count');
         $arr["package"]=userHelper::getPlanDetails(Auth::user()->currentplan);
        $arr['epinPending']=DB::select('select a.pinid,b.epin,b.planid,sum(type) from (select 1 as type ,pinid from epinhistory where touser=?
UNION ALL
select -1 as type ,pinid from epinhistory where fromuser=?
    ) as a  join epin as b on b.id=a.pinid   where  b.status=0 GROUP by a.pinid,b.epin,b.planid HAVING SUM(type)>0',[$ownid,$ownid]);
        $arr['epinTransferred']=DB::table('epinrecord')->where('fromuser',$ownid)->sum('count');
        $arr["totalTeam"]=DB::table("levelmembers")->where("ownid",Auth::user()->ownid)->count();
        $arr["totalIncome"]=DB::table("income")->where("touser",Auth::user()->ownid)->where("amount",">",0)->sum("amount");
        $arr["todayIncome"]=DB::table("income")->where("touser",Auth::user()->ownid)->where("amount",">",0)->whereDate('created_at', Carbon::today())->sum("amount");
        $arr["totalActiveTeam"]=DB::table("users as  a")->join("levelmembers  as b","a.ownid",'=','b.child')->where("b.ownid",Auth::user()->ownid)->where("isactive",1)->count();
        $teamCount=DB::table("users")->where("id",">",Auth::user()->id)->where("isactive",1)->count();
                            $level=0;
                          
        $arr["mylevel"]=$level;
        $arr["netIncome"]=DB::table("income")->where("touser",Auth::user()->ownid)->sum("amount");
        $arr["totalUsers"]=Db::Table("users")->count();
        $arr["activeUsers"]=Db::Table("users")->where("isactive",1)->count();
         $arr["mybusiness"]= DB::select("select ifnull(sum(a.entryamount),0) as amount from plans as a join users as b on a.id=b.currentplan join levelmembers as c on b.ownid=c.child where c.ownid=? and b.isactive=1",[Auth::user()->ownid])[0]->amount;
        return view('user.home',$arr);
    }

    public function checkFilter()
    {
        if(Session::has('userfrom')&& Session::has('userto'))
            return true;
        else
            return false;
    }
}
