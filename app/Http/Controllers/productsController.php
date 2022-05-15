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

 class productsController extends Controller{

public function index(){
   $objproducts= products::all();
  
   $pdf = \App::make('dompdf.wrapper');
   $pdf->loadHTML(view('product')->with('product',$objproducts));
  return $pdf->stream();
  
   //return view('product')->with('product',$objproducts);

}
public function barcodesales(){
    unset($_SESSION["shopping_cart"]);
    return view("barcodesales/index");
}
public function editbarcodesales(){
    return view('barcodesales/edit');
}
public function barcodesalessave(Request $request){
    DB::beginTransaction();
    $stockidentify=0;
    $stockavail=0;
    try{
        $pdt=DB::select("select product_id,tbl_cart.id,quantity,sellingpx,member_id,name from tbl_cart inner join stocks on stocks.id=tbl_cart.product_id");
        $numberofproducts=count($pdt);
      $Objpurchaseheaders=new purchaseheaders();
      $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
      $Objpurchaseheaders->branch_id=auth()->user()->branchid;
      $Objpurchaseheaders->isActive=1;
      $Objpurchaseheaders->save();
    foreach ($pdt as $product){
        $item=DB::select("select if(sum(quantity) is null,0,sum(quantity)) as quantity from stocktrans where stockname=$product->product_id and type='o' and branchno=1");
        foreach($item as $ite){
        $stockavail=$ite->quantity;
        }
        $Objstocktrans=new stocktrans();
        $Objstocktrans->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objstocktrans->purchaseheaderid=$Objpurchaseheaders->id;
        $Objstocktrans->stockname=$product->product_id;
        $Objstocktrans->totalamt=$product->quantity*$product->sellingpx;
        $Objstocktrans->quantity=$product->quantity; 
        $Objstocktrans->type="O";
        $Objstocktrans->customer=$request['customer'];
        $Objstocktrans->branchno=auth()->user()->branchid;
        if($request['bal']>=0){
            $Objstocktrans->totalpaid=$product->quantity*$product->sellingpx; 
            $Objstocktrans->sellingrate=$product->sellingpx*$product->quantity;   
        }else{
            $Objstocktrans->totalpaid=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
            $Objstocktrans->sellingrate=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
        }
       // $Objstocktrans->totalpaid=str_replace( ',', '',$request['cashpaid']);
        //$Objstocktrans->totaldue=$request['totaldue'];
        
        $Objstocktrans->buyingrate=$this->getAmount($product->product_id,$product->quantity,$stockavail);
        $Objstocktrans->save();
if($request['bal']>=0){
        // Accounting 
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=$product->quantity*$product->sellingpx;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=$product->quantity*$product->sellingpx;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
//Debiting remember its a double entry
$Objaccounttrans1= new accounttrans();
$Objaccounttrans1->accountcode=3600;//cash account
$Objaccounttrans1->narration="Sale of ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans1->amount=$product->quantity*$product->sellingpx;
$Objaccounttrans1->ttype="D";
$Objaccounttrans1->total=$product->quantity*$product->sellingpx;
$Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccounttrans1->stockidentify=$stockidentify;
$Objaccounttrans1->stocktransid=$Objstocktrans->id;
$Objaccounttrans1->bracid=auth()->user()->branchid;
$Objaccounttrans1->save();
// Inserting into inventory
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1113";//Fixed Account Inventory
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail)*-1;
$Objaccountinventory->ttype="C";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
// Cost of Goods inserting // Remember its an expense
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1001";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
}else{
   
    // if goods are sold on credit 
    // Inserting into inventory
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1113";//Fixed Account Inventory
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail)*-1;
$Objaccountinventory->ttype="C";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
// Cost of Goods inserting // Remember its an expense
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1001";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->save();
// Cash Paid is 
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="3600";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccountinventory->total=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
// sale of goods account
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
// Accounts Recievable
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1111";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of on credit  ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->ttype="D";
$Objaccounttrans->total=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
// Sale of goods 
// Accounts Recievable
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of on credit  ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
}
    }
   $print= DB::select("select * from companys where isPrint=1");
   if(count($print)>0){
 $this->reciept(str_replace( ',', '',$request['cashpaid']),$request['bal']);
   }
    // PR
    //unset($_SESSION["shopping_cart"]);
    DB::statement("truncate table tbl_cart");
   //return view('barcodesales/index');

}catch(\Exception $e){
    DB::rollBack();
    echo "Failed ".$e;
    
}
DB::commit();
}
public function getAmount($stockid,$qty,$available){
    $items=DB::select("select * from stocktrans where type='i' and stockname=$stockid order by id asc");
    $stockavailable=$available;
    $Qtytaken=$qty;
    $Qtytaken2=$qty;
    $overQty=0;
    $overBal=0;
    $amount=0;$amount2=0;
    foreach($items as $item){
        if($stockavailable<=$item->qua){
           
            $newfigure=$item->qua-$stockavailable;
            if($Qtytaken>$newfigure){
                //reducing qty taken
                $Qtytaken=$Qtytaken-$newfigure;
                //increasing stock avaible 
                $stockavailable=$stockavailable+$newfigure;
                $amount=$amount+($newfigure*$item->buyingrate);
                $overQty=$overQty+$newfigure;
                
            }else{
                $amount2=$amount2+($Qtytaken*$item->buyingrate);
                $overQty=$overQty+$Qtytaken;
                
            break;
            }
    
        }
    
    }
    // Getting Price for left Overs 
    if($Qtytaken2-$overQty>0){
        $items=DB::select("select * from stocktrans where type='i' and stockname=$stockid order by id asc");
        foreach($items as $ite){
            if($overQty<=$ite->qua){
                $overBal=$overBal+($Qtytaken2-$overQty)*$ite->buyingrate;
            }
        }
    }
    
    
    return $overBal+$amount+$amount2;
    
    }
public function search($key){
   //return  DB::select("select name from stocks where name  like '%{$key}%' ");
   $array = array();
   $con=mysqli_connect("localhost","root","","rockaboy");
   $query=mysqli_query($con, "select * from stocks where name LIKE '%{$key}%'");
   while($row=mysqli_fetch_assoc($query))
   {
     $array[] = $row['name'];
   }
   echo json_encode($array);
   mysqli_close($con);
}

public function savependings(Request $request){
    DB::beginTransaction();
    try{
        $Objpurchaseheaders=new purchaseheaders();
        $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['date']));
        $Objpurchaseheaders->branch_id=auth()->user()->branchid;
        $Objpurchaseheaders->isActive=1;
        $Objpurchaseheaders->save();
        $amount=str_replace( ',', '',$request['amount']);
        $header=$request['purchaseheaderid'];
        $pendings=DB::select("select id,stockname, sum(totalamt) as totalamt,sum(totalpaid) as totalpaid from stocktrans where purchaseheaderid=$header group by purchaseheaderid,stockname having totalpaid<totalamt");
        foreach($pendings as $pend){
            $productid=$pend->stockname;
            $pdt=DB::select("select * from stocks where id=$productid");
            foreach($pdt as $product){
           if($amount>0){

                if($amount>($pend->totalamt-$pend->totalpaid)){
                    $amount=$amount-($pend->totalamt-$pend->totalpaid);
                    echo $pend->stockname." and the payment is ".($pend->totalamt-$pend->totalpaid)."<br>";
                                        // posting to stock
                                        $Objstocktrans= new stocktrans();
                                        $Objstocktrans->purchaseheaderid=$request['purchaseheaderid'];
                                        $Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
                                        $Objstocktrans->totalpaid=($pend->totalamt-$pend->totalpaid);
                                        $Objstocktrans->branchno=1;
                                        $Objstocktrans->stockname=$pend->stockname;
                                        $Objstocktrans->customer=$request['custoid'];
                                        $Objstocktrans->transfercode=$Objpurchaseheaders->id;
                                        $Objstocktrans->sellingrate=($pend->totalamt-$pend->totalpaid);
                                        $Objstocktrans->type='O';
                                        $Objstocktrans->save();
                                        // Accounts Rec
                                        // Accounts Recievable
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1111";//Fixed Account for sale of goods
$Objaccounttrans->narration="Paying of goods on credit  ".$product->name." @ ".number_format($product->sellingrate,0);
$Objaccounttrans->amount=($pend->totalamt-$pend->totalpaid);
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=($pend->totalamt-$pend->totalpaid)*-1;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;;
$Objaccounttrans->stockidentify=0;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();

// Cash Account
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="3600";//Cost of Goods
$Objaccountinventory->narration="Paying of goods on credit  ".$product->name;
$Objaccountinventory->amount=($pend->totalamt-$pend->totalpaid);
$Objaccountinventory->total=($pend->totalamt-$pend->totalpaid);
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;;
$Objaccountinventory->stockidentify=0;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
                }else{
                    echo " And is $pend->stockname The lowest amt is ".$amount;
                    
                    // posting to stock
                    $Objstocktrans= new stocktrans();
                    $Objstocktrans->purchaseheaderid=$request['purchaseheaderid'];
                    $Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
                    $Objstocktrans->totalpaid=$amount;
                    $Objstocktrans->sellingrate=$amount;
                    $Objstocktrans->branchno=1;
                    $Objstocktrans->stockname=$pend->stockname;
                    $Objstocktrans->customer=$request['custoid'];
                    $Objstocktrans->type='O';
                    $Objstocktrans->transfercode=$Objpurchaseheaders->id;
                    $Objstocktrans->save();
                                                            // Accounts Rec
                                        // Accounts Recievable
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1111";//Fixed Account for sale of goods
$Objaccounttrans->narration="Paying of goods on credit   ".$product->name." @ ".number_format($product->sellingrate,0);
$Objaccounttrans->amount=$amount;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=$amount;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans->purchaseheaderid=$Objpurchaseheaders->id;;
$Objaccounttrans->stockidentify=0;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();

// Cash Account
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="3600";//Cost of Goods
$Objaccountinventory->narration="Paying of goods on credit  ".$product->name;
$Objaccountinventory->amount=$amount;
$Objaccountinventory->total=$amount;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccountinventory->purchaseheaderid=$Objpurchaseheaders->id;;
$Objaccountinventory->stockidentify=0;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
                    // reducing on the amount 
                    $amount=$amount-($pend->totalamt-$pend->totalpaid);
                    // Printing 
                    $print= DB::select("select * from companys where isPrint=1");
                    if(count($print)>0){
                        $amount1=str_replace( ',', '',$request['amount']);
                        $custoid=$request['custoid'];
                        DB::statement("CREATE OR REPLACE VIEW pendings as select transdate,name as customer, purchaseheaderid,sum(totalamt) totalamt, sum(totalamt)-sum(totalpaid) as bal, sum(totalpaid) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer where customers.id=$custoid  group by purchaseheaderid having totalpaid<totalamt ");
                        $results=DB::select("select * from pendings where purchaseheaderid=$header");
                        foreach($results as $res){
                            $this->creditreciept( $amount1,$res->bal,$res->customer,$res->purchaseheaderid);
                        }
                  
                    }

                }
                //echo "The final amount is ".$amount;
           }

        }
    }

   // $this->creditreciept();
    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollBack();
    }
DB::commit();

}
public function reciept($cash,$bal){
    $branchid=auth()->user()->branchid;
    $datacompany=companys::find($branchid);
    
// Set params
$mid = '123123456';
$store_name = $datacompany->name;
$store_address = $datacompany->location;
$store_phone = $datacompany->phone;
$store_email = $datacompany->email;
$store_website = 'yourmart.com';
$tax_percentage = 10;
$transaction_id = 'TX123ABC456';
    // Init printer
$printer = new ReceiptPrinter;
$printer->init(
    config('receiptprinter.connector_type'),
    config('receiptprinter.connector_descriptor')
);

// Set store info
$printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

// Add items
/*foreach ($items as $item) {
    $printer->addItem(
        $item['name'],
        $item['qty'],
        $item['price']
    );
}*/
$pdt=DB::select("select product_id,tbl_cart.id,quantity,sellingpx,member_id,name from tbl_cart inner join stocks on stocks.id=tbl_cart.product_id");
foreach ($pdt as $product){
    $printer->addItem(
        $product->name,
        $product->quantity,
        $product->sellingpx
    );
}
// Set tax
$printer->setTax($tax_percentage);

// Calculate total
$printer->calculateSubTotal();
$printer->calculateGrandTotal();
$printer->setCashPaid($cash,$bal,auth()->user()->name); // cashpaid // Bal/ Servered by

// Set transaction ID
//$printer->setTransactionID($transaction_id);

// Set qr code
/*$printer->setQRcode([
    'tid' => $transaction_id,
]);*/

// Print receipt
$printer->printReceipt(true,'No');
}
public function updatequantity(){
   // require_once "ShoppingCart.php";
   $quantity=0;

    $member_id = 2; // you can your integerate authentication module here to get logged in member
    
    //$shoppingCart = new ShoppingCart();
    $qua=$_POST["new_quantity"];
    $id=$_POST["cart_id"];
    $price=str_replace( ',', '',$_POST['price']);
    //$shoppingCart->updateCartQuantity($_POST["new_quantity"], $_POST["cart_id"]);
    DB::update("update tbl_cart set quantity=$qua,sellingpx=$price where id=$id");
    $results =DB::select("select sum(quantity) as qty from tbl_cart");
    foreach($results as $rs){
        $quantity = $rs->qty;
    }
    return ['qty'=>$quantity];
}
public function delbarcodeitem(Request $request){
    DB::beginTransaction();
    try{
$id=$request['id'];
if($request['edit']=='Yes'){
    $results=DB::select("select * from tbl_cart where id=$id");
    foreach($results as $res){
        if($res->stockid!=0){
            $Objstock=stocktrans::find($res->stockid);
            $Objstock->delete();
            accounttrans::where('stocktransid','=',$res->stockid)->delete();
            DB::delete("delete from tbl_cart where id=$id"); 
        }else{
            DB::delete("delete from tbl_cart where id=$id");  
        }

        
    }
    

}else{
    DB::delete("delete from tbl_cart where id=$id");   
}
    }catch(\Exception $e){
        DB::rollBack();
        echo "Failed ".$e;
        
    }
    DB::commit();
}

public function stockeditbarcode($id,$id2){
    $is=DB::select("select customer,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate from stocktrans inner join stocks on stocks.id=stocktrans.stockname where purchaseheaderid=$id limit 1");
return  view ('stockbarcodeedit/index')->with('cartid',$id)->with('first',$id2)->with('details',$is);
}
public function editchanges(Request $request,$id){
    $is=DB::select("select customer,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate from stocktrans inner join stocks on stocks.id=stocktrans.stockname where purchaseheaderid=$id limit 1");
    return view('stockbarcodeedit/edit')->with('number',$id)->with('details',$is);
}
public function creditreciept($amountpaid,$balance,$name,$reciept){
    $branchid=auth()->user()->branchid;
    $datacompany=companys::find($branchid);
    
// Set params
$mid = '123123456';
$store_name = $datacompany->name;
$store_address = $datacompany->location;
$store_phone = $datacompany->phone;
$store_email = $datacompany->email;
$store_website = 'yourmart.com';
$tax_percentage = 10;
$transaction_id = 'TX123ABC456';
    // Init printer
$printer = new ReceiptPrinter;
$printer->init(
    config('receiptprinter.connector_type'),
    config('receiptprinter.connector_descriptor')
);
$printer->setRecieptCredit($amountpaid,$balance,$name,$reciept);
// Set store info
$printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);
$printer->printReceipt(true,'Yes');

}

public function editsales(Request $request){
   
    DB::beginTransaction();
    $stockidentify=0;
    $stockavail=0;
    try{
        $headernumber=$request['number'];
        DB::delete("delete from stocktrans where purchaseheaderid=$headernumber");
        DB::delete("delete from accounttrans where purchaseheaderid=$headernumber");
        $pdt=DB::select("select stockid, product_id,tbl_cart.id,quantity,sellingpx,member_id,name from tbl_cart inner join stocks on stocks.id=tbl_cart.product_id");
        $numberofproducts=count($pdt);

    foreach ($pdt as $product){
        $item=DB::select("select if(sum(quantity) is null,0,sum(quantity)) as quantity from stocktrans where stockname=$product->product_id and type='o' and branchno=1");
        foreach($item as $ite){
        $stockavail=$ite->quantity;
        }
        $Objstocktrans=new stocktrans();
        $Objstocktrans->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objstocktrans->purchaseheaderid=$headernumber;
        $Objstocktrans->stockname=$product->product_id;
        $Objstocktrans->totalamt=$product->quantity*$product->sellingpx;
        $Objstocktrans->quantity=$product->quantity; 
        $Objstocktrans->type="O";
        $Objstocktrans->customer=$request['customer'];
        $Objstocktrans->branchno=auth()->user()->branchid;
        if($request['bal']>=0){
            $Objstocktrans->totalpaid=$product->quantity*$product->sellingpx; 
            $Objstocktrans->sellingrate=$product->sellingpx*$product->quantity;   
        }else{
            $Objstocktrans->totalpaid=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
            $Objstocktrans->sellingrate=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
        }
       // $Objstocktrans->totalpaid=str_replace( ',', '',$request['cashpaid']);
        //$Objstocktrans->totaldue=$request['totaldue'];
        
        $Objstocktrans->buyingrate=$this->getAmount($product->product_id,$product->quantity,$stockavail);
        $Objstocktrans->save();
if($request['bal']>=0){
        // Accounting 
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=$product->quantity*$product->sellingpx;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=$product->quantity*$product->sellingpx;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$headernumber;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
//Debiting remember its a double entry
$Objaccounttrans1= new accounttrans();
$Objaccounttrans1->accountcode=3600;//cash account
$Objaccounttrans1->narration="Sale of ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans1->amount=$product->quantity*$product->sellingpx;
$Objaccounttrans1->ttype="D";
$Objaccounttrans1->total=$product->quantity*$product->sellingpx;
$Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans1->purchaseheaderid=$headernumber;
$Objaccounttrans1->stockidentify=$stockidentify;
$Objaccounttrans1->stocktransid=$Objstocktrans->id;
$Objaccounttrans1->bracid=auth()->user()->branchid;
$Objaccounttrans1->save();
// Inserting into inventory
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1113";//Fixed Account Inventory
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail)*-1;
$Objaccountinventory->ttype="C";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$headernumber;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
// Cost of Goods inserting // Remember its an expense
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1001";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$headernumber;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
}else{
   
    // if goods are sold on credit 
    // Inserting into inventory
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1113";//Fixed Account Inventory
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail)*-1;
$Objaccountinventory->ttype="C";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$headernumber;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
// Cost of Goods inserting // Remember its an expense
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1001";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=$this->getAmount($product->product_id,$product->quantity,$stockavail);
$Objaccountinventory->total=$this->getAmount($product->product_id,$product->quantity,$stockavail);;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$headernumber;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->save();
// Cash Paid is 
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="3600";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$product->name;
$Objaccountinventory->amount=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccountinventory->total=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccountinventory->purchaseheaderid=$headernumber;
$Objaccountinventory->stockidentify=$stockidentify;
$Objaccountinventory->stocktransid=$Objstocktrans->id;
$Objaccountinventory->bracid=auth()->user()->branchid;
$Objaccountinventory->save();
// sale of goods account
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$headernumber;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
// Accounts Recievable
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1111";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of on credit  ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->ttype="D";
$Objaccounttrans->total=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$headernumber;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
// Sale of goods 
// Accounts Recievable
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of on credit  ".$request['quantity']." ".$product->name." @ ".number_format($product->sellingpx,0);
$Objaccounttrans->amount=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->ttype="C";
$Objaccounttrans->total=($product->quantity*$product->sellingpx)-str_replace( ',', '',$request['cashpaid'])/$numberofproducts;
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['transdates']));
$Objaccounttrans->purchaseheaderid=$headernumber;
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->stocktransid=$Objstocktrans->id;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
}
    }
   $print= DB::select("select * from companys where isPrint=1");
   if(count($print)>0){
 $this->reciept(str_replace( ',', '',$request['cashpaid']),$request['bal']);
   }
    // PR
    //unset($_SESSION["shopping_cart"]);
    DB::statement("truncate table tbl_cart");
   //return view('barcodesales/index');      


}catch(\Exception $e){
    DB::rollBack();
    echo "Failed ".$e;
    
}
DB::commit();
}
}
