<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\newpurchases;
use App\invoices;
use App\chartofaccounts;
use App\accounttrans;
use App\purchaseheaders;
use App\expenseinvoices;
use App\stocks;
use App\stocktrans;
use App\availablestocks;
use App\recievedstocks;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

 class invoicesreportsController extends Controller{

public function invoiceadd($id){
    $adddetails= DB::select("SELECT format(sum(subtotal),0) as total, header,invoices.id as id, DATE_FORMAT(invoiceDate,'%d-%m-%Y') as invoiceDate,suppliers.companyName as suppliername FROM `invoices` inner join suppliers on suppliers.id=invoices.supplierName inner join newpurchases on newpurchases.invoice_no=invoices.id  group by newpurchases.invoice_no");
    return view("invoiceadd/index")->with('invoiceid',$id)->with('details',$adddetails);
}

public function saveinvoiceexpense(Request $request){

    DB::beginTransaction();
    try{
        // expense Invoices

        $Objexpenseinvoices = new expenseinvoices();
        $Objexpenseinvoices->amount=str_replace( ',', '',$request['amount']);
        $Objexpenseinvoices->invoice_header=$request['invoicexpid'];
        $Objexpenseinvoices->save();
// Accounting 
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode=$request['accountcode'];
$Objaccounttrans->narration=$request['narration'];
$Objaccounttrans->amount=str_replace( ',', '',$request['amount']);
$Objaccounttrans->ttype="D";
$Objaccounttrans->total=str_replace( ',', '',$request['amount']);
$Objaccounttrans->purchaseheaderid=$request['purchaseno'];
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans->invoice_xpid=$request['invoicexpid'];
$Objaccounttrans->invoice_id=$request['invoiceid'];
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
//Debiting remember its a double entry
$Objaccounttrans1= new accounttrans();
$objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();

$Objaccounttrans1= new accounttrans();
foreach($objchart as $obj){
$Objaccounttrans1->accountcode=$obj->accountcode;//cash account   
}
$Objaccounttrans1->narration=$request['narration'];
$Objaccounttrans1->amount=str_replace( ',', '',$request['amount']);;
$Objaccounttrans1->ttype="C";
$Objaccounttrans1->total=str_replace( ',', '',$request['amount'])*-1;
$Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans1->invoice_xpid=$request['invoicexpid'];
$Objaccounttrans1->purchaseheaderid=$request['purchaseno'];
$Objaccounttrans1->invoice_id=$request['invoiceid'];
$Objaccounttrans1->bracid=auth()->user()->branchid;
$Objaccounttrans1->save();

	
$lastid=DB::table('accounttrans')->orderBy('id','DESC')->first();
    echo json_encode(array(
        'narration' => $request['narration'],
        'amount' => $request['amount'],
        'accountcode' => $request['accountcode'],
        'Aid'=>$request['purchaseno'],
        'accounttransid'=>$lastid->id-1,
    ));
}catch(\Exception $e){
    DB::rollback();
    echo "Failed ".$e;
}

DB::commit();
}

public function saveinvoicesexp(Request $request){
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
    $maxid= DB::select("select max(id) as id from accounttrans");
    foreach($maxid as $max){
        $results_id= $max->id;
        $results2 = DB::select("select * from accounttrans where id =$results_id");
        foreach($results2 as $liz){
            $finalid= $liz->invoice_xpid;
            $resultamt=DB::select("select sum(amount) as amount from accounttrans where invoice_xpid=$finalid and ttype='D'");
            foreach($resultamt as $amt){
                $am= $amt->amount;
            DB::update("update expenseinvoices set amount=$am where invoice_header=$finalid");
            }
        }

    }
}catch(\Exception $e){
    echo "Failed to save ".$e;
    DB::rollBack();
}
DB::commit();
}

public function saveinvoicesexpedit(Request $request){
$accountcode=0;
    $id=$request['accounttransid'];
    DB::beginTransaction();
    try{

        $objchart=chartofaccounts::where('isDefault','=',1)->where('isInventory','=',1)->get();
        foreach($objchart as $obj){
$accountcode=$obj->accountcode;//cash account   
        }
        //Expense Account
    accounttrans::where('id','=',$id)->where('ttype','=','D')->update(['amount'=>str_replace( ',', '',$request['amount']),'total'=>str_replace( ',', '',$request['amount']),'narration'=>$request['narration'],'accountcode'=>$accountcode]);//->update(['narration'=>$request['naration']]);
    // Crediting Cash Account
    accounttrans::where('id','=',$id+1)->where('ttype','=','C')->update(['amount'=>str_replace( ',', '',$request['amount']),'total'=>str_replace( ',', '',$request['amount'])*-1,'narration'=>$request['narration'],'accountcode'=>$request['payingaccount']]);//->update(['narration'=>$request['naration']]);
    }catch(\Exception $e){
        DB::rollback();
        echo "Failed ".$e;
    }
    DB::commit();

}

public function stockentry($id){

    return view("stockentry/index")->with('id',$id);
}
###### 18 sept 21 
public function viewstockentry($id){
    $qty=0;
    $numberofitems=DB::select("select sum(newpurchases.qty) as qty from newpurchases where invoice_no=$id");
    foreach($numberofitems as $item){
        $qty=$item->qty;
    }
    
    return DB::select("select description,availablestocks.qty,category, category as categorycode,format(selling,0) as selling,limits , newpurchases.id as id, name,subtotal,expenseinvoices.amount,count(newpurchases.qty),expenseinvoices.amount/1 costitem,subtotal+expenseinvoices.amount/$qty as totalcost,format(round(expenseinvoices.amount/$qty+(subtotal/newpurchases.qty),0),0) as costperitem  from newpurchases inner join accounttrans on accounttrans.invoice_id=newpurchases.invoice_no  inner join expenseinvoices on expenseinvoices.invoice_header=accounttrans.invoice_xpid inner join availablestocks on availablestocks.item_id=newpurchases.id where invoice_no=$id and availablestocks.qty>0 group by newpurchases.id");

}

public function updatestockentry(Request $request){
    DB::beginTransaction();
    try{
$id=$request['id'];
DB::update("update newpurchases  set recqty=0,dmgqty=0,remarks='' where id=$id");
//DB::update("update availablestocks set qty=qty-$request[recqty],dmg=dmg+$request[dmgqty]  where item_id=$id");
if($request['dmgqty']>0){
    newpurchases::where("id","=",$id)->update([
        'description'=>$request['description'],
        'limits'=>$request['limits'],
        'category'=>$request['category'],
        'cost'=>str_replace( ',', '',$request['costperitem']),
        'selling'=>str_replace( ',', '',$request['selling']),
        'recqty'=>$request['recqty'],
        'dmgqty'=>$request['dmgqty'],
        'remarks'=>$request['remarks'],
    ]);
}
if($request['recqty']>0){
newpurchases::where("id","=",$id)->update([
    'description'=>$request['description'],
    'limits'=>$request['limits'],
    'category'=>$request['category'],
    'cost'=>str_replace( ',', '',$request['costperitem']),
    'selling'=>str_replace( ',', '',$request['selling']),
    'recqty'=>$request['recqty'],
    'dmgqty'=>$request['dmgqty'],
    'remarks'=>$request['remarks'],
]);
$lastid=DB::table('newpurchases')->orderBy('id','DESC')->first();
    echo json_encode(array(
        'description'=>$request['description'],
        'limit'=>$request['limits'],
        'category'=>$request['category'],
        'costperitem'=>str_replace( ',', '',$request['costperitem']),
        'selling'=>str_replace( ',', '',$request['selling']),
        'id'=>$id,
    ));
}
    }catch(\Exception $e){
        echo "Failed to work ".$e;
        DB::rollBack();
    }
    DB::commit();
}

public function savecalculatedstock(Request $request){
    DB::beginTransaction();
    try{
        $barcodeCounter=0;
$id= $request['id'];
$validatelimits= DB::select("select newpurchases.id as sid,recqty, description,category,cost, category as categorycode,format(selling,0) as selling,limits , newpurchases.id as id, name,qty,subtotal,expenseinvoices.amount,count(qty),expenseinvoices.amount/count(qty) costitem,subtotal+expenseinvoices.amount/count(qty) as totalcost,format(round((subtotal+(expenseinvoices.amount/count(qty)))/qty,0),0) as costperitem  from newpurchases inner join accounttrans on accounttrans.invoice_id=newpurchases.invoice_no  inner join expenseinvoices on expenseinvoices.invoice_header=accounttrans.invoice_xpid where invoice_no=$id and limits=0 group by newpurchases.id");
$validatedescription= DB::select("select newpurchases.id as sid, description,category,cost, category as categorycode,format(selling,0) as selling,limits , newpurchases.id as id, name,qty,subtotal,expenseinvoices.amount,count(qty),expenseinvoices.amount/count(qty) costitem,subtotal+expenseinvoices.amount/count(qty) as totalcost,format(round((subtotal+(expenseinvoices.amount/count(qty)))/qty,0),0) as costperitem  from newpurchases inner join accounttrans on accounttrans.invoice_id=newpurchases.invoice_no  inner join expenseinvoices on expenseinvoices.invoice_header=accounttrans.invoice_xpid where invoice_no=$id and description ='' group by newpurchases.id");
$validateselling= DB::select("select newpurchases.id as sid, description,category,cost, category as categorycode,format(selling,0) as selling,limits , newpurchases.id as id, name,qty,subtotal,expenseinvoices.amount,count(qty),expenseinvoices.amount/count(qty) costitem,subtotal+expenseinvoices.amount/count(qty) as totalcost,format(round((subtotal+(expenseinvoices.amount/count(qty)))/qty,0),0) as costperitem  from newpurchases inner join accounttrans on accounttrans.invoice_id=newpurchases.invoice_no  inner join expenseinvoices on expenseinvoices.invoice_header=accounttrans.invoice_xpid where invoice_no=$id and selling =0 group by newpurchases.id");
if(count($validateselling)==0){
    if(count($validatedescription)==0){
        if(count($validatelimits)==0){
$stockcal= DB::select("select header,newpurchases.id as sid,price, remarks,recqty,dmgqty,description,category,cost, category as categorycode,format(selling,0) as selling,limits , newpurchases.id as id, name,qty,subtotal,expenseinvoices.amount,count(qty),expenseinvoices.amount/count(qty) costitem,subtotal+expenseinvoices.amount/count(qty) as totalcost,format(round((subtotal+(expenseinvoices.amount/count(qty)))/qty,0),0) as costperitem  from newpurchases inner join accounttrans on accounttrans.invoice_id=newpurchases.invoice_no  inner join expenseinvoices on expenseinvoices.invoice_header=accounttrans.invoice_xpid where invoice_no=$id group by newpurchases.id");
foreach ($stockcal as $stockcalled){
    $qtyupdate=$stockcalled->recqty;
    $dmgupdate=$stockcalled->dmgqty;
    $updateid=$stockcalled->sid;

    // Savings in purchaseheaders
    $today=date("Y-m-d"); 
    $Objpurchaseheader= new purchaseheaders();
    $Objpurchaseheader->transdates=date("Y-m-d", strtotime($request['asof']));
    $Objpurchaseheader->branch_id=auth()->user()->branchid;
    $Objpurchaseheader->save();

    $objnewpass= newpurchases::find($stockcalled->sid);
    $objnewpass->isSave=1;
    $objnewpass->save();
    //DB::update("update newpurchases set isSave=1 where id")
    $bra=auth()->user()->branchid;
    $branch=DB::select('select id from branches');
    $max=DB::select('select count(id) as id from stocks');
    $number=0;
    $generalcode=0;
    $GenBarCode=0;
    foreach($max as $k){
$number=$k->id;
    }
    // Generating the barcode number
    $genbarcode=DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='rockaboy' AND TABLE_NAME='stocks'");
    foreach($genbarcode as $code){
        $GenBarCode=$code->id;
    }
    foreach($branch as $r){

      // if($r->id==$request['branch_id']){
           //continue;
        $padded = str_pad((string)$GenBarCode+$barcodeCounter, 14, "0", STR_PAD_LEFT); 
        // if name already exits 
// Working on barcode printers 
         if($stockcalled->recqty>0){
             $a=1;
             for($a;$a<=$stockcalled->recqty;$a++){
            $this->printbarcode($stockcalled->name,$stockcalled->selling,$padded);
             }
         }

        if(count(DB::select("select * from stocks where saveid=$updateid"))<1){
        $Objstocks=new stocks();
        //$Objstocks->id=$request['id'];
        $Objstocks->name=$stockcalled->name;
        $Objstocks->barcode=$padded;
        $Objstocks->saveid=$stockcalled->sid;
        $Objstocks->stockheader=$stockcalled->header;
        $Objstocks->description=$stockcalled->description;
        $Objstocks->partno='';
        if($stockcalled->categorycode==''){
            $Objstocks->category=1;
        }else{
        $Objstocks->category=$stockcalled->categorycode;
        }
        if($request['groupitem']==''){
            $Objstocks->groupitem=1;  
        }else{
            $Objstocks->groupitem=$request['groupitem'];
        }
        $Objstocks->subcategory=$request['subcategory'];
        $cleanstockcode=preg_replace('/[^A-Za-z0-9\-]/', '',$stockcalled->name."-".$number);
        $Objstocks->stockcode=$cleanstockcode;
        $this->stkcode=$cleanstockcode;
        $Objstocks->branch_id=$r->id;
        if($r->id==auth()->user()->branchid){
            $numbex=1;
            $num=DB::select("select isActive from uoms where id=$numbex");
            foreach($num as $n){
                //echo $n['isActive'];
                $num=$stockcalled->recqty;
                $whole = (int) $num;  // 5
                $frac  = $num - $whole;
               //echo $this->decimaltoInt($frac)*$frac+$whole;
              
                $this->branchcode=auth()->user()->branchid;
                if($n->isActive>1){
                    $Objstocks->openingstock=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
                    //$Objstocks->buyingrate= str_replace( ',', '',$request['buyingrate'])/(($whole+$frac)*$n->isActive);
                }else{
                    
                    $Objstocks->openingstock=$stockcalled->recqty*$n->isActive;
                    
                }
                
          

            }
       

        }
       // $Objstocks->openingstock=$request['openingstock'];
       $numbex=1;
            $num=DB::select("select isActive from uoms where id=$numbex");
            foreach($num as $n){
                //echo $n['isActive'];
               
            }
        $Objstocks->limitlevel=$stockcalled->limits;
        $Objstocks->buyingrate=str_replace( ',', '',$stockcalled->cost);
        $Objstocks->buyingrateitem=$stockcalled->cost;
        $Objstocks->sellingrate=str_replace( ',', '',$stockcalled->selling);
        $Objstocks->wholeprice=$request['wholeprice'];
        $Objstocks->wholeitemp=$request['wholeitem'];
        $Objstocks->unitofmeasure=1;
        $Objstocks->isActive=1;
        $Objstocks->openingstok=$stockcalled->recqty;
        $Objstocks->created_at=$request['created_at'];
        $Objstocks->updated_at=$request['updated_at'];
        $Objstocks->delhead=$Objpurchaseheader->id;
        $Objstocks->save();

     //}
    }
    
    }

// saving in stocktrans
$Objstocktrans= new stocktrans();
$itmcode=0;
//$branch=auth()->user()->branchid;
if(count(DB::select("select * from stocks where saveid=$updateid"))>0){
    $itemcode=DB::select("select id from stocks where saveid=$updateid AND branch_id=$bra");
    foreach($itemcode as $code){
        $this->itmcode=$code->id;
       
    }
}else{
$itemcode=DB::select("select id from stocks where stockcode='$this->stkcode' AND branch_id=$bra");
foreach($itemcode as $code){
    $this->itmcode=$code->id;
   
}
}
$numbex=1;
            $num=DB::select("select isActive from uoms where id=$numbex");
            foreach($num as $n){
                $num=$stockcalled->recqty;
                $whole = (int) $num;  // 5
                $frac  = $num - $whole;
                $doneqty=0;
                $ifdone=DB::select("select qty from availablestocks where item_id=$updateid");
                foreach($ifdone as $done){
                    $doneqty=$done->qty;
                }
                if($doneqty>0){
                if($n->isActive>1){
              $Objstocktrans->quantity=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
              $Objstocktrans->qua=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
                }else{
             $Objstocktrans->quantity=$stockcalled->recqty*$n->isActive; 
             $Objstocktrans->qua=$stockcalled->recqty*$n->isActive;    
                }
            }
                
            
        }
$Objstocktrans->type="I";
$Objstocktrans->branchno=auth()->user()->branchid;
$Objstocktrans->isInput=1;
$Objstocktrans->buyingrate=str_replace( ',', '',$stockcalled->cost);
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['asof']));
$Objstocktrans->stockname= $this->itmcode;
if($request['purchaseno']==0){
    $Objstocktrans->purchaseheaderid=$stockcalled->header; 
    $Objstocktrans->delheader=$Objpurchaseheader->id;
}else{
$Objstocktrans->purchaseheaderid=$stockcalled->header;
$Objstocktrans->delheader=$Objpurchaseheader->id;
}
$Objstocktrans->save();


// get quantity 
$numbex=1;
$num=DB::select("select isActive from uoms where id=$numbex");
foreach($num as $n){


// Debiting inventory
foreach($branch as $r){
    if($r->id==auth()->user()->branchid){

        if($stockcalled->dmgqty>0 || $stockcalled->recqty>0){
            $objrecievedstocks= new recievedstocks();
            $objrecievedstocks->qty=$stockcalled->dmgqty+$stockcalled->recqty;
            $objrecievedstocks->date=date("Y-m-d", strtotime($request['asof']));
            $objrecievedstocks->item_code=$this->itmcode;
            $objrecievedstocks->purchaseNo=$Objpurchaseheader->id;
            $objrecievedstocks->remarks=$stockcalled->remarks;
            $objrecievedstocks->save();

        }
        if($stockcalled->dmgqty>0){


            // Crediting inventory 
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1994";
$objaccounttrans->narration="Damaged goods @".$stockcalled->dmgqty." ".$stockcalled->name;
$objaccounttrans->amount=str_replace( ',', '',$stockcalled->price)*$stockcalled->dmgqty;
$objaccounttrans->total=str_replace( ',', '',$stockcalled->price)*$stockcalled->dmgqty*-1;
$objaccounttrans->ttype="C"; 
$objaccounttrans->invoice_id=$Objpurchaseheader->id;
$objaccounttrans->purchaseheaderid=$Objpurchaseheader->id;
$objaccounttrans->bracid=auth()->user()->branchid;
$objaccounttrans->isInput=1;
$objaccounttrans->invoice_xpid=$stockcalled->header;
$objaccounttrans->transdate=date("Y-m-d", strtotime($request['asof']));
$objaccounttrans->save();
// Debiting expense accouding
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1993";
$objaccounttrans->narration="Damaged goods @".$stockcalled->dmgqty." ".$stockcalled->name;
$objaccounttrans->amount=str_replace( ',', '',$stockcalled->price)*$stockcalled->dmgqty;
$objaccounttrans->total=str_replace( ',', '',$stockcalled->price)*$stockcalled->dmgqty;
$objaccounttrans->ttype="D"; 
$objaccounttrans->invoice_id=$Objpurchaseheader->id;
$objaccounttrans->purchaseheaderid=$Objpurchaseheader->id;
$objaccounttrans->bracid=auth()->user()->branchid;
$objaccounttrans->isInput=1;
$objaccounttrans->invoice_xpid=$stockcalled->header;
$objaccounttrans->transdate=date("Y-m-d", strtotime($request['asof']));
$objaccounttrans->save();

        }
        if($stockcalled->recqty>0){
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1113";
$objaccounttrans->narration="stock in  of ".$stockcalled->recqty. " ".$stockcalled->name;
$numbex=1;
$num=DB::select("select isActive from uoms where id=$numbex");
foreach($num as $n){
    //echo $n['isActive'];
    $num1=$stockcalled->recqty;
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
   
    if($n->isActive>0){
$objaccounttrans->amount=str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty;
$objaccounttrans->total=str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty;
    }else{
$objaccounttrans->amount=str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty;
$objaccounttrans->total=str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty;
    }
}

$objaccounttrans->ttype="D"; 
$objaccounttrans->invoice_id=$Objpurchaseheader->id;
$objaccounttrans->purchaseheaderid=$Objpurchaseheader->id;
// geting the id of the entered item
$itemid=DB::select("select id from stocks where branch_id=$r->id order by id desc limit 1");
foreach($itemid as $item){
$objaccounttrans->stockidentify=$item->id;
//echo $item->id;
}
$objaccounttrans->bracid=auth()->user()->branchid;
$objaccounttrans->isInput=1;
$objaccounttrans->invoice_xpid=$stockcalled->header;
$objaccounttrans->transdate=date("Y-m-d", strtotime($request['asof']));
$objaccounttrans->save();
//Crediting Captial 
$objaccounttrans1= new accounttrans();
$objaccounttrans1->accountcode="1994";
$objaccounttrans1->invoice_id=$Objpurchaseheader->id;
$objaccounttrans1->invoice_xpid=$stockcalled->header;
$objaccounttrans1->narration="stock in ".$stockcalled->name;
$numbex=1;
$num=DB::select("select isActive from uoms where id=$numbex");
foreach($num as $n){
    //echo $n['isActive'];
    $num1=$stockcalled->recqty;
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
   
    if($n->isActive>0){
$objaccounttrans1->amount=str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty;
$objaccounttrans1->total=(str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty)*-1;
    }else{
$objaccounttrans1->amount=str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty;
$objaccounttrans1->total=(str_replace( ',', '',$stockcalled->price)*$stockcalled->recqty)*-1;
    }
}
$objaccounttrans1->ttype="C"; 
$objaccounttrans1->purchaseheaderid=$Objpurchaseheader->id;
// geting the id of the entered item
$itemid=DB::select("select id from stocks where branch_id=$r->id order by id desc limit 1");
foreach($itemid as $item){
$objaccounttrans1->stockidentify=$item->id;
}
$objaccounttrans1->isInput=1;
$objaccounttrans1->bracid=auth()->user()->branchid;
$objaccounttrans1->transdate=date("Y-m-d", strtotime($request['asof']));
$objaccounttrans1->save();
    }

}
}

}


DB::update("update availablestocks set qty=qty-($qtyupdate+$dmgupdate),dmg=dmg+$dmgupdate  where item_id=$updateid");  
$barcodeCounter= $barcodeCounter+1; 

}
        }else{
            return['limits'=>false];   
        }
    }else{
        return['description'=>false];     
    }
}else{
    return['sellingPrice'=>false];
}
DB::update("update newpurchases set recqty=0");

}catch(\Exception $e){
    echo "failed to run".$e;
    DB::rollBack();
}
DB::commit();
}

public function recievedstock(){
    return view('recievedstock/index');
}
public function decimaltoInt($f){
    $ans=strlen(strrchr($f, '.')) -1;
    if($ans==1){
        return 10;
    }else if($ans==2){
        return 100;
    }
    else if($ans==3){
        return 1000;
    }
}

public function printbarcode($name,$sellingrate,$barcode){
    try {
        $print= DB::select("select * from companys where isPrint=1");
        if(count($print)>0){
       // Enter the share name for your USB printer here
        $connector = new CupsPrintConnector("MainLabelPrinter");
        $printer = new Printer($connector);

        
        $printer -> text("
        ^XA


^CF0,30
^FO260,10^FD".$name."^FS
^FO260,50^FDUGX". $sellingrate."^FS


^FX Third section with barcode.

^BY2,3,75
^FO260,80^B2^FD".$barcode."^FS



^XZ



        ");
        $printer -> close();
        }      
    } catch(Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }

}
}