<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 class dashboardsController extends Controller{

public function index(){
    $today=date("'Y/m/d'");
   $totalsales= DB::select("select format(if(sum(totalpaid)is Null,0,sum(totalpaid)),0) as totalamt,sum(totalpaid) as totalpaid ,if(sum(totaldue)<0,0,sum(totaldue)) as totaldue  from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname where transdate=$today And stocktrans.type='O'");

    return view('dashboard/index')->with('credit',$this->Accountrec())->with('company',$this->logo())->with('leastDemandPdt',$this->leastDemandPdt())->with('topDemandPdt',$this->topDemandPdt())->with('instock',$this->instock())->with('allitems',$this->allitems())->with('outofstock',$this->outofstock())->with('stockvalue',$this->stockvalue())->with('cashathand',$this->cashathand())->with('totalsales',$totalsales)->with('totalincome',$this->totalincome())->with('totalexpenses',$this->totalexpenses())->with('outstanding',$this->totaloutstanding());

}

public function totalincome(){
    $today=date("'Y/m/d'");
    //DB::statement("drop view incstat");
    DB::statement("create or replace view incstat as select ttype,amount,credit,chartofaccounts.accountname,chartofaccounts.accounttype,chartofaccounts.accountcode,accounttypes.accounttype as type,transdates from accounttrans inner join chartofaccounts on accounttrans.accountcode=chartofaccounts.accountcode inner join accounttypes on chartofaccounts.accounttype=accounttypes.id inner join purchaseheaders on purchaseheaders.id=accounttrans.purchaseheaderid  where chartofaccounts.accounttype=6  OR chartofaccounts.accounttype=7 ");
    //DB::statement("drop view totalincome");
    DB::statement("create or replace view totalincome as select * from incstat where transdates=$today  AND credit is Null  OR credit =''");
    $footer=DB::select("select format(if(sum(if(accounttype=6,amount,0))-sum(if(accounttype=7,amount,0)) is Null,0,sum(if(accounttype=6,amount,0))-sum(if(accounttype=7,amount,0))),0) as accountname from totalincome");
    return $footer;
    
}

public function totalexpenses(){
    $today=date("'Y/m/d'");
    return DB::select("select format(if(sum(if(ttype='D',amount,'')) is Null,0,sum(if(ttype='D',amount,''))),0)as amount from accounttrans INNER join purchaseheaders on accounttrans.purchaseheaderid=purchaseheaders.id inner join chartofaccounts on chartofaccounts.accountcode=accounttrans.accountcode inner join accounttypes on accounttypes.id=chartofaccounts.accounttype
    where transdates= $today AND chartofaccounts.accountcode!=1001  AND accounttypes.id=7 AND ttype='D' AND credit is Null");



}

public function totaloutstanding(){
    $today=date("'Y/m/d'");
    return DB::select("select format(if(sum(totalamt) is Null,0,sum(totalamt)),0) as totalamt,sum(totalpaid) as totalpaid ,if(if(sum(totaldue)<0,0,sum(totaldue)) is Null,0,if(sum(totaldue)<0,0,sum(totaldue))) as totaldue  from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join customers on customers.id=purchaseheaders.customer_id inner join stockbals on purchaseheaders.id=stockbals.headno where  transdates=$today  AND balance!=0 ");
}
public function cashathand(){
$stockval=DB::select("select * from financialyears where status=1");
foreach($stockval as $vall){
    $today=date("'Y/m/d'");
$start=$vall->startperiod;
$end=$vall->endperiod;
    $today=date("'Y/m/d'");
    return DB::select("select if(sum(Debit) is Null,0,format(sum(Debit),0))  as amount from bsheetpdfs  where accountcode=3600 and transdates Between '$start' AND '$end' ");
}
}
public function Accountrec(){

$stockval=DB::select("select * from financialyears where status=1");
foreach($stockval as $vall){
    $today=date("'Y/m/d'");
$start=$vall->startperiod;
$end=$vall->endperiod;
    return DB::select("select if(sum(Debit) is Null,0,format(sum(Debit),0))  as amount from bsheetpdfs  where accountcode=1111 and transdates Between '$start' AND '$end' ");
}
}
public function stockvalue(){
$stockval=DB::select("select * from financialyears where status=1");
foreach($stockval as $vall){
    $today=date("'Y/m/d'");
$start=$vall->startperiod;
$end=$vall->endperiod;
    return DB::select("select if(sum(Debit) is Null,0,format(sum(Debit),0))  as amount from bsheetpdfs  where accountcode=1113 and transdates Between '$start' AND '$end' ");
}
}
public function outofstock(){
    return DB::select("select sum(stock) as stock from outofstock");
}
public function allitems(){
    return DB::select("select count(*) as items from stocks");
}
public function instock(){
    return DB::select("select sum(if(stock<1,1,0)) as instock from outofstock");
}
public function topDemandPdt(){
    return DB::select("SELECT count(name)as counts, name FROM `stocktrans` inner join stocks on stocks.id=stocktrans.stockname where type='O' group by stockname  order by count(name) desc limit 5");
}
public function leastDemandPdt(){
    return DB::select("SELECT count(name)as counts, name FROM `stocktrans` inner join stocks on stocks.id=stocktrans.stockname where type='O' group by stockname  order by count(name) asc limit 5");
}
public function logo(){
    return DB::select("select logo from companys");
}
}
