<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\customers;

 class notificationsController extends Controller{

public function notifications(){
    return view('notifications/index');
}
public function viewnotifications(){

    return DB::select("select DATE_FORMAT(transdate,'%d-%m-%Y') as transdat, customers.id as custoid,name as customer,DATE_ADD(transdate, INTERVAL 14 DAY), purchaseheaderid,sum(totalamt) totalamt, format(sum(totalamt)-sum(totalpaid),0) as bal, sum(totalpaid) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer where DATE_ADD(transdate, INTERVAL 14 DAY)<=curdate()  group by purchaseheaderid having totalpaid<totalamt");
}
}