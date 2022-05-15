<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\bankings;
use App\chartofaccounts;
use App\accounttrans;
use App\purchaseheaders;

 class bankingsController extends Controller{

public function index(){
    return view('bankings/index');
}
public function view(){
    if(isset($_GET['page'])&& isset($_GET['rows'])  && empty($_GET['date1']) && empty($_GET['date2']) && empty($_GET['branchid']) ){
        $today=date("'Y-m-d'");
        $this->bankdeposits("date=$today");
     }
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && empty($_GET['date2']) && empty($_GET['branchid']) ){
        if(auth()->user()->admin==1){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $this->bankdeposits("date <='$date1'");
    }

     }
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && empty($_GET['branchid']) ){
        if(auth()->user()->admin==1){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $this->bankdeposits("date BETWEEN '$date1' AND '$date2' ");
        }

     }
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && empty($_GET['date1']) && empty($_GET['date2'])&& !empty($_GET['branchid']) ){
        if(auth()->user()->admin==1){
        $today=date("'Y-m-d'");
        $branch=$_GET['branchid'];
        $this->bankdeposits("date=$today AND bankid=$branch");
        }
     }
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && empty($_GET['date2']) && !empty($_GET['branchid']) ){
        if(auth()->user()->admin==1){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $branch=$_GET['branchid'];
        $this->bankdeposits("date <='$date1' and bankid=$branch");
        }

     }
     else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && empty($_GET['branchid']) ){
        if(auth()->user()->admin==1){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $branch=$_GET['branchid'];
        $this->bankdeposits("date BETWEEN '$date1' AND '$date2' AND bankid=$branch ");
        }

     }



    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
        // Generationg Purchase header numbers;
$purchaseheaders= new purchaseheaders();
$purchaseheaders->transdates=date("Y-m-d", strtotime($request['date']));
$purchaseheaders->isActive=1;
$purchaseheaders->save();
    $Objbankings=new bankings();
//$Objbankings->id=$request['id'];
$Objbankings->date=date("Y-m-d", strtotime($request['date']));
$Objbankings->amount=str_replace( ',', '',$request['amount']);
$Objbankings->paymentdetail=$request['paymentdetail'];
$Objbankings->bankid=$request['bankid'];
$Objbankings->branchno=auth()->user()->branchid;
$Objbankings->headerno=$purchaseheaders->id;
$Objbankings->save();

// Account Trans 
$objexpenses= new accounttrans();
$objexpenses->accountcode="3600";
$objexpenses->narration="Cash Deposit";
$objexpenses->amount=str_replace( ',', '',$request['amount']);
$objexpenses->total=str_replace( ',', '',$request['amount'])*-1;
$objexpenses->ttype="C";
$objexpenses->transdate=date("Y-m-d", strtotime($request['date']));
$objexpenses->purchaseheaderid=$purchaseheaders->id;
$objexpenses->bracid=auth()->user()->branchid;
$objexpenses->save();
// Account Debit 
$objexpenses= new accounttrans();
$objexpenses->accountcode=$request['bankid'];
$objexpenses->narration="Cash Deposit";
$objexpenses->amount=str_replace( ',', '',$request['amount']);
$objexpenses->total=str_replace( ',', '',$request['amount']);
$objexpenses->ttype="D";
$objexpenses->transdate=date("Y-m-d", strtotime($request['date']));
$objexpenses->purchaseheaderid=$purchaseheaders->id;
$objexpenses->bracid=auth()->user()->branchid;
$objexpenses->save();
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();

    }
    DB::commit();
}
//Auto generated code for updating
public function update(Request $request,$id){
    DB::beginTransaction();
    try{
        $Objbankings=bankings::find($id);
//$Objbankings->id=$request['id'];
$Objbankings->date=date("Y-m-d", strtotime($request['date']));
$Objbankings->amount=str_replace( ',', '',$request['amount']);
$Objbankings->paymentdetail=$request['paymentdetail'];
$Objbankings->bankid=$request['bankid'];
$Objbankings->branchno=auth()->user()->branchid;
$Objbankings->save();
// Generationg Purchase header numbers;
$purchaseheaders=  purchaseheaders::find($request['headerno']);
$purchaseheaders->transdates=date("Y-m-d", strtotime($request['date']));
$purchaseheaders->isActive=1;
$purchaseheaders->save();
// Account Trans 
accounttrans::where('accountcode','=',3600)->where('purchaseheaderid','=',$request['headerno'])->update([
'amount'=>str_replace( ',', '',$request['amount']),
'total'=>str_replace( ',', '',$request['amount'])*-1,
'transdate'=>date("Y-m-d", strtotime($request['date'])),
]);

// Account Debit 
accounttrans::where('accountcode','=',$request['bankid'])->where('purchaseheaderid','=',$request['headerno'])->update([
    'amount'=>str_replace( ',', '',$request['amount']),
    'total'=>str_replace( ',', '',$request['amount']),
    'transdate'=>date("Y-m-d", strtotime($request['date'])),
    ]);
    }catch(\Exception $e){
    echo "Failed ".$e;
    DB::rollBack();
}
DB::commit();
}
 public function destroy($id){
     DB::beginTransaction();
     try{
        $Objbankings=bankings::find($id);
        purchaseheaders::where('id','=',$Objbankings->headerno)->delete();
        accounttrans::where("purchaseheaderid","=",$Objbankings->headerno)->delete();
        $Objbankings->delete();
     }catch(\Exception $e){
         echo "Failed ".$e;
         DB::rollBack();
        
     }

DB::commit();

    }

public function viewcombo(){


    return bankings::all();
}
public function bankaccounts(){
    return DB::select("select * from chartofaccounts where accountcode=2312 or accountcode=2314  ");
}

public function bankdeposits($where){
    $branch= auth()->user()->branchid;
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select COUNT(*) as count  from bankings inner join chartofaccounts on chartofaccounts.accountcode=bankings.bankid where bankings.branchno=$branch  and $where ");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("select headerno, bankid,bankings.id,accountname,paymentdetail, DATE_FORMAT(date,'%d-%m-%Y') date,format(amount,0) amount from bankings inner join chartofaccounts on chartofaccounts.accountcode=bankings.bankid where bankings.branchno=$branch and $where  limit $offset,$rows");
    $rst->execute();

    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   echo json_encode($results);  
}
}