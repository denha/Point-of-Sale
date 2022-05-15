<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\newpurchases;
use App\invoices;
use App\chartofaccounts;
use App\accounttrans;
use App\purchaseheaders;
use Excel;
use App\availablestocks;
use App\stocktrans;
use App\stocks;
use App\recievedstocks;



class newpurchaseController extends Controller{

public function index(){

    return view("newpurchase.index");
}

public function maximum(){
    return DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='rockaboy' AND TABLE_NAME='invoices'");

}
public function savenewpurchase(Request $request){
    DB::beginTransaction();
    try{
        $Objnewpurchase = new newpurchases();
        $Objnewpurchase->name=$request['name'];
        $Objnewpurchase->qty=$request['qty'];
        $Objnewpurchase->price=str_replace( ',', '',$request['price']);
        $Objnewpurchase->subtotal=str_replace( ',', '',$request['subtotal']);
        $Objnewpurchase->invoice_no=$request['purchaseno'];
        $Objnewpurchase->header=$request['header'];
        $Objnewpurchase->save();
        $objavailablestocks = new availablestocks();
        $objavailablestocks->item_id=$Objnewpurchase->id;
        $objavailablestocks->qty=$request['qty'];
        $objavailablestocks->save();
        $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();

        $Objaccounttrans1= new accounttrans();
    foreach($objchart as $obj){
        $Objaccounttrans1->accountcode=$obj->accountcode;//cash account   
    }
    $Objaccounttrans1->narration="Purchase ".$request['qty']." ".$request['name']." @ ".$request['price'];
    $Objaccounttrans1->amount=str_replace( ',', '',$request['price'])*$request['qty'];
    $Objaccounttrans1->ttype="C";
    $Objaccounttrans1->total=(str_replace( ',', '',$request['price'])*$request['qty'])*-1;
    $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccounttrans1->purchaseheaderid=$request['header'];
    $Objaccounttrans1->invoice_id=$Objnewpurchase->id;
    $Objaccounttrans1->bracid=auth()->user()->branchid;
    $Objaccounttrans1->save();
    // Inserting into inventory
    $Objaccountinventory= new accounttrans();
    $Objaccountinventory->accountcode="1994";//Fixed Account Inventory
    $Objaccountinventory->narration="Purchase of ".$request['qty']." ".$request['name']." @ ".$request['price'];
    $Objaccountinventory->amount=str_replace( ',', '',$request['price'])*$request['qty'];
    $Objaccountinventory->total=str_replace( ',', '',$request['price'])*$request['qty'];
    $Objaccountinventory->ttype="D";
    $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccountinventory->purchaseheaderid=$request['header'];
    $Objaccountinventory->invoice_id=$Objnewpurchase->id;
    $Objaccountinventory->bracid=auth()->user()->branchid;
    $Objaccountinventory->save();

        $lastid=DB::table('newpurchases')->orderBy('id','DESC')->first();
    echo json_encode(array(
        'name' => $request['name'],
        'qty' => $request['qty'],
        'price' => $request['price'],
        'subtotal'=>$request['subtotal'],
        'id'=>$lastid->id,
        'purchaseno'=>$request['purchaseno'], 

    ));

    }catch(\Exception $e){
DB::rollBack();
echo "Failed to save ".$e;
    }
DB::commit();

}

public function saveinvoices(Request $request){
    DB::beginTransaction();
    try{
    $objinvoices = new invoices();
    $objinvoices->invoiceDate=date("Y-m-d", strtotime($request['date']));
    $objinvoices->supplierName=$request['supplier'];
    $objinvoices->isSaved=1;
    $objinvoices->save();

    $objpurchaseheaders = new purchaseheaders();
    $objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['date']));
    $objpurchaseheaders->branch_id=auth()->user()->branchid;
    $objpurchaseheaders->isActive=1;
    $objpurchaseheaders->save();
    # updating dates in accountrans 
    accounttrans::where("purchaseheaderid","=",$objpurchaseheaders->id)->update([
      'transdate'=>date("Y-m-d", strtotime($request['date']))
    ]);
}catch(\Exception $e){
    echo "Failed to save ".$e;
    DB::rollBack();
}
DB::commit();
}

public function viewnewpurchase($id){
  return  DB::select("select id,name,format(price,0) as price,qty,format(subtotal,0) as subtotal,invoice_no as purchaseno from newpurchases where invoice_no=$id");
}

public function editnewpurchases(Request $request){
   
   $inventorycode=0;
   $Objnewpurchase =newpurchases::find($request['id']);
    $Objnewpurchase->name=$request['name'];
    $Objnewpurchase->qty=$request['qty'];
    $Objnewpurchase->price=str_replace( ',', '',$request['price']);
    $Objnewpurchase->subtotal=str_replace( ',', '',$request['subtotal']);
    $Objnewpurchase->invoice_no=$request['purchaseno'];
    $Objnewpurchase->save();

    $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();

    
foreach($objchart as $obj){
    $inventorycode=$obj->accountcode;//cash account   
}
 accounttrans::where('ttype','=','C')->where('invoice_id','=',$request['id'])->update([
'narration'=>"Purchase ".$request['qty']." ".$request['name']." @ ".$request['price'],
'total'=>(str_replace( ',', '',$request['price'])*$request['qty'])*-1,
'amount'=>str_replace( ',', '',$request['price'])*$request['qty'],
'transdate'=>date("Y-m-d", strtotime($request['transdates'])),

 ]);


 accounttrans::where('ttype','=','D')->where('invoice_id','=',$request['id'])->update([
    'narration'=>"Purchase ".$request['qty']." ".$request['name']." @ ".$request['price'],
    'total'=>(str_replace( ',', '',$request['price'])*$request['qty']),
    'amount'=>str_replace( ',', '',$request['price'])*$request['qty'],
    'transdate'=>date("Y-m-d", strtotime($request['transdates'])),
    
     ]);



    
    $lastid=DB::table('newpurchases')->orderBy('id','DESC')->first();
echo json_encode(array(
    'name' => $request['name'],
    'qty' => $request['qty'],
    'price' => $request['price'],
    'subtotal'=>$request['subtotal'],
    'id'=>$lastid->id,
    'purchaseno'=>$request['purchaseno'], 

));
 }

 public function delnewpurchase(Request $request,$id){
     DB::beginTransaction();
     try{
$objdel=newpurchases::find($id);
accounttrans::where('invoice_id','=',$id)->delete();
$objdel->delete();
     }catch(\Exception $e){
echo "Failed to delete ".$e;
DB::rollBack();
     }
DB::commit();

 }

 public function invoicereports(){
     return view("invoicereports/index");
 }

 public function viewinvoicereports(){
     return DB::select("SELECT format(sum(subtotal),0) as total,sum(availablestocks.qty) as sqty,newpurchases.id as pid, header,invoices.id as id, DATE_FORMAT(invoiceDate,'%d-%m-%Y') as invoiceDate,suppliers.companyName as suppliername FROM `invoices` inner join suppliers on suppliers.id=invoices.supplierName inner join newpurchases on newpurchases.invoice_no=invoices.id inner join availablestocks on availablestocks.item_id=newpurchases.id group by newpurchases.invoice_no having sum(availablestocks.qty)>0");
 }

 public function  editnewpurchase($id){
     $purchase=DB::select("select invoice_no,DATE_FORMAT(invoiceDate,'%d-%m-%Y') invoiceDate,supplierName from newpurchases  inner join invoices on invoices.id=newpurchases.invoice_no where invoice_no=$id group by invoice_no");
     return view ("editnewpurchase/index")->with('id',$id)->with("purc",$purchase);
 }

 public function newpurchasereports(){
     return view("newpurchasereports/index");
 }
 public function newpurchasereportviews()
 {
    $today=date("Y-m-d");
    
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1'])&& empty($_GET['date2'])){
      $this->dailypurchases("invoiceDate='$today'");
    }
    else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& empty($_GET['date2'])){
      $date1=date("Y-m-d", strtotime($_GET['date1']));
      $this->dailypurchases("invoiceDate<='$date1'");
    }
    else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& !empty($_GET['date2'])){
      $date1=date("Y-m-d", strtotime($_GET['date1']));
      $date2=date("Y-m-d", strtotime($_GET['date2']));
      $this->dailypurchases("invoiceDate BETWEEN '$date1' AND '$date2' ");
    }
   
      }
 public function dailypurchases($where){
    $branch=auth()->user()->branchid;
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("SELECT count(*) as count, header as purchaseheaderid, name as itemcode,suppliers.companyName as companyName,qty as quantity,format(subtotal,0)  as totalamt,DATE_FORMAT(invoiceDate,'%d-%m-%Y') as transdate FROM `newpurchases`inner join invoices on invoices.id=newpurchases.invoice_no inner join suppliers on suppliers.id=invoices.supplierName where $where");
   //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("SELECT  header as purchaseheaderid, newpurchases.name as itemcode,suppliers.companyName as companyName,qty as quantity,format(subtotal,0)  as totalamt,DATE_FORMAT(invoiceDate,'%d-%m-%Y') as transdate FROM `newpurchases`inner join invoices on invoices.id=newpurchases.invoice_no inner join suppliers on suppliers.id=invoices.supplierName where $where limit   $offset,$rows");
    $rst->execute();
  
    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   //Showing The footer and totals 
   $footer =  DB::getPdo()->prepare("SELECT  format(sum(subtotal),0)  as totalamt FROM `newpurchases`inner join invoices on invoices.id=newpurchases.invoice_no inner join suppliers on suppliers.id=invoices.supplierName where $where ");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);
  }

  // Recieved stocks 
  public function viewrecieved()
  {
     $today=date("Y-m-d");
     
     if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1'])&& empty($_GET['date2'])){
       $this->viewrecievedstock("date='$today'");
     }
     else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& empty($_GET['date2'])){
       $date1=date("Y-m-d", strtotime($_GET['date1']));
       $this->viewrecievedstock("date<='$date1'");
     }
     else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& !empty($_GET['date2'])){
       $date1=date("Y-m-d", strtotime($_GET['date1']));
       $date2=date("Y-m-d", strtotime($_GET['date2']));
       $this->viewrecievedstock("date BETWEEN '$date1' AND '$date2' ");
     }
    
       }
  public function viewrecievedstock($where){
     $branch=auth()->user()->branchid;
     $results=array();
     $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
     $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
     $offset = ($page-1)*$rows;
     $rs =DB::getPdo();
     $krows = DB::select("select COUNT(*) as count, qty,date,recievedstocks.id as id, purchaseNo,name from recievedstocks inner join stocks on stocks.id=recievedstocks.item_code where $where");
      
    //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
     $results['total']=$krows[0]->count;
     $rst =  DB::getPdo()->prepare("select saveid, remarks,qty,DATE_FORMAT(date,'%d-%m-%Y') as date,recievedstocks.id as id, purchaseNo,name from recievedstocks inner join stocks on stocks.id=recievedstocks.item_code where $where limit   $offset,$rows");
     $rst->execute();
   
     $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
    $results['rows']=$viewall;
    //Showing The footer and totals 
    /*$footer =  DB::getPdo()->prepare(" ");
    $footer->execute();
    $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
    $results['footer']=$foots;*/
    echo json_encode($results);
   }

  //End of Recieved stocks 
  public function destorys(Request $request,$id){
     
    DB::beginTransaction();
    try{
                   if(auth()->user()->admin==1){
		
		if($id=='undefined'){
			
		}else{
        if($request['isLast']=='yes'){
            DB::delete("delete from stocktrans where transfercode=$id");
            DB::delete("delete from purchaseheaders where id=$id");
            DB::delete("delete from accounttrans where purchaseheaderid=$id");
            DB::delete("delete from accounttrans where invoice_xpid=$id");
            DB::delete("delete from newpurchases where header=$id");
            DB::delete("delete from stocktrans where purchaseheaderid=$id");
            DB::delete("delete from stocks where stockheader=$id");
        }else{
        DB::delete("delete from stocktrans where purchaseheaderid=$id");
        DB::delete("delete from purchaseheaders where id=$id");
        DB::delete("delete from accounttrans where purchaseheaderid=$id");
        DB::delete("delete from newpurchases where header=$id");
        DB::delete("delete from accounttrans where invoice_xpid=$id");
        DB::delete("delete from stocktrans where purchaseheaderid=$id");
        DB::delete("delete from stocks where stockheader=$id");
        }
		}
}else{
return ['result'=>'no'];
}
        /*
        $Objstocktrans=stocktrans::where('purchaseheaderid','=',$id)->delete();
    
        $Objpurchaseheader=purchaseheaders::where('id','=',$id)->delete();
       
        $Objaccounttrans=accounttrans::where('purchaseheaderid','=',$id)->delete();*/
    }catch(\Exception $e){
     DB::rollback();   
    }
      DB::commit();



    }

    public function delrecievedstoc(Request $request,$id){
        DB::beginTransaction();
        try{
           
        purchaseheaders::where('id','=',$request['purchaseNo'])->delete();
        accounttrans::where("purchaseheaderid","=",$request['purchaseNo'])->delete();
        $qty=$request['qty'];
        $saveid=$request['saveid'];
        stocktrans::where("delheader","=",$request['purchaseNo'])->delete();
        stocks::where("delhead","=",$request['purchaseNo'])->delete();
        recievedstocks::where("id","=",$id)->delete();
       // echo $saveid;
        DB::update("update availablestocks set qty=qty+$qty where item_id=$saveid");

        }catch(\Exception $e){
            echo "Failed to work ".$e;
            DB::rollBack();
        }
DB::commit();

    }
    public function dailypurchasesexcel($where){
        $branch=auth()->user()->branchid;
       $rst= DB::select("SELECT  header as purchaseheaderid, newpurchases.name as Item_Name,suppliers.companyName as Supplier,qty as Quantity,format(subtotal,0)  as Totalamt,DATE_FORMAT(invoiceDate,'%d-%m-%Y') as Transaction_Date FROM `newpurchases`inner join invoices on invoices.id=newpurchases.invoice_no inner join suppliers on suppliers.id=invoices.supplierName where $where");
        DB::select("SELECT  header as purchaseheaderid, newpurchases.name as Item_Name,suppliers.companyName as Supplier,qty as Quantity,format(subtotal,0)  as Totalamt,DATE_FORMAT(invoiceDate,'%d-%m-%Y') as Transaction_Date FROM `newpurchases`inner join invoices on invoices.id=newpurchases.invoice_no inner join suppliers on suppliers.id=invoices.supplierName where $where");
        //$rst1 =  DB::select("select  DATE_FORMAT(transdate,'%d-%m-%Y') as Transaction_Date, companyName as Supplier,name as Item_Name,quantity as Quantity,format(totalpaid,0) as totalpaid,format(totaldue,0) as Totaldue,format(totalamt,0) as Totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join purchaseheaders on purchaseheaders.id=stocktrans.purchaseheaderid inner join suppliers on suppliers.id=purchaseheaders.supplier_id where type='I' and branchno=$branch and $where  order by purchaseheaderid asc ");
        return json_decode(json_encode($rst), true);
      }

      public function purchasereportexcel($type,$date1,$date2){
        $today=date("Y-m-d");
        $data='';
      
        if( $date1=='today'&& $date2=='today'){
            $data= $this->dailypurchasesexcel("invoiceDate='$today'");
           
        }
        else if( $date1!=''&& $date2=='today'){
          if(auth()->user()->admin==1){
          $date1=date("Y-m-d", strtotime($date1));
          $data=$this->dailypurchasesexcel("invoiceDate<='$date1'");
          
        }
        }
        else if( $date1!='' && $date2!=''){
          if(auth()->user()->admin==1){
          $date1=date("Y-m-d", strtotime($date1));
          $date2=date("Y-m-d", strtotime($date2));
         $data= $this->dailypurchasesexcel("invoiceDate BETWEEN '$date1' AND '$date2' ");
         
          }
        }
    
        return Excel::create('PurchaseReport', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function stockrecexcel($where){
        $branch=auth()->user()->branchid;
       $rst= DB::select("select DATE_FORMAT(date,'%d-%m-%Y') as Transacation_Date, name as Item_name, qty as Quantity, remarks as Remarks from recievedstocks inner join stocks on stocks.id=recievedstocks.item_code where $where");
        //DB::select("SELECT  header as purchaseheaderid, newpurchases.name as Item_Name,suppliers.companyName as Supplier,qty as Quantity,format(subtotal,0)  as Totalamt,DATE_FORMAT(invoiceDate,'%d-%m-%Y') as Transaction_Date FROM `newpurchases`inner join invoices on invoices.id=newpurchases.invoice_no inner join suppliers on suppliers.id=invoices.supplierName where $where");
        //$rst1 =  DB::select("select  DATE_FORMAT(transdate,'%d-%m-%Y') as Transaction_Date, companyName as Supplier,name as Item_Name,quantity as Quantity,format(totalpaid,0) as totalpaid,format(totaldue,0) as Totaldue,format(totalamt,0) as Totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join purchaseheaders on purchaseheaders.id=stocktrans.purchaseheaderid inner join suppliers on suppliers.id=purchaseheaders.supplier_id where type='I' and branchno=$branch and $where  order by purchaseheaderid asc ");
        return json_decode(json_encode($rst), true);
      }

      public function stockexcel($type,$date1,$date2){
        $today=date("Y-m-d");
        $data='';
      
        if( $date1=='today'&& $date2=='today'){
            $data= $this->stockrecexcel("date='$today'");
           
        }
        else if( $date1!=''&& $date2=='today'){
          if(auth()->user()->admin==1){
          $date1=date("Y-m-d", strtotime($date1));
          $data=$this->stockrecexcel("date<='$date1'");
          
        }
        }
        else if( $date1!='' && $date2!=''){
          if(auth()->user()->admin==1){
          $date1=date("Y-m-d", strtotime($date1));
          $date2=date("Y-m-d", strtotime($date2));
         $data= $this->stockrecexcel("date BETWEEN '$date1' AND '$date2' ");
         
          }
        }
    
        return Excel::create('Stock Recieved', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
      
}