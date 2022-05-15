<?php 
 namespace App\Http\Controllers;
 session_start();
 
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\stocktrans;
use App\accounttrans;
use App\products;
use App\purchaseheaders;
use App\companys;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
 class printbarcodesController extends Controller{


public function printbarcode($id){
    try {
        $a=0;
        $results=DB::select("select id,name,format(sellingrate,0) as sellingrate,barcode from stocks order by id desc limit 1");
        $company=companys::find(auth()->user()->branchid);
        for($a;$a<$id;$a++){
        // Enter the share name for your USB printer here
        $connector = new CupsPrintConnector("MainLabelPrinter");
        $printer = new Printer($connector);
    foreach($results as $res){
        
        $printer -> text("
        ^XA


^CF0,30
^FO260,10^FD".$res->name."^FS
^FO260,50^FDUGX". $res->sellingrate."^FS


^FX Third section with barcode.

^BY2,3,75
^FO260,80^B2^FD".$res->barcode."^FS



^XZ



        ");
        $printer -> close();
    }
        }
    } catch(Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }

}

public function printbarselect(Request $request){
    try {
        $id=$request['id'];
        $copies=$request['copies'];
        $a=0;
        $company=companys::find(auth()->user()->branchid);
        $results=DB::select("select id,name,format(sellingrate,0) as sellingrate,barcode,buyingrate as buyingpx from stocks where id=$id order by id desc limit 1");

        for($a;$a<$copies;$a++){
        // Enter the share name for your USB printer here
        $connector = new CupsPrintConnector("MainLabelPrinter");
        $printer = new Printer($connector);
    foreach($results as $res){
        
        $printer -> text("
        ^XA


^CF0,30
^FO260,10^FD".$res->name."^FS
^FO260,50^FDUGX". $res->sellingrate."^FS


^FX Third section with barcode.

^BY2,3,75
^FO260,80^B2^FD".$res->barcode."^FS



^XZ


        ");
        $printer -> close();
    }
        }

        // Adding stock to the table
        foreach($results as $product){
        $Objpurchaseheaders=new purchaseheaders();
        $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['sdate']));
        $Objpurchaseheaders->branch_id=auth()->user()->branchid;
        $Objpurchaseheaders->isActive=1;
        $Objpurchaseheaders->save();
      
          $item=DB::select("select uoms.isActive as number  from stocks inner join uoms on stocks.unitofmeasure=uoms.id where stocks.id=$id ");
          foreach($item as $ite){
              $unitofmeasureNo=$ite->number;

          }
          $Objstocktrans=new stocktrans();
          $Objstocktrans->transdate=date("Y-m-d", strtotime($request['sdate']));
          $Objstocktrans->purchaseheaderid=$Objpurchaseheaders->id;
          $Objstocktrans->stockname=$id;
          $Objstocktrans->totalamt=$copies*$product->buyingpx;
          $Objstocktrans->quantity=$copies*$unitofmeasureNo; 
          $Objstocktrans->qua=$this->getStockQua($id)+ $copies;
          $Objstocktrans->type="I";
          $Objstocktrans->customer=1;
          $Objstocktrans->branchno=auth()->user()->branchid;
          $Objstocktrans->totaldue=0;
          $Objstocktrans->totalpaid=$copies*$product->buyingpx; 
          $Objstocktrans->buyingrate=$product->buyingpx;   
          $Objstocktrans->save();
          $stockidentify=$Objstocktrans->id;

          // Accounting 
  //Debiting remember its a double entry
  //Extracting Default payment account

  $Objaccounttrans1= new accounttrans();
  $Objaccounttrans1->accountcode=1113;//Inventory   
  $Objaccounttrans1->narration="Stock in ".$copies." ".$product->name." @ ".number_format($product->buyingpx,0);
  $Objaccounttrans1->amount=$copies*$product->buyingpx;
  $Objaccounttrans1->ttype="D";
  $Objaccounttrans1->total=$copies*$product->buyingpx;
  $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['sdate']));
  $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
  $Objaccounttrans1->stockidentify=$stockidentify;
  $Objaccounttrans1->stocktransid=$Objstocktrans->id;
  $Objaccounttrans1->bracid=auth()->user()->branchid;
  $Objaccounttrans1->save();
  
  // Inserting into Capital
  $Objaccountinventory= new accounttrans();
  $Objaccountinventory->accountcode="4500";//Fixed Account Inventory
  $Objaccountinventory->narration="Stock in of ".$copies." ".$product->name;
  $Objaccountinventory->amount=$copies*$product->buyingpx;
  $Objaccountinventory->total=$copies*$product->buyingpx;
  $Objaccountinventory->ttype="C";
  $Objaccountinventory->transdate=date("Y-m-d", strtotime($request['sdate']));
  $Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
  $Objaccountinventory->stockidentify=$stockidentify;
  $Objaccountinventory->stocktransid=$Objstocktrans->id;
  $Objaccountinventory->bracid=auth()->user()->branchid;
  $Objaccountinventory->save();
        }
    } catch(Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }

}
public function checkPrint(){
    $objcompany=companys::find(1);
    return $objcompany;

}
public function getStockQua($id){
    $items=DB::select("select sum(quantity) as qty  from stocktrans where type='i' and stockname='$id' ");
    foreach($items as $ite){
        return $ite->qty;
    }
    }
}
