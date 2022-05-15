<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\stocks;
use App\stocktrans;
use App\transfers;
 class stocktransfersController extends Controller{

public function index(){

    return view('stocktransfers/index');
}

public function viewtransfers($id){
   return  DB::select("select stocktrans.id,stockname,description,name as stockid,stocks.sellingrate,quantity from stocktrans inner join stocks on stocks.id=stocktrans.stockname where type='OT' and  purchaseheaderid=$id");
    
}

public function stocktransferedit(Request $request){
  // return  $this->getstockid($request['from'],$request['stockid']);
    // Removing form the first branch
    if($request['types']==1){
        stocktrans::where('id','=',$request['id'])->update(['stockname'=>$this->getstockid($request['from'],$request['stockid']),'quantity'=>$request['quantity']*$request['number']]);
    }else{
        stocktrans::where('id','=',$request['id'])->update(['stockname'=>$this->getstockid($request['from'],$request['stockid']),'quantity'=>$request['quantity']]);
    }
    
    //saving to the second branch
    if($request['types']==1){
        stocktrans::where('id','=',$request['id']+1)->update(['stockname'=>$this->getstockid($request['to'],$request['stockid']),'quantity'=>$request['quantity']*$request['number']]);
    }else{
        stocktrans::where('id','=',$request['id']+1)->update(['stockname'=>$this->getstockid($request['to'],$request['stockid']),'quantity'=>$request['quantity']]);
    }
   
}

public function getstockid($branch,$stockcode){
    $stockID=0;
    $results= DB::select("select id from stocks where branch_id=$branch AND stockcode='$stockcode'");
    foreach($results as $rs){
     $stockID=$rs->id;
    }
    return $stockID;


}
public function transferdel(Request $request){

    stocktrans::where('id','=',$request['id'])->delete();
    stocktrans::where('id','=',$request['id']+1)->delete();
}

public function transferreports(){
    return view ('transferreports/index');
}

public function transferview(){
    //return DB::select("select purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,if(type='OT',concat('From ',branchname),concat('To ',branchname)),stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type='OT'or type='IT' order by stocktrans.id");
    
    $today=date("'Y/m/d'");
    
    if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2'])){
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
    $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select  COUNT(*) as count from (select COUNT(transdates) as count,if(type='OT',GROUP_CONCAT(branchname SEPARATOR ' To   '),GROUP_CONCAT(branchname SEPARATOR '  From  ')) as branch,transfercode, purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type !='I' and type !='O'  and transdates between '$date1' and '$date2' group by transfercode) das");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select if(type='OT',GROUP_CONCAT(branchname SEPARATOR ' To   '),GROUP_CONCAT(branchname SEPARATOR '  From  ')) as branch,transfercode, purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type !='I' and type !='O'  and transdates between '$date1' and '$date2' group by transfercode limit $offset,$rows");
       // $rst =  DB::getPdo()->prepare("select purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,if(type='OT',concat('From ',branchname),concat('To ',branchname)) as branch,stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type='OT'  order by stocktrans.id limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);
    }else{

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count from (select COUNT(transdates) as count, if(type='OT',GROUP_CONCAT(branchname SEPARATOR ' To   '),GROUP_CONCAT(branchname SEPARATOR '  From  ')) as branch,transfercode, purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type !='I' and type !='O'  and transdates=$today  group by transfercode) das");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select if(type='OT',GROUP_CONCAT(branchname SEPARATOR ' To   '),GROUP_CONCAT(branchname SEPARATOR '  From  ')) as branch,transfercode, purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type !='I' and type !='O' and transdates=$today  group by transfercode limit $offset,$rows");
       // $rst =  DB::getPdo()->prepare("select purchaseheaderid,stocktrans.id,transdates, purchaseheaders.branch_id,branchname,if(type='OT',concat('From ',branchname),concat('To ',branchname)) as branch,stocks.name,description,quantity ,type from stocktrans inner join stocks   on stocks.id=stocktrans.stockname inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id  inner join branches on purchaseheaders.branch_id=branches.id where type='OT'  order by stocktrans.id limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results); 
    }
}


public function deletetransfers(Request $request){
    DB::beginTransaction();
    try{
    stocktrans::where('transfercode','=',$request['id'])->delete();
    transfers::where('id','=',$request['id'])->delete();
}catch(\Exception $e){
    DB::rollback();
    return  json_encode(array('isError'=>true,'Error'=>'Record Not Deleted, Please Delete  it again'));  
}

DB::commit();
}
 }

 