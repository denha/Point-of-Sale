<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\purchaseheaders;
use App\stocktrans;
use App\accounttrans;
use App\chartofaccounts;
use App\newpurchases;

 class purchaseheadersController extends Controller{

public function index(){
    return view('purchaseheaders/index');
}
public function editbarcodepurchases(){
    return view('purchaseheaders/edit');
}
public function salesindex(){

    return view('purchasesales/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from purchaseheaders ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from purchaseheaders limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
   // DB::beginTranscation();
    DB::beginTransaction();
    try{
    $Objpurchaseheaders=new purchaseheaders();
//$Objpurchaseheaders->id=$request['id'];
$Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
$Objpurchaseheaders->mode=$request['mode'];
$Objpurchaseheaders->supplier_id=$request['supplier_id'];
$Objpurchaseheaders->branch_id=$request['branch_id'];
$Objpurchaseheaders->isActive=$request['isActive'];
$Objpurchaseheaders->save();
    }catch(\Exception $e){
        DB::rollback();
    }
    DB::commit();

}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objpurchaseheaders=purchaseheaders::find($id);

$Objpurchaseheaders->id=$request['id'];
$Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
$Objpurchaseheaders->mode=$request['mode'];
$Objpurchaseheaders->supplier_id=$request['supplier_id'];
$Objpurchaseheaders->customer_id=$request['customer_id'];
$Objpurchaseheaders->branch_id=$request['branch_id'];
$Objpurchaseheaders->isActive=$request['isActive'];
$Objpurchaseheaders->created_at=$request['created_at'];
$Objpurchaseheaders->updated_at=$request['updated_at'];
$Objpurchaseheaders->save();
}
 public function destroy($id){
        $Objpurchaseheaders=purchaseheaders::find($id);
        $Objpurchaseheaders->delete();



    }

public function viewcombo(){


    return purchaseheaders::all();
}

public function maximum(){
    return DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='rockaboy' AND TABLE_NAME='purchaseheaders'");

  
           // return DB::select('select if(max(id)+1 is null,1,max(id)+1) as id from purchaseheaders');
           /// return DB::select('select if(max(id) is null,1,max(id)) as id from purchaseheaders');



 
}
public function savesales(Request $request){
    DB::beginTransaction();
    try{
    $Objpurchaseheaders= new purchaseheaders();
    $Objpurchaseheaders->id=$request['id'];
    $Objpurchaseheaders->branch_id=$request['branch_id'];
$Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
$Objpurchaseheaders->mode=$request['mode'];
$Objpurchaseheaders->customer_id=$request['customer_id'];
$Objpurchaseheaders->isActive=$request['isActive'];

$Objpurchaseheaders->save();
    }catch(\Exception $e){
        DB::rollback();  
    }
DB::commit();

}

public function savetransfers(Request $request){
    //post from branch one
 $Objpurchaseheaders= new purchaseheaders();
 $Objpurchaseheaders->id=$request['id'];
 $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
 $Objpurchaseheaders->remarks=$request['remarks'];
 $Objpurchaseheaders->branch_id=$request['from'];
 $Objpurchaseheaders->save();
 //post from branch two
 $Objpurchaseheaders= new purchaseheaders();
 $Objpurchaseheaders->id=$request['id'];
 $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
 $Objpurchaseheaders->branch_id=$request['to'];
 $Objpurchaseheaders->remarks=$request['remarks'];
 $Objpurchaseheaders->save();

}
public function savetransfertrans(Request $request){
$Objstocktrans= new stocktrans();
$Objstocktrans->stockname=$request['stockid'];
$Objstocktrans->quantity=$request['quantity'];
$Objstocktrans->type="IT";


}
public function isComplete(){
    $isComp=DB::select("SELECT count(amount) as count,purchaseheaderid,invoice_id FROM accounttrans WHERE purchaseheaderid NOT IN (SELECT id 
         FROM purchaseheaders)");
              foreach($isComp as $comp){
                accounttrans::where('purchaseheaderid','=',$comp->purchaseheaderid)->delete();
                stocktrans::where('purchaseheaderid','=',$comp->purchaseheaderid)->delete();
                newpurchases::where('header','=',$comp->purchaseheaderid)->delete();


            }
         return $isComp;
    
         
    
    }
    public function barcodepurchasesave(Request $request){
        DB::beginTransaction();
        $stockidentify=0;
        $unitofmeasureNo=0;
        try{
            $pdt=DB::select("select product_id,tbl_cart.id,quantity,sellingpx as buyingpx,member_id,name from tbl_cart inner join stocks on stocks.id=tbl_cart.product_id");
            $numberofproducts=count($pdt);
          $Objpurchaseheaders=new purchaseheaders();
          $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
          $Objpurchaseheaders->branch_id=auth()->user()->branchid;
          $Objpurchaseheaders->isActive=1;
          $Objpurchaseheaders->save();
        foreach ($pdt as $product){
            $item=DB::select("select uoms.isActive as number  from stocks inner join uoms on stocks.unitofmeasure=uoms.id where stocks.id=$product->product_id ");
            foreach($item as $ite){
                $unitofmeasureNo=$ite->number;

            }
            $Objstocktrans=new stocktrans();
            $Objstocktrans->transdate=date("Y-m-d", strtotime($request['transdates']));
            $Objstocktrans->purchaseheaderid=$Objpurchaseheaders->id;
            $Objstocktrans->stockname=$product->product_id;
            $Objstocktrans->totalamt=$product->quantity*$product->buyingpx;
            $Objstocktrans->quantity=$product->quantity*$unitofmeasureNo; 
            $Objstocktrans->qua=$this->getStockQua($product->product_id)+ $product->quantity;
            $Objstocktrans->type="I";
            $Objstocktrans->customer=$request['supplier'];
            $Objstocktrans->branchno=auth()->user()->branchid;
            $Objstocktrans->totaldue=0;
            if($request['bal']>=0){
                $Objstocktrans->totalpaid=$product->quantity*$product->buyingpx; 
                $Objstocktrans->buyingrate=$product->buyingpx;   
            }else{
                $Objstocktrans->totalpaid=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
                $Objstocktrans->buyingrate=$product->buyingpx;
            }

            $Objstocktrans->save();
            $stockidentify=$Objstocktrans->id;
    if($request['bal']>=0){
            // Accounting 
    //Debiting remember its a double entry
    //Extracting Default payment account
    $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();

    $Objaccounttrans1= new accounttrans();
    foreach($objchart as $obj){
        $Objaccounttrans1->accountcode=$obj->accountcode;//cash account   
    }
    $Objaccounttrans1->narration="Purchase ".$product->quantity." ".$product->name." @ ".number_format($product->buyingpx,0);
    $Objaccounttrans1->amount=$product->quantity*$product->buyingpx;
    $Objaccounttrans1->ttype="C";
    $Objaccounttrans1->total=$product->quantity*$product->buyingpx*-1;
    $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccounttrans1->stockidentify=$stockidentify;
    $Objaccounttrans1->stocktransid=$Objstocktrans->id;
    $Objaccounttrans1->bracid=auth()->user()->branchid;
    $Objaccounttrans1->save();
    // Inserting into inventory
    $Objaccountinventory= new accounttrans();
    $Objaccountinventory->accountcode="1113";//Fixed Account Inventory
    $Objaccountinventory->narration="Purchase of ".$product->quantity." ".$product->name;
    $Objaccountinventory->amount=$product->quantity*$product->buyingpx;
    $Objaccountinventory->total=$product->quantity*$product->buyingpx;
    $Objaccountinventory->ttype="D";
    $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccountinventory->stockidentify=$stockidentify;
    $Objaccountinventory->stocktransid=$Objstocktrans->id;
    $Objaccountinventory->bracid=auth()->user()->branchid;
    $Objaccountinventory->save();

    }else{
        $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();  
        // if goods are sold on credit 
        // Inserting into inventory
    $Objaccountinventory= new accounttrans();
    $Objaccountinventory->accountcode="1113";//Fixed Account Inventory
    $Objaccountinventory->narration="Purchase of ".$product->quantity." ".$product->name;
    $Objaccountinventory->amount=$product->quantity*$product->buyingpx;
    $Objaccountinventory->total=$product->quantity*$product->buyingpx;
    $Objaccountinventory->ttype="D";
    $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccountinventory->stockidentify=$stockidentify;
    $Objaccountinventory->stocktransid=$Objstocktrans->id;
    $Objaccountinventory->bracid=auth()->user()->branchid;
    $Objaccountinventory->save();
    // Cost of Goods inserting // Remember its an expense
    // Cash Paid is 
    $Objaccountinventory= new accounttrans();
    foreach($objchart as $obj){
        $Objaccountinventory->accountcode=$obj->accountcode;//cash account   
    }
    $Objaccountinventory->narration="Purchase of ".$product->quantity." ".$product->name;
    $Objaccountinventory->amount=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
    $Objaccountinventory->total=str_replace( ',', '',$request['cashpaid'])/$numberofproducts*-1;
    $Objaccountinventory->ttype="C";
    $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccountinventory->stockidentify=$stockidentify;
    $Objaccountinventory->stocktransid=$Objstocktrans->id;
    $Objaccountinventory->bracid=auth()->user()->branchid;
    $Objaccountinventory->save();
    // Accounts Payables 
    $Objaccounttrans= new accounttrans();
    $Objaccounttrans->accountcode="1112";//Fixed Account for sale of goods
    $Objaccounttrans->narration="Purchase on credit  ".$product->quantity." ".$product->name." @ ".number_format($product->buyingpx,0);
    $Objaccounttrans->amount=($product->quantity*$product->buyingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
    $Objaccounttrans->ttype="C";
    $Objaccounttrans->total=($product->quantity*$product->buyingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
    $Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccounttrans->stockidentify=$stockidentify;
    $Objaccounttrans->stocktransid=$Objstocktrans->id;
    $Objaccounttrans->bracid=auth()->user()->branchid;
    $Objaccounttrans->save();

    }
        }

        DB::statement("truncate table tbl_cart");
      
    
    }catch(\Exception $e){
        DB::rollBack();
        echo "Failed ".$e;
        
    }
    DB::commit();
    }
    public function stockeditbarcode($id,$id2){
        $is=DB::select("select customer,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate from stocktrans inner join stocks on stocks.id=stocktrans.stockname where purchaseheaderid=$id limit 1");
    return  view ('stockpurchaseedit/index')->with('cartid',$id)->with('first',$id2)->with('details',$is);
    }
 public function getStockQua($id){
        $items=DB::select("select sum(quantity) as qty  from stocktrans where type='i' and stockname='$id' ");
        foreach($items as $ite){
            return $ite->qty;
        }
        }
        public function editPurchases(Request $request){
   
            DB::beginTransaction();
            $stockidentify=0;
            $stockavail=0;
            $unitofmeasureNo=0;
            try{
                $headernumber=$request['number'];
                DB::delete("delete from stocktrans where purchaseheaderid=$headernumber");
                DB::delete("delete from accounttrans where purchaseheaderid=$headernumber");
                $pdt=DB::select("select stockid, product_id,tbl_cart.id,quantity,sellingpx as buyingpx,member_id,name from tbl_cart inner join stocks on stocks.id=tbl_cart.product_id");
                $numberofproducts=count($pdt);
                foreach ($pdt as $product){
                    $item=DB::select("select uoms.isActive as number  from stocks inner join uoms on stocks.unitofmeasure=uoms.id where stocks.id=$product->product_id ");
                    foreach($item as $ite){
                        $unitofmeasureNo=$ite->number;
        
                    }
                    $Objstocktrans=new stocktrans();
                    $Objstocktrans->transdate=date("Y-m-d", strtotime($request['transdates']));
                    $Objstocktrans->purchaseheaderid=$headernumber;
                    $Objstocktrans->stockname=$product->product_id;
                    $Objstocktrans->totalamt=$product->quantity*$product->buyingpx;
                    $Objstocktrans->quantity=$product->quantity*$unitofmeasureNo; 
                    $Objstocktrans->qua=$this->getStockQua($product->product_id)+ $product->quantity;
                    $Objstocktrans->type="I";
                    $Objstocktrans->customer=$request['supplier'];
                    $Objstocktrans->branchno=auth()->user()->branchid;
                    $Objstocktrans->totaldue=0;
                    if($request['bal']>=0){
                        $Objstocktrans->totalpaid=$product->quantity*$product->buyingpx; 
                        $Objstocktrans->buyingrate=$product->buyingpx;   
                    }else{
                        $Objstocktrans->totalpaid=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
                        $Objstocktrans->buyingrate=$product->buyingpx;
                    }
        
                    $Objstocktrans->save();
                    $stockidentify=$Objstocktrans->id;
            if($request['bal']>=0){
                    // Accounting 
            //Debiting remember its a double entry
            //Extracting Default payment account
            $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();
        
            $Objaccounttrans1= new accounttrans();
            foreach($objchart as $obj){
                $Objaccounttrans1->accountcode=$obj->accountcode;//cash account   
            }
            $Objaccounttrans1->narration="Purchase ".$product->quantity." ".$product->name." @ ".number_format($product->buyingpx,0);
            $Objaccounttrans1->amount=$product->quantity*$product->buyingpx;
            $Objaccounttrans1->ttype="C";
            $Objaccounttrans1->total=$product->quantity*$product->buyingpx*-1;
            $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
            $Objaccounttrans1->purchaseheaderid=$headernumber;
            $Objaccounttrans1->stockidentify=$stockidentify;
            $Objaccounttrans1->stocktransid=$Objstocktrans->id;
            $Objaccounttrans1->bracid=auth()->user()->branchid;
            $Objaccounttrans1->save();
            // Inserting into inventory
            $Objaccountinventory= new accounttrans();
            $Objaccountinventory->accountcode="1113";//Fixed Account Inventory
            $Objaccountinventory->narration="Purchase of ".$product->quantity." ".$product->name;
            $Objaccountinventory->amount=$product->quantity*$product->buyingpx;
            $Objaccountinventory->total=$product->quantity*$product->buyingpx;
            $Objaccountinventory->ttype="D";
            $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
            $Objaccountinventory->purchaseheaderid=$headernumber;
            $Objaccountinventory->stockidentify=$stockidentify;
            $Objaccountinventory->stocktransid=$Objstocktrans->id;
            $Objaccountinventory->bracid=auth()->user()->branchid;
            $Objaccountinventory->save();
        
            }else{
                $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();  
                // if goods are sold on credit 
                // Inserting into inventory
            $Objaccountinventory= new accounttrans();
            $Objaccountinventory->accountcode="1113";//Fixed Account Inventory
            $Objaccountinventory->narration="Purchase of ".$product->quantity." ".$product->name;
            $Objaccountinventory->amount=$product->quantity*$product->buyingpx;
            $Objaccountinventory->total=$product->quantity*$product->buyingpx;
            $Objaccountinventory->ttype="D";
            $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
            $Objaccountinventory->purchaseheaderid=$headernumber;
            $Objaccountinventory->stockidentify=$stockidentify;
            $Objaccountinventory->stocktransid=$Objstocktrans->id;
            $Objaccountinventory->bracid=auth()->user()->branchid;
            $Objaccountinventory->save();
            // Cost of Goods inserting // Remember its an expense
            // Cash Paid is 
            $Objaccountinventory= new accounttrans();
            foreach($objchart as $obj){
                $Objaccountinventory->accountcode=$obj->accountcode;//cash account   
            }
            $Objaccountinventory->narration="Purchase of ".$product->quantity." ".$product->name;
            $Objaccountinventory->amount=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
            $Objaccountinventory->total=str_replace( ',', '',$request['cashpaid'])/$numberofproducts*-1;
            $Objaccountinventory->ttype="C";
            $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
            $Objaccountinventory->purchaseheaderid=$headernumber;
            $Objaccountinventory->stockidentify=$stockidentify;
            $Objaccountinventory->stocktransid=$Objstocktrans->id;
            $Objaccountinventory->bracid=auth()->user()->branchid;
            $Objaccountinventory->save();
            // Accounts Payables 
            $Objaccounttrans= new accounttrans();
            $Objaccounttrans->accountcode="1112";//Fixed Account for sale of goods
            $Objaccounttrans->narration="Purchase on credit  ".$product->quantity." ".$product->name." @ ".number_format($product->buyingpx,0);
            $Objaccounttrans->amount=($product->quantity*$product->buyingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
            $Objaccounttrans->ttype="C";
            $Objaccounttrans->total=($product->quantity*$product->buyingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
            $Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
            $Objaccounttrans->purchaseheaderid=$headernumber;
            $Objaccounttrans->stockidentify=$stockidentify;
            $Objaccounttrans->stocktransid=$Objstocktrans->id;
            $Objaccounttrans->bracid=auth()->user()->branchid;
            $Objaccounttrans->save();
        
            }
                }
        
                DB::statement("truncate table tbl_cart");
        
        }catch(\Exception $e){
            DB::rollBack();
            echo "Failed ".$e;
            
        }
        DB::commit();
        }
        public function changePurchases(Request $request,$id){
            $is=DB::select("select customer,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate from stocktrans inner join stocks on stocks.id=stocktrans.stockname where purchaseheaderid=$id limit 1");
            return view('stockpurchaseedit/edit')->with('number',$id)->with('details',$is);
        }

}