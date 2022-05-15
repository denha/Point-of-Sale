<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\stocktrans;
use App\accounttrans;
use App\stockbals;
use App\purchaseheaders;
use App\transfers;

 class stocktransController extends Controller{

public function index(){
    return view('stocktrans/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from stocktrans ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from stocktrans limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
        $branch=auth()->user()->branchid;
    $stockidentify=0;
    $Objstocktrans=new stocktrans();
$Objstocktrans->id=$request['id'];
//$Objstocktrans->purchaseheaderid=$request['purchaseheaderid'];
//$Objstocktrans->transdate=$request['transdate'];
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objstocktrans->purchaseheaderid=$request['purcnumber'];
$Objstocktrans->stockname=$request['productid'];
$Objstocktrans->totalamt=$request['totalamt'];
if($request['price']==1){
$Objstocktrans->quantity=$request['quantity']*$request['number'];
$Objstocktrans->qua=$this->getStockQua($request['productid'])+ $request['quantity'];
}else{
    $Objstocktrans->quantity=$request['quantity']; 
    $Objstocktrans->qua=$this->getStockQua($request['productid'])+ $request['quantity'];
}
$Objstocktrans->type="I";
$Objstocktrans->totalpaid=$request['totalpaid'];
$Objstocktrans->branchno=$branch;
$Objstocktrans->totaldue=$request['totaldue'];
$Objstocktrans->buyingrate=$request['buyingrate'];
$Objstocktrans->created_at=$request['created_at'];
$Objstocktrans->updated_at=$request['updated_at'];
$Objstocktrans->branchno=auth()->user()->branchid;
$Objstocktrans->save();
$stockidentify=$Objstocktrans->id;
//Inserting into stockbals
if($request['totaldue']>0){
    $stockbals= new stockbals();
    $stockbals->headno=$request['purcnumber'];
    $stockbals->balance=$request['totaldue'];
    $stockbals->stocktransid=$Objstocktrans->id;
    $stockbals->save();
    }
// updating stock table
$qty=$request['quantity'];
$name=$request['stockid'];
$branch_id=$request['branch_id'];
//DB::update("update stocks set openingstock=openingstock+$qty where name='$name' AND branch_id=$branch_id");

// Accounting 
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1113";//Inventory
$Objaccounttrans->narration="Purchase of ".$request['quantity']." ".$request['stockid'];
$Objaccounttrans->amount=$request['totalpaid'];
$Objaccounttrans->ttype="D";
$Objaccounttrans->total=$request['totalpaid'];
$Objaccounttrans->purchaseheaderid=$request['purcnumber'];
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans->stockidentify=$stockidentify;
$Objaccounttrans->bracid=auth()->user()->branchid;
$Objaccounttrans->save();
//Debiting remember its a double entry
$Objaccounttrans1= new accounttrans();
$Objaccounttrans1->accountcode=$request['paccount'];//Fixed Account for sale of goods
$Objaccounttrans1->narration="Purchase of ".$request['quantity']." ".$request['stockid'];
$Objaccounttrans1->amount=$request['totalpaid'];
$Objaccounttrans1->ttype="C";
$Objaccounttrans1->total=$request['totalpaid']*-1;
$Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans1->stockidentify=$stockidentify;
$Objaccounttrans1->purchaseheaderid=$request['purcnumber'];
$Objaccounttrans1->bracid=auth()->user()->branchid;
$Objaccounttrans1->save();



//Accounts Recievable
if($request['totaldue']>0){
    $Objaccounttrans2= new accounttrans();
    $Objaccounttrans2->accountcode="1112";//Fixed Account Accounts Payable
    $Objaccounttrans2->narration="Purchase of ".$request['quantity']." ".$request['stockid']." on Credit";
    $Objaccounttrans2->amount=$request['totaldue'];
    $Objaccounttrans2->ttype="C";
    $Objaccounttrans2->transdate=date("Y-m-d", strtotime($request['date']));
    $Objaccounttrans2->purchaseheaderid=$request['purcnumber'];
    $Objaccounttrans2->stockidentify=$stockidentify;
    $Objaccounttrans2->bracid=auth()->user()->branchid;
    $Objaccounttrans2->total=$request['totaldue'];
    
    $Objaccounttrans2->save();

    $Objaccounttrans3= new accounttrans();
    $Objaccounttrans3->accountcode="1113";//Inventory Account
    $Objaccounttrans3->narration="Purchase of ".$request['quantity']." ".$request['productid']." on Credit";
    $Objaccounttrans3->amount=$request['totaldue'];
    $Objaccounttrans3->ttype="D";
    $Objaccounttrans3->total=$request['totaldue'];
    $Objaccounttrans3->purchaseheaderid=$request['purcnumber'];
    $Objaccounttrans3->credit=1;
    $Objaccounttrans3->transdate=date("Y-m-d", strtotime($request['date']));
    $Objaccounttrans3->stockidentify=$stockidentify;
    $Objaccounttrans3->bracid=auth()->user()->branchid;
    $Objaccounttrans3->save();

}

    }catch(\Exception $e){
        DB::rollback();
        return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));   
    }
    DB::commit();
// returning fields back to the grid
echo json_encode(array(
    'stockid'=>$request['stockid'],
	'totalpaid' => $request['totalpaid'],
	'totalamt' => $request['totalamt'],
    'totaldue' => $request['totaldue'],
    'quantity'=>$request['quantity'],
    'buyingrate'=>$request['buyingrate'],
    'purcnumber'=>$request['purcnumber'],
    'branch_id'=>$request['branch_id'],
    'productid'=>$request['productid'],
    'paccount'=>$request['paccount'],
    'date'=>$request['date'],
    'wholecost'=>$request['wholecost'],
    'onecost'=>$request['onecost'],
    'number'=>$request['number'],
    'id'=>$Objstocktrans->id,
    'isError'=>false,



));
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objstocktrans=stocktrans::find($id);

$Objstocktrans->id=$request['id'];
$Objstocktrans->purchaseheaderid=$request['purchaseheaderid'];
$Objstocktrans->transdate=$request['transdate'];
$Objstocktrans->stockid=$request['stockid'];
$Objstocktrans->quantity=$request['quantity'];
$Objstocktrans->totalpaid=$request['totalpaid'];
$Objstocktrans->totaldue=$request['totaldue'];
$Objstocktrans->sellingrate=$request['sellingrate'];
$Objstocktrans->created_at=$request['created_at'];
$Objstocktrans->updated_at=$request['updated_at'];
$Objstocktrans->save();
}
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
        }else{
        DB::delete("delete from stocktrans where purchaseheaderid=$id");
        DB::delete("delete from purchaseheaders where id=$id");
        DB::delete("delete from accounttrans where purchaseheaderid=$id");
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
    public function destroystocks($id){
        DB::beginTransaction();
     try{
        $Objstocktrans=stocktrans::where('id','=',$id)->delete();
       
		if($id=='undefined'){
			
		}else{
			$Objaccounttrans=accounttrans::where('stockidentify','=',$id)->delete();
		}
    }catch(\Exception $e){
        DB::rollback();
        return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));   
    }
    DB::commit();



    }
public function delxp($id){
    DB::beginTransaction();
    try{
    		if($id=='undefined'){
			
		}else{
    
        $del=accounttrans::where('id','=',$id)->get();
    foreach($del as $d){
       // allsavings::where('headerid','=',$d->purchaseheaderid)->delete();
        
    }
    accounttrans::where('id','=',$id)->delete();
       
   accounttrans::where('id','=',$id+1)->delete();
		}
    }catch(\Exception $e){
        DB::rollBack();
        echo "Failed ".$e;
    }
   DB::commit();

   
}
public function viewcombo(){


    return stocktrans::all();
}

public function savesales(Request $request){
    //Error Messages
    DB::beginTransaction();
    try{

    $stocktrans="";
    $Objstocktrans=new stocktrans();
    $Objstocktrans->id=$request['id'];
    $stockidentify=0;
//$Objstocktrans->purchaseheaderid=$request['purchaseheaderid'];
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));

$Objstocktrans->purchaseheaderid=$request['purcnumber'];
$Objstocktrans->stockname=$request['productid'];
$Objstocktrans->totalamt=$request['totalamt'];
if($request['price']==2){
    $Objstocktrans->quantity=$request['quantity']*$request['wholeitem'];   
}else{
$Objstocktrans->quantity=$request['quantity'];
}
$Objstocktrans->type="O";
$Objstocktrans->totalpaid=$request['totalpaid'];
$Objstocktrans->totaldue=$request['totaldue'];
$Objstocktrans->sellingrate=$request['sellingrate'];
$Objstocktrans->created_at=$request['created_at'];
$Objstocktrans->updated_at=$request['updated_at'];
if($Objstocktrans->save()){
    
}else{
    $stocktrans="Not Saved";   
}
$stockidentify=$Objstocktrans->id;
//Inserting into stockbals
if($request['totaldue']>0){
    $stockbals= new stockbals();
    $stockbals->headno=$request['purcnumber'];
    $stockbals->balance=$request['totaldue'];
    $stockbals->save();
    }
// updating stock table
$qty=$request['quantity'];
$name=$request['stockid'];
$branch_id=$request['branch_id'];
//DB::update("update stocks set openingstock=openingstock-$qty where name='$name' AND branch_id=$branch_id");
// Accounting 
$Objaccounttrans= new accounttrans();
$Objaccounttrans->accountcode="1000";//Fixed Account for sale of goods
$Objaccounttrans->narration="Sale of ".$request['quantity']." ".$request['stockid']." @ ".number_format($request['sellingrate'],0);
$Objaccounttrans->amount=$request['totalpaid'];
$Objaccounttrans->ttype="C";
$Objaccounttrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans->purchaseheaderid=$request['purcnumber'];
$Objaccounttrans->stockidentify=$stockidentify;
if($Objaccounttrans->save()){

}else{
    $stocktrans="Not Saved";  
}
//Debiting remember its a double entry
$Objaccounttrans1= new accounttrans();
$Objaccounttrans1->accountcode=$request['raccount'];//cash account
$Objaccounttrans1->narration="Sale of ".$request['quantity']." ".$request['stockid']." @ ".number_format($request['sellingrate'],0);
$Objaccounttrans1->amount=$request['totalpaid'];
$Objaccounttrans1->ttype="D";
$Objaccounttrans1->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccounttrans1->purchaseheaderid=$request['purcnumber'];
$Objaccounttrans1->stockidentify=$stockidentify;
if($Objaccounttrans1->save()){

}else{
    $stocktrans="Not Saved";  
}

// Inserting into inventory
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1113";//Fixed Account Inventory
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$request['stockid'];
if($request['price']==2){
$Objaccountinventory->amount=$request['buyingrate']*$request['quantity'];
}else{
    $Objaccountinventory->amount=$request['buyingrateitem']*$request['quantity'];  
}
$Objaccountinventory->ttype="C";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccountinventory->purchaseheaderid=$request['purcnumber'];
$Objaccountinventory->stockidentify=$stockidentify;
if($Objaccountinventory->save()){

}else{
    $stocktrans="Not Saved";  
}
// Cost of Goods inserting // Remember its an expense
$Objaccountinventory= new accounttrans();
$Objaccountinventory->accountcode="1001";//Cost of Goods
$Objaccountinventory->narration="Sale of ".$request['quantity']." ".$request['stockid']." @ ".number_format($request['sellingrate'],0);
if($request['price']==2){
$Objaccountinventory->amount=$request['buyingrate']*$request['quantity'];
}else{
    $Objaccountinventory->amount=$request['buyingrateitem']*$request['quantity']; 
}
$Objaccountinventory->ttype="D";
$Objaccountinventory->transdate=date("Y-m-d", strtotime($request['date']));
$Objaccountinventory->purchaseheaderid=$request['purcnumber'];
$Objaccountinventory->stockidentify=$stockidentify;
if($Objaccountinventory->save()){

}else{
    $stocktrans="Not Saved";  
}
//Accounts Recievable
if($request['totaldue']>0){
    $Objaccounttrans2= new accounttrans();
    $Objaccounttrans2->accountcode="1111";//Fixed Account Accounts Recievables
    $Objaccounttrans2->narration="Sale of ".$request['quantity']." ".$request['stockid']." on Credit";
    $Objaccounttrans2->amount=$request['totaldue'];
    $Objaccounttrans2->ttype="D";
    $Objaccounttrans2->transdate=date("Y-m-d", strtotime($request['date']));
    $Objaccounttrans2->purchaseheaderid=$request['purcnumber'];
    $Objaccounttrans2->stockidentify=$stockidentify;
    if($Objaccounttrans2->save()){

    }else{
        $stocktrans="Not Saved";  
    }

    $Objaccounttrans3= new accounttrans();
    $Objaccounttrans3->accountcode="1000";//Fixed Account Sale of Goods
    $Objaccounttrans3->narration="Sale of ".$request['quantity']." ".$request['stockid']." on Credit";
    $Objaccounttrans3->amount=$request['totaldue'];
    $Objaccounttrans3->ttype="C";
    $Objaccounttrans3->transdate=date("Y-m-d", strtotime($request['date']));
    $Objaccounttrans3->credit=1;
    $Objaccounttrans3->purchaseheaderid=$request['purcnumber'];
    $Objaccounttrans3->stockidentify=$stockidentify;
    if($Objaccounttrans3->save()){
        $stocktrans="Not Saved";  
    }


}
    }catch(\Exception $e){
        DB::rollback();
        return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));
        //$stocktrans="Not Saved";
    } 
    DB::commit();  
//Rollback
    // returning fields back to the grid
    echo json_encode(array(
        'stockid'=>$request['stockid'],
        'totalpaid' => $request['totalpaid'],
        'totalamt' => $request['totalamt'],
        'totaldue' => $request['totaldue'],
        'quantity'=>$request['quantity'],
        'sellingrate'=>$request['sellingrate'],
        'buyingrate'=>$request['buyingrate'],
        'purcnumber'=>$request['purcnumber'],
        'branch_id'=>$request['branch_id'],
        'productid'=>$request['productid'],
        'raccount'=>$request['raccount'],
        'date'=>$request['date'],
        'wholesale'=>$request['wholesale'],
        'retail'=>$request['retail'],
        'wholeitem'=>$request['wholeitem'],
        'wholeitemp'=>$request['wholeitemp'],
        'buyingrateitem'=>$request['buyingrateitem'],
        'id'=>$Objstocktrans->id,
        'isError'=>false,
    
    
    
    ));

}
public function viewstock($id){
    //return stocktrans::where('purchaseheaderid',$id)->get();
    return DB::select("select stocktrans.id,name,stocks.buyingrate as buying,purchaseheaderid,transdate,stockname,quantity,totalamt,totalpaid,totaldue,stocktrans.sellingrate,stocktrans.buyingrate from stocktrans
    inner join stocks on stocktrans.stockname=stocks.id where purchaseheaderid=$id");
   // return DB::select("select stockname,chartofaccounts.accountname,totalpaid,accounttrans.accountcode,stocktrans.purchaseheaderid from stocktrans inner join accounttrans on accounttrans.purchaseheaderid=stocktrans.purchaseheaderid inner join   purchaseheaders on purchaseheaders.id=accounttrans.purchaseheaderid inner join chartofaccounts on accounttrans.accountcode=chartofaccounts.accountcode  where stocktrans.purchaseheaderid=$id AND ttype='D' group by stocktrans.id");
}

public function viewstockout($id){
    //return stocktrans::where('purchaseheaderid',$id)->get();
    return DB::select("select stocktrans.id as id,name as stockid,stocks.buyingrate as buying,purchaseheaderid,transdate,stockname,quantity,totalamt,totalpaid,totaldue,stocktrans.sellingrate,stocktrans.buyingrate from stocktrans
    inner join stocks on stocktrans.stockname=stocks.id where purchaseheaderid=$id and type='O'");
   // return DB::select("select stockname,chartofaccounts.accountname,totalpaid,accounttrans.accountcode,stocktrans.purchaseheaderid from stocktrans inner join accounttrans on accounttrans.purchaseheaderid=stocktrans.purchaseheaderid inner join   purchaseheaders on purchaseheaders.id=accounttrans.purchaseheaderid inner join chartofaccounts on accounttrans.accountcode=chartofaccounts.accountcode  where stocktrans.purchaseheaderid=$id AND ttype='D' group by stocktrans.id");
}
public function stocktransfer(Request $request){
    DB::beginTransaction();
    try{
   // inserting transfer code
   $objtransfer=new transfers();
   $objtransfer->date=date("'Y/m/d'");
   $objtransfer->save();
    
    $objstocktrans1= new stocktrans();
    // Removing form the first branch
    $objstocktrans1->stockname=$this->getstockid($request['from'],$request['stockid']);
    if($request['types']==1){
        $objstocktrans1->quantity=$request['quantity']*$request['number'];
        }else{
            $objstocktrans1->quantity=$request['quantity'];   
        }
    $objstocktrans1->purchaseheaderid=$request['purcnumber']; 
    $objstocktrans1->type="OT";
    $objstocktrans1->transfercode=$objtransfer->id;
    $objstocktrans1->save();

    //saving to the second branch
    $objstocktrans2= new stocktrans();
    $objstocktrans2->stockname=$this->getstockid($request['to'],$request['stockid']);
    if($request['types']==1){
    $objstocktrans2->quantity=$request['quantity']*$request['number'];
    }else{
        $objstocktrans2->quantity=$request['quantity'];   
    }
    $objstocktrans2->purchaseheaderid=$request['purcnumber']+1; 
    $objstocktrans2->type="IT";
    $objstocktrans2->transfercode=$objtransfer->id;
    $objstocktrans2->save();
}catch(\Exception $e){
    DB::rollback();
    return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));  
}
// Returning Back Json to Grid
echo json_encode(array(
    'stockid'=>$request['stockid'],
	'description' => $request['description'],
    'sellingrate' => $request['sellingrate'],
    'quantity' => $request['quantity'],
    'id'=>$objstocktrans1->id,
));
DB::commit();
    //$headerno=$request['purcnumber'];
}
public function getstockid($branch,$stockcode){
    $stockID=0;
    $results= DB::select("select id from stocks where branch_id=$branch AND stockcode='$stockcode'");
    foreach($results as $rs){
     $stockID=$rs->id;
    }
    return $stockID;


}
public function updaterow(Request $request){
$stocktrans= stocktrans::find($request['id']);
$stocktrans->quantity=$request['quantity'];
$stocktrans->totalamt=$request['totalamt'];
$stocktrans->totalpaid=$request['totalpaid'];
$stocktrans->totaldue=$request['totaldue'];
$stocktrans->sellingrate=$request['sellingrate'];
$stocktrans->transdate=date("Y-m-d", strtotime($request['date']));
$stocktrans->save();
//Updating sales of goods 
$accounttrans=accounttrans::where('stockidentify','=',$request['id'])->where('ttype','=','C')->update(['amount'=>$request['totalpaid'],'transdate'=>date("Y-m-d", strtotime($request['date']))]
);
//Updating Cash Account
$accounttrans=accounttrans::where('stockidentify','=',$request['id'])->where('ttype','=','D')->update(['amount'=>$request['totalpaid'],'accountcode'=>$request['accountcode'],'transdate'=>date("Y-m-d", strtotime($request['date']))]
);
if($request['totaldue']>0){
    $accounttrans=accounttrans::where('stockidentify','=',$request['id'])->where('accountcode','=',1111)->update(['amount'=>$request['totaldue']]);

}
//updating date
$purchaseheadersob=purchaseheaders::find($request['id']);
$purchaseheadersob->transdates=date("Y-m-d", strtotime($request['date']));
$purchaseheadersob->update();
//updating stocks


}

public function updatepurchase(Request $request){
    DB::beginTransaction();
    try{
    $stocktrans= stocktrans::find($request['id']);
    $stocktrans->quantity=$request['quantity'];
    $stocktrans->totalamt=$request['totalamt'];
    $stocktrans->totalpaid=$request['totalpaid'];
    $stocktrans->totaldue=$request['totaldue'];
    $stocktrans->buyingrate=$request['buyingrate'];
    $stocktrans->transdate=date("Y-m-d", strtotime($request['date']));
    $stocktrans->save();
    //Updating sales of goods 
    $accounttrans=accounttrans::where('stockidentify','=',$request['id'])->where('ttype','=','D')->update(['amount'=>$request['totalpaid'],'transdate'=>date("Y-m-d", strtotime($request['date']))]
    );
    //Updating Cash Account
    $accounttrans=accounttrans::where('stockidentify','=',$request['id'])->where('ttype','=','C')->update(['amount'=>$request['totalpaid'],'accountcode'=>$request['accountcode'],'transdate'=>date("Y-m-d", strtotime($request['date']))]
    );
    if($request['totaldue']>0){
        $accounttrans=accounttrans::where('stockidentify','=',$request['id'])->where('accountcode','=',1111)->update(['amount'=>$request['totaldue']]);
    
    }
}catch(\Exception $e){
    DB::rollback();
    return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));  
}
DB::commit();
    
    }

public function deletesales(Request $request){
    // Deleting from stocktable
    $id=$request['id'];
			if($id=='undefined'){
			
		}else{
    $stocktransobj=stocktrans::find($id);
    $stocktransobj->delete();
    // Deleting from accountrans table
    $accountransobj=accounttrans::where('stockidentify',$id)->delete();
		}



}
public function updatestockbranch(Request $request){
    DB::beginTransaction();
    try{
        $pno=$request['pno'];
    $reqbranch=$request['branch'];  
   $stockid =DB::select("select stockname from stocktrans where purchaseheaderid=$pno");
   foreach($stockid as $id){
        $bra=DB::select("select stockcode,id,branch_id from stocks where id=$id->stockname ");
        
        foreach($bra as $ba){
           $items=DB::select("select id from stocks where stockcode='$ba->stockcode' and branch_id=$reqbranch");
            foreach($items as $it){
                DB::update("update stocktrans set stockname=$it->id where purchaseheaderid=$pno and stockname=$id->stockname");
            }
           
        }
   }
   }catch(\Exception $e){
        DB::rollback();
        return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));  
    }
    DB::commit();
}

public function editpurchases(Request $request){
    DB::beginTransaction();
    try{
    $id=$request['id'];

    $Objstocktrans= stocktrans::find($id);
      
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objstocktrans->stockname=$request['productid'];
$Objstocktrans->totalamt=$request['totalamt'];
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objstocktrans->purchaseheaderid=$request['purcnumber'];
$Objstocktrans->stockname=$request['productid'];
$Objstocktrans->totalpaid=$request['totalpaid'];
$Objstocktrans->totaldue=$request['totaldue'];
if($request['price']==1){
    $Objstocktrans->quantity=$request['quantity']*$request['number'];
    }else{
        $Objstocktrans->quantity=$request['quantity'];  
    }
    $Objstocktrans->save();

    if($request['totaldue']>0){
        $stockbals= stockbals::find($id);
          if(sizeof($stockbals)>0){
$stockbals->balance=$request['totaldue'];
       $stockbals->save();
          }else{
            $stockbals= new stockbals();
            $stockbals->headno=$request['purcnumber'];
            $stockbals->balance=$request['totaldue'];
            $stockbals->stocktransid=$id;
            $stockbals->save();
          }
        
        }else{
            $stockbals=stockbals::find($id);
            if(sizeof($stockbals)>0){
                $stockbals->delete();
            }
           
        }

        // Accounting 
        //Inventory Account 
        accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1113)->where('ttype','=','D')->update(['amount'=>$request['totalpaid']]);
       // Sale of Goods 
        accounttrans::where('stockidentify','=',$id)->where('accountcode','=',$request['paccount'])->where('ttype','=','C')->update(['amount'=>$request['totalpaid']]);
        //Debiting remember its a double entry

        if($request['totaldue']>0){
            
           $a= DB::select("select id from accounttrans where stockidentify=$id and accountcode=1112 and ttype='C'");
           $b=DB::select("select id from accounttrans where stockidentify=$id and accountcode=1113 and ttype='D' and credit=1");
           
           //accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1112)->where('ttype','=','C');
             // $b=  accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1113)->where('ttype','=','D')->where('credit','=',1);
             // return $a;
            if(sizeof($a)>0 && sizeof($b)>0){
                //Fixed Account Accounts Payable 
                accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1112)->where('ttype','=','C')->update(['amount'=>$request['totaldue']]);
                //Inventory Account 
                accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1113)->where('ttype','=','D')->where('credit','=',1)->update(['amount'=>$request['totaldue']]);

            }else{
                $Objaccounttrans2= new accounttrans();
                $Objaccounttrans2->accountcode="1112";//Fixed Account Accounts Payable
                $Objaccounttrans2->narration="Purchase of ".$request['quantity']." ".$request['stockid']." on Credit";
                $Objaccounttrans2->amount=$request['totaldue'];
                $Objaccounttrans2->ttype="C";
                $Objaccounttrans2->transdate=date("Y-m-d", strtotime($request['date']));
                $Objaccounttrans2->purchaseheaderid=$request['purcnumber'];
                $Objaccounttrans2->stockidentify=$id;
                
                $Objaccounttrans2->save();
            
                $Objaccounttrans3= new accounttrans();
                $Objaccounttrans3->accountcode="1113";//Inventory Account
                $Objaccounttrans3->narration="Purchase of ".$request['quantity']." ".$request['productid']." on Credit";
                $Objaccounttrans3->amount=$request['totaldue'];
                $Objaccounttrans3->ttype="D";
                $Objaccounttrans3->purchaseheaderid=$request['purcnumber'];
                $Objaccounttrans3->credit=1;
                $Objaccounttrans3->transdate=date("Y-m-d", strtotime($request['date']));
                $Objaccounttrans3->stockidentify=$id;
                $Objaccounttrans3->save();
            }
            
        
        }else{
            $accounttrans=accounttrans::find($id);
            if(sizeof($accounttrans)>0){
                accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1112)->where('ttype','=','C')->delete();
                //Inventory Account 
                accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1113)->where('ttype','=','D')->where('credit','=',1)->delete();


            }
    }
    }catch(\Exception $e){
        DB::rollback();
        return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));   
    }
DB::commit();
}


// editing sales

public function editsales(Request $request){
     //Error Messages
     DB::beginTransaction();
     try{
    $id=$request['id'];

    $Objstocktrans= stocktrans::find($id);
      
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objstocktrans->stockname=$request['productid'];
$Objstocktrans->totalamt=$request['totalamt'];
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['date']));
$Objstocktrans->purchaseheaderid=$request['purcnumber'];
$Objstocktrans->stockname=$request['productid'];
$Objstocktrans->totalpaid=$request['totalpaid'];
$Objstocktrans->sellingrate=$request['sellingrate'];
$Objstocktrans->totaldue=$request['totaldue'];
if($request['price']==2){
    $Objstocktrans->quantity=$request['quantity']*$request['wholeitem'];
    }else{
        $Objstocktrans->quantity=$request['quantity'];  
    }
    $Objstocktrans->save();

    if($request['totaldue']>0){
        $stockbals= stockbals::find($id);
          if(sizeof($stockbals)>0){
$stockbals->balance=$request['totaldue'];
       $stockbals->save();
          }else{
            $stockbals= new stockbals();
            $stockbals->headno=$request['purcnumber'];
            $stockbals->balance=$request['totaldue'];
            $stockbals->stocktransid=$id;
            $stockbals->save();
          }
        
        }else{
            $stockbals=stockbals::find($id);
            if(sizeof($stockbals)>0){
                $stockbals->delete();
            }
           
        }
        // Accounting 
        //Fixed Account For Sale of Goods
        accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1000)->where('ttype','=','C')->update(['amount'=>$request['totalpaid']]);//->update(['transdate']=>date("Y-m-d", strtotime($request['date'])]));
        //Debiting Remeber Cash Account
        accounttrans::where('stockidentify','=',$id)->where('accountcode','=',$request['raccount'])->where('ttype','=','D')->update(['amount'=>$request['totalpaid']]);//->update(['transdate']=>date("Y-m-d", strtotime($request['date'])]));
        // Invertory Accounts
        if($request['price']==2){
        accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1113)->where('ttype','=','C')->update(['amount'=>$request['buyingrate']*$request['quantity']]);//->update(['transdate']=>date("Y-m-d", strtotime($request['date'])]));
        }else{
         accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1113)->where('ttype','=','C')->update(['amount'=>$request['buyingrateitem']*$request['quantity']]);//->update(['transdate']=>date("Y-m-d", strtotime($request['date'])]));
        }
        // Cost of Goods Inserting // Remember its an Expense
        if($request['price']==2){
           accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1001)->where('ttype','=','D')->update(['amount'=>$request['buyingrate']*$request['quantity']]);//->update(['transdate']=>date("Y-m-d", strtotime($request['date'])]));
            }else{
             accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1001)->where('ttype','=','D')->update(['amount'=>$request['buyingrateitem']*$request['quantity']]);//->update(['transdate']=>date("Y-m-d", strtotime($request['date'])]));
            }
// Accounts Recievables 
            if($request['totaldue']>0){

          $a= DB::select("select id from accounttrans where stockidentify=$id and accountcode=1111 and ttype='D'");
           $b=DB::select("select id from accounttrans where stockidentify=$id and accountcode=1000 and ttype='C' and credit=1");
           if(sizeof($a)>0 && sizeof($b)>0){
            //Fixed Account Accounts Recievables
            accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1111)->where('ttype','=','D')->update(['amount'=>$request['totaldue']]);
            //Fixed Account Sale of Goods
            accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1000)->where('ttype','=','C')->where('credit','=',1)->update(['amount'=>$request['totaldue']]);

        }else{
            $Objaccounttrans2= new accounttrans();
            $Objaccounttrans2->accountcode="1111";//Fixed Account Accounts Recievables
            $Objaccounttrans2->narration="Sale of ".$request['stockid']." on Credit";
            $Objaccounttrans2->amount=$request['totaldue'];
            $Objaccounttrans2->ttype="D";
            $Objaccounttrans2->transdate=date("Y-m-d", strtotime($request['date']));
            $Objaccounttrans2->purchaseheaderid=$request['purcnumber'];
            $Objaccounttrans2->stockidentify=$Objstocktrans->id;
            $Objaccounttrans2->save();
        
            $Objaccounttrans3= new accounttrans();
            $Objaccounttrans3->accountcode="1000";//Fixed Account Sale of Goods
            $Objaccounttrans3->narration="Sale of ".$request['stockid']." on Credit";
            $Objaccounttrans3->amount=$request['totaldue'];
            $Objaccounttrans3->ttype="C";
            $Objaccounttrans3->transdate=date("Y-m-d", strtotime($request['date']));
            $Objaccounttrans3->credit=1;
            $Objaccounttrans3->purchaseheaderid=$request['purcnumber'];
            $Objaccounttrans3->stockidentify=$Objstocktrans->id;
            $Objaccounttrans3->save();
        }
            
            
            }else{
                $accounttrans=accounttrans::find($id);
                if(sizeof($accounttrans)>0){
                    accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1111)->where('ttype','=','D')->delete();
                    //Inventory Account 
                    accounttrans::where('stockidentify','=',$id)->where('accountcode','=',1000)->where('ttype','=','C')->where('credit','=',1)->delete();
    
    
                }
            }
        }catch(\Exception $e){
            DB::rollback();
            return  json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));
        }
DB::commit();


}

public function getStockQua($id){
$items=DB::select("select sum(quantity) as qty  from stocktrans where type='i' and stockname='$id' ");
foreach($items as $ite){
    return $ite->qty;
}
}
 }
