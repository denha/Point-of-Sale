<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\stocks;
use App\stocktrans;
use App\purchaseheaders;
use App\stockbals;
use App\accounttrans;

 class stockbalancesController extends Controller{
    public function stockbalance(Request $request){
        DB::beginTransaction();
        try{
        
       $orginalnumber=0;
        $amount=str_replace(',','',$request['amount']);
        $headno=$request['headno'];
        $stkbal= new purchaseheaders();
        $stkbal->transdates=$request['dates'];
        $stkbal->customer_id=$request['customerid'];
        $stkbal->save();
        // save into stockstrans

        $stocktrans=new stocktrans();
        $stocktrans->totalpaid=str_replace(',','',$request['amount']);
        $stocktrans->totaldue=str_replace(',','',$request['amount'])*-1;
        $stocktrans->purchaseheaderid=$request['headno'];
        $stocktrans->stockname=$request['stockid'];
        $stocktrans->transdate=$request['dates'];
        $stocktrans->save();

        $bal= new stockbals();
        DB::update("update stockbals set balance=balance-$amount where headno=$headno");
        DB::update("update accounttrans set credit='' where purchaseheaderid=$headno");

        
        //Inserting into accounts trans for literally reducing accounts recievables
        $accounts= new accounttrans();
        $accounts->accountcode="1111";
        $accounts->ttype="C";
        $accounts->narration="Payment of Balance on ".$request['itemcode'];
        $accounts->purchaseheaderid=$request['headno'];
        $accounts->amount=str_replace(',','',$request['amount']);
        $accounts->save();
       //Posting into any Recieving account
       $accountnumber=DB::select("select accountcode from chartofaccounts where isDefault=1 && isInventory=1");
       foreach($accountnumber as $acno){
           $orginalnumber=$acno->accountcode;
 }
        $accounts= new accounttrans();
        $accounts->accountcode=$orginalnumber;
        $accounts->ttype="D";
        $accounts->narration="Payment of Balance on ".$request['itemcode'];
        $accounts->purchaseheaderid=$request['headno'];
        $accounts->amount=str_replace(',','',$request['amount']);
        $accounts->save();

    }catch(\Exception $e){
        DB::rollback();
        return  json_encode(array('isError'=>true,'Error'=>'Record Not Deleted, Please Delete  it again'));  
    }
    
    DB::commit();


    }
// Pending Purchases
public function pendingpayments(Request $request){
    DB::beginTransaction();
    try{
    $orginalnumber=0;
    $amount=str_replace(',','',$request['amount']);
    $headno=$request['headno'];
    $stkbal= new purchaseheaders();
    $stkbal->transdates=$request['dates'];
    $stkbal->supplier_id=$request['customerid'];
    $stkbal->save();
    // save into stockstrans

    $stocktrans=new stocktrans();
    $stocktrans->totalpaid=str_replace(',','',$request['amount']);
    $stocktrans->totaldue=str_replace(',','',$request['amount'])*-1;
    $stocktrans->purchaseheaderid=$request['headno'];
    $stocktrans->stockname=$request['stockid'];
    $stocktrans->transdate=$request['dates'];
    $stocktrans->save();

    $bal= new stockbals();
    DB::update("update stockbals set balance=balance-$amount where headno=$headno");
    DB::update("update accounttrans set credit='' where purchaseheaderid=$headno");

    
    //Inserting into accounts trans for literally reducing accounts Payable
    $accounts= new accounttrans();
    $accounts->accountcode="1112";
    $accounts->ttype="D";
    $accounts->narration="Payment of Balance on ".$request['itemcode'];
    $accounts->purchaseheaderid=$request['headno'];
    $accounts->amount=str_replace(',','',$request['amount']);
    $accounts->save();
   //Posting into any Recieving account
   $accountnumber=DB::select("select accountcode from chartofaccounts where isDefault=1 && isInventory=1");
   foreach($accountnumber as $acno){
       $orginalnumber=$acno->accountcode;
}
    $accounts= new accounttrans();
    $accounts->accountcode=$orginalnumber;
    $accounts->ttype="C";
    $accounts->narration="Payment of Balance on ".$request['itemcode'];
    $accounts->purchaseheaderid=$request['headno'];
    $accounts->amount=str_replace(',','',$request['amount']);
    $accounts->save();
}catch(\Exception $e){
    DB::rollback();
    return  json_encode(array('isError'=>true,'Error'=>'Record Not Deleted, Please Delete  it again'));  
}

DB::commit();



}


}