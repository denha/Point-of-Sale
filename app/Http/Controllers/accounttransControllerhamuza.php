<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\accounttrans;

 class accounttransController extends Controller{

public function index(){
    return view('accounttrans/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from accounttrans ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from accounttrans limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objaccounttrans=new accounttrans();
$Objaccounttrans->id=$request['id'];
$Objaccounttrans->accountcode=$request['accountcode'];
$Objaccounttrans->narration=$request['narration'];
$Objaccounttrans->amount=$request['amount'];
$Objaccounttrans->ttype=$request['ttype'];
$Objaccounttrans->purchaseheaderid=$request['purchaseheaderid'];
$Objaccounttrans->created_at=$request['created_at'];
$Objaccounttrans->updated_at=$request['updated_at'];
$Objaccounttrans->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objaccounttrans=accounttrans::find($id);

$Objaccounttrans->id=$request['id'];
$Objaccounttrans->accountcode=$request['accountcode'];
$Objaccounttrans->narration=$request['narration'];
$Objaccounttrans->amount=$request['amount'];
$Objaccounttrans->ttype=$request['ttype'];
$Objaccounttrans->purchaseheaderid=$request['purchaseheaderid'];
$Objaccounttrans->created_at=$request['created_at'];
$Objaccounttrans->updated_at=$request['updated_at'];
$Objaccounttrans->save();
}
 public function destroy($id){
        $Objaccounttrans=accounttrans::find($id);
        $Objaccounttrans->delete();



    }

public function viewcombo(){


    return accounttrans::all();
}

public function viewexpenses(){

    return view('expenses/index');
}

public function saveexpenses(Request $request){
    $objexpenses= new accounttrans();
    $objexpensesc= new accounttrans();
    $objexpenses->accountcode=$request['accountcode'];
    $objexpenses->narration=$request['narration'];
    $objexpenses->amount=$request['amount'];
    $objexpenses->ttype="D";
    $objexpenses->transdate=date("Y-m-d", strtotime($request['date']));
    $objexpenses->purchaseheaderid=$request['purchaseno'];
    $objexpenses->save();
    $objexpensesc->purchaseheaderid=$request['purchaseno'];
    $objexpensesc->amount=$request['amount'];
    $objexpensesc->narration=$request['narration'];
    $objexpensesc->accountcode=$request['payingaccount'];
    $objexpensesc->transdate=date("Y-m-d", strtotime($request['date']));
    $objexpensesc->ttype="C";
    $objexpensesc->save();
$lastid=DB::table('accounttrans')->orderBy('id','DESC')->first();
    echo json_encode(array(
        'narration' => $request['narration'],
        'amount' => $request['amount'],
        'accountcode' => $request['accountcode'],
        'Aid'=>$request['purchaseno'],
        'accounttransid'=>$lastid->id-1,
    ));


}
public function saveotherincomes(Request $request){
    $objexpenses= new accounttrans();
    $objexpensesc= new accounttrans();
    $objexpenses->accountcode=$request['accountcode'];
    $objexpenses->narration=$request['narration'];
    $objexpenses->amount=$request['amount'];
    $objexpenses->ttype="C";
    $objexpenses->transdate=date("Y-m-d", strtotime($request['date']));
    $objexpenses->purchaseheaderid=$request['purchaseno'];
    $objexpenses->save();
    $objexpensesc->purchaseheaderid=$request['purchaseno'];
    $objexpensesc->amount=$request['amount'];
    $objexpensesc->narration=$request['narration'];
    $objexpensesc->accountcode=$request['payingaccount'];
    $objexpensesc->transdate=date("Y-m-d", strtotime($request['date']));
    $objexpensesc->ttype="D";
    $objexpensesc->save();


}
public function viewotherincomes(){
return view('otherincomes/index');

}
public function viewtrans($id,$ttype){
    return DB::select("select accounttrans.accountcode,narration,ttype,amount,accountname from accounttrans inner join chartofaccounts on accounttrans.accountcode=chartofaccounts.accountcode where purchaseheaderid=$id AND ttype='$ttype'");


}
public function updatebranch(Request $request){
    $payingaccount=$request['payingaccount'];
    $pno=$request['pno'];
    DB::update("update accounttrans set accountcode= $payingaccount  where purchaseheaderid=$pno AND ttype='C'");

}
public function updatebranch1(Request $request){
    $payingaccount=$request['payingaccount'];
    $pno=$request['pno'];
    DB::update("update accounttrans set accountcode= $payingaccount  where purchaseheaderid=$pno AND ttype='D'");

}

public function editexpenses($id){

    return DB::select("select accounttrans.id,accounttrans.accountcode,chartofaccounts.accountname,narration,amount from accounttrans inner join chartofaccounts on accounttrans.accountcode=chartofaccounts.accountcode inner join accounttypes on accounttypes.id=chartofaccounts.accounttype where accounttypes.id=7 and accounttrans.purchaseheaderid=$id");
}

public function viewincomes($id){
    return DB::select("select accounttrans.id,accounttrans.accountcode,chartofaccounts.accountname,narration,amount from accounttrans inner join chartofaccounts on accounttrans.accountcode=chartofaccounts.accountcode inner join accounttypes on accounttypes.id=chartofaccounts.accounttype where accounttypes.id=6 and accounttrans.purchaseheaderid=$id");
}

public function expenseedit(Request $request ){
    $id=$request['accounttransid'];
        //Expense Account
    accounttrans::where('id','=',$id)->where('ttype','=','D')->update(['amount'=>$request['amount'],'narration'=>$request['narration'],'accountcode'=>$request['accountcode']]);//->update(['narration'=>$request['naration']]);
    // Crediting Cash Account
    accounttrans::where('id','=',$id+1)->where('ttype','=','C')->update(['amount'=>$request['amount'],'narration'=>$request['narration'],'accountcode'=>$request['payingaccount']]);//->update(['narration'=>$request['naration']]);
/*
    $objexpenses= new accounttrans();
    $objexpensesc= new accounttrans();
    $objexpenses->accountcode=$request['accountcode'];
    $objexpenses->narration=$request['narration'];
    $objexpenses->amount=$request['amount'];
    $objexpenses->ttype="D";
    $objexpenses->transdate=date("Y-m-d", strtotime($request['date']));
    $objexpenses->purchaseheaderid=$request['purchaseno'];
    $objexpenses->save();
    $objexpensesc->purchaseheaderid=$request['purchaseno'];
    $objexpensesc->amount=$request['amount'];
    $objexpensesc->narration=$request['narration'];
    $objexpensesc->accountcode=$request['payingaccount'];
    $objexpensesc->transdate=date("Y-m-d", strtotime($request['date']));
    $objexpensesc->ttype="C";
    $objexpensesc->save();*/

}
}