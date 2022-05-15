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

class salesconversionController extends Controller
{
    //
    public function salesconversion(){
        return view('salesconversion/index');
    }
    public function editsconversion(){
        return view('salesconversion/edit');
    }
    public function saveconversion(Request $request){
        DB::beginTransaction();
        $stockidentify=0;
        $productin=0;
        $productout=0;
        $sellingin=0;
        $sellingout=0;
        $loop=0;
        $looppdtout=0;
        try{

          foreach ($_SESSION["shopping_cart"] as $product){

            if($product['quantity']==1){
                $pdt1=1;
        $productin=$productin+($product['buyingrate']*$product['realquantity']);
        $sellingin=$sellingin+($product['sellingrate']*$product['realquantity']);
            }else if($product['quantity']==2){
                $pdt2=2;
         $productout=$productout+($product['buyingrate']*$product['realquantity']);
         $sellingout=$sellingout+($product['sellingrate']*$product['realquantity']);
         $looppdtout=$looppdtout+1;
            }
        $loop=$loop+1;
          }
         // echo  "The first is ".$productin."<br> The second option is ".$productout;
         if($loop>20){
             return ['excess'=>'yes'];

         }
          else if($productin==0 || $productout==0){
return ['items'=>'No'];
          }else if($sellingout<$sellingin){
              return['exchange'=>'no'];
          }
          else{
          $Objpurchaseheaders=new purchaseheaders();
          $Objpurchaseheaders->transdates=date("Y-m-d", strtotime($request['transdates']));
          $Objpurchaseheaders->branch_id=auth()->user()->branchid;
          $Objpurchaseheaders->isActive=1;
          $Objpurchaseheaders->save();
          echo "Product in cost price is ".$productin."<br>Product Out cost price is ".$productout;
          if($productout>$productin){
              echo ($productout-$productin);
          }
        foreach ($_SESSION["shopping_cart"] as $product){

            if($product['quantity']==1){
                $Objstocktrans=new stocktrans();
                $Objstocktrans->purchaseheaderid=$Objpurchaseheaders->id;
                $Objstocktrans->transdate=date("Y-m-d", strtotime($request['transdates']));
                $Objstocktrans->stockname=$product['code'];
                $Objstocktrans->totalamt=0;
                $Objstocktrans->quantity=$product['realquantity']; 
                $Objstocktrans->qua=$this->getQuantity($product['code']);
                $Objstocktrans->type="I";
                $Objstocktrans->customer="";
                $Objstocktrans->branchno=auth()->user()->branchid;
                $Objstocktrans->totalpaid=$product['buyingrate']*$product['realquantity'];
                $Objstocktrans->totaldue=$product['buyingrate']*$product['realquantity'];
                $Objstocktrans->sellingrate=0;
               $Objstocktrans->buyingrate=$product['buyingrate']*$product['realquantity'];
                $Objstocktrans->save();
            }else if($product['quantity']==2){
                $Objstocktrans=new stocktrans();
                $Objstocktrans->purchaseheaderid=$Objpurchaseheaders->id;
                $Objstocktrans->transdate=date("Y-m-d", strtotime($request['transdates']));
                $Objstocktrans->stockname=$product['code'];
                $Objstocktrans->totalamt=0;
                $Objstocktrans->quantity=$product['realquantity'];
                $Objstocktrans->type="O";
                $Objstocktrans->customer=1;
                $Objstocktrans->branchno=auth()->user()->branchid;
                $Objstocktrans->totalpaid=str_replace(',','',$request['totalcost'])/$looppdtout;
                //$Objstocktrans->totaldue=$request['totaldue'];
               $Objstocktrans->sellingrate=str_replace(',','',$request['totalcost'])/$looppdtout;
                
                if($productout>$productin && abs(($productout-$productin))!=0){
                    $Objstocktrans->buyingrate=abs(($productout-$productin))/$looppdtout;
                   }else if($productout<$productin && abs(($productout-$productin))!=0){
                    $Objstocktrans->buyingrate=abs(($productout-$productin));
                   }else{
                    $Objstocktrans->buyingrate=0;
                   }
                $Objstocktrans->save();
                
            }
        }
            if(str_replace(',','',$request['totalcost'])>0){
                
                    //Debiting remember its a double entry
    $Objaccounttrans1= new accounttrans();
    $Objaccounttrans1->accountcode=3600;//cash account
    $Objaccounttrans1->narration="Sale Conversion ";
    $Objaccounttrans1->amount=str_replace(',','',$request['totalcost']);
    $Objaccounttrans1->ttype="D";
    $Objaccounttrans1->total=str_replace(',','',$request['totalcost']);
    $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccounttrans1->stockidentify=$stockidentify;
    $Objaccounttrans1->bracid=auth()->user()->branchid;
    $Objaccounttrans1->save();

                        //Crediting Sale of Goods 
    $Objaccounttrans1= new accounttrans();
    $Objaccounttrans1->accountcode=1000;//cash account
    $Objaccounttrans1->narration="Sale Conversion ";
    $Objaccounttrans1->amount=str_replace(',','',$request['totalcost']);
    $Objaccounttrans1->ttype="C";
    $Objaccounttrans1->total=str_replace(',','',$request['totalcost']);
    $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
    $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
    $Objaccounttrans1->stockidentify=$stockidentify;
    $Objaccounttrans1->bracid=auth()->user()->branchid;
    $Objaccounttrans1->save();
    // if the cost of buying good of the to be taken is greater than that one returned ..
    if($productout>$productin && abs(($productout-$productin))!=0){
        // INventory Accounts 
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1113;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=($productout-$productin);
        $Objaccounttrans1->ttype="C";
        $Objaccounttrans1->total=($productout-$productin)*-1;
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
        //Sale of Goods Account
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1001;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=($productout-$productin);
        $Objaccounttrans1->ttype="D";
        $Objaccounttrans1->total=($productout-$productin);
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
        echo ($productout-$productin);
    }else if($productout<$productin && abs(($productout-$productin))!=0){
        ($productout-$productin);
                // INventory Accounts 
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1113;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=abs(($productout-$productin));
        $Objaccounttrans1->ttype="D";
        $Objaccounttrans1->total=abs(($productout-$productin));;
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
        //Sale of Goods Account
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1001;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=abs(($productout-$productin));
        $Objaccounttrans1->ttype="C";
        $Objaccounttrans1->total=abs(($productout-$productin))*-1;
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
    }

                
            }else if(str_replace(',','',$request['totalcost'])==0){
    // if the cost of buying good of the to be taken is greater than that one returned ..
    if($productout>$productin && abs(($productout-$productin))!=0 ){
        // INventory Accounts 
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1113;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=($productout-$productin);
        $Objaccounttrans1->ttype="C";
        $Objaccounttrans1->total=($productout-$productin)*-1;
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
        //Sale of Goods Account
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1001;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=($productout-$productin);
        $Objaccounttrans1->ttype="D";
        $Objaccounttrans1->total=($productout-$productin);
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
        echo ($productout-$productin);
    }else if($productout<$productin && abs(($productout-$productin))!=0){
        ($productout-$productin);
                // INventory Accounts 
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1113;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=abs(($productout-$productin));
        $Objaccounttrans1->ttype="D";
        $Objaccounttrans1->total=abs(($productout-$productin));;
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
        //Sale of Goods Account
        $Objaccounttrans1= new accounttrans();
        $Objaccounttrans1->accountcode=1001;//cash account
        $Objaccounttrans1->narration="Sale Conversion ";
        $Objaccounttrans1->amount=abs(($productout-$productin));
        $Objaccounttrans1->ttype="C";
        $Objaccounttrans1->total=abs(($productout-$productin))*-1;
        $Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['transdates']));
        $Objaccounttrans1->purchaseheaderid=$Objpurchaseheaders->id;
        $Objaccounttrans1->stockidentify=$stockidentify;
        $Objaccounttrans1->bracid=auth()->user()->branchid;
        $Objaccounttrans1->save();
    }

                
            
            }

    
        
        unset($_SESSION["shopping_cart"]);
       //return view('barcodesales/index');
        }
    }catch(\Exception $e){
        DB::rollBack();
        echo "Failed ".$e;
        
    }
    DB::commit();
    }
    public function getQuantity($id){
        $total=0;
        $results=DB::select("select sum(quantity) as quantity from stocktrans inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id where type='I' and stockname=$id");
        foreach($results as $rs){
            $total=$total+$rs->quantity;
        }
return $total;
    }
}
