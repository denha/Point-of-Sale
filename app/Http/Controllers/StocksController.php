<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\stocks;
use App\stocktrans;
use App\purchaseheaders;
use App\accounttrans;
ini_set('max_execution_time',3000);
 class stocksController extends Controller{
    
public $stkcode=0;
public $branchcode=0;
public function index(){
    return view('stocks/index');
}
public function view(){
  /*  if(isset($_GET['branch_id'])){
        $branch=$_GET['branch_id'];
        $this->stocks("Where branch_id=$branch","branch_id=$branch");
    }else{
$this->stocks("Where isDefault=1","isDefault=1");
    }*/
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['search'])){
        $this->stocks("Where isDefault=1","isDefault=1");
    }
    else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['search'])){
        $search=$_GET['search'];
        $this->stocks("Where stocks.name LIKE '%$search%'","stocks.name LIKE '%$search%'");
    }
    
}
public function save(Request $request){
    DB::beginTransaction();
    try{
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
        $padded = str_pad((string)$GenBarCode, 14, "0", STR_PAD_LEFT); 
        $Objstocks=new stocks();
        $Objstocks->id=$request['id'];
        $Objstocks->name=$request['name'];
        $Objstocks->barcode=$padded;
        $Objstocks->description=$request['description'];
        $Objstocks->partno=$request['partno'];
        if($request['category']==''){
            $Objstocks->category=1;
        }else{
        $Objstocks->category=$request['category'];
        }
        if($request['groupitem']==''){
            $Objstocks->groupitem=1;  
        }else{
            $Objstocks->groupitem=$request['groupitem'];
        }
        $Objstocks->subcategory=$request['subcategory'];
        $cleanstockcode=preg_replace('/[^A-Za-z0-9\-]/', '',$request['name']."-".$number);
        $Objstocks->stockcode=$cleanstockcode;
        $this->stkcode=$cleanstockcode;
        $Objstocks->branch_id=$r->id;
        if($r->id==auth()->user()->branchid){
            $numbex=$request['unitofmeasure'];
            $num=DB::select("select isActive from uoms where id=$numbex");
            foreach($num as $n){
                //echo $n['isActive'];
                $num=$request['openingstock'];
                $whole = (int) $num;  // 5
                $frac  = $num - $whole;
               //echo $this->decimaltoInt($frac)*$frac+$whole;
              
                $this->branchcode=auth()->user()->branchid;
                if($n->isActive>1){
                    $Objstocks->openingstock=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
                    //$Objstocks->buyingrate= str_replace( ',', '',$request['buyingrate'])/(($whole+$frac)*$n->isActive);
                }else{
                    
                    $Objstocks->openingstock=$request['openingstock']*$n->isActive;
                    
                }
                
          

            }
       

        }
       // $Objstocks->openingstock=$request['openingstock'];
       $numbex=$request['unitofmeasure'];
            $num=DB::select("select isActive from uoms where id=$numbex");
            foreach($num as $n){
                //echo $n['isActive'];
               
            }
        $Objstocks->limitlevel=$request['limitlevel'];
        $Objstocks->buyingrate=str_replace( ',', '',$request['buyingrate']);
        $Objstocks->buyingrateitem=$request['buyingrate'];
        $Objstocks->sellingrate=str_replace( ',', '',$request['sellingrate']);
        $Objstocks->wholeprice=$request['wholeprice'];
        $Objstocks->wholeitemp=$request['wholeitem'];
        $Objstocks->unitofmeasure=$request['unitofmeasure'];
        $Objstocks->isActive=$request['isActive'];
        $Objstocks->openingstok=$request['openingstock'];
        $Objstocks->created_at=$request['created_at'];
        $Objstocks->updated_at=$request['updated_at'];
        $Objstocks->save();

     //}
    }
    
             // Savings in purchaseheaders
             $today=date("Y-m-d"); 
             $Objpurchaseheader= new purchaseheaders();
             $Objpurchaseheader->transdates=date("Y-m-d", strtotime($request['asof']));
             $Objpurchaseheader->branch_id=auth()->user()->branchid;
             $Objpurchaseheader->save();

// saving in stocktrans
$Objstocktrans= new stocktrans();
$itmcode=0;
//$branch=auth()->user()->branchid;
$itemcode=DB::select("select id from stocks where stockcode='$this->stkcode' AND branch_id=$bra");
foreach($itemcode as $code){
    $this->itmcode=$code->id;
   
}

$numbex=$request['unitofmeasure'];
            $num=DB::select("select isActive from uoms where id=$numbex");
            foreach($num as $n){
                $num=$request['openingstock'];
                $whole = (int) $num;  // 5
                $frac  = $num - $whole;
                if($n->isActive>1){
              $Objstocktrans->quantity=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
              $Objstocktrans->qua=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
                }else{
             $Objstocktrans->quantity=$request['openingstock']*$n->isActive; 
             $Objstocktrans->qua=$request['openingstock']*$n->isActive;    
                }
                
                
            }
$Objstocktrans->type="I";
$Objstocktrans->branchno=auth()->user()->branchid;
$Objstocktrans->isInput=1;
$Objstocktrans->buyingrate=str_replace( ',', '',$request['buyingrate']);
$Objstocktrans->transdate=date("Y-m-d", strtotime($request['asof']));
$Objstocktrans->stockname= $this->itmcode;
if($request['purchaseno']==0){
    $Objstocktrans->purchaseheaderid=$Objpurchaseheader->id;   
}else{
$Objstocktrans->purchaseheaderid=$Objpurchaseheader->id;
}
$Objstocktrans->save();


// get quantity 
$numbex=$request['unitofmeasure'];
$num=DB::select("select isActive from uoms where id=$numbex");
foreach($num as $n){


// Debiting inventory
foreach($branch as $r){
    if($r->id==auth()->user()->branchid){
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1113";
$objaccounttrans->narration="stock in ".$request['name'];
$numbex=$request['unitofmeasure'];
$num=DB::select("select isActive from uoms where id=$numbex");
foreach($num as $n){
    //echo $n['isActive'];
    $num1=$request['openingstock'];
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
   
    if($n->isActive>0){
$objaccounttrans->amount=str_replace( ',', '',$request['buyingrate'])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$request['buyingrate']);
$objaccounttrans->total=str_replace( ',', '',$request['buyingrate'])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$request['buyingrate']);
    }else{
$objaccounttrans->amount=str_replace( ',', '',$request['buyingrate'])*$request['openingstock']*$n->isActive;
$objaccounttrans->total=str_replace( ',', '',$request['buyingrate'])*$request['openingstock']*$n->isActive;
    }
}

$objaccounttrans->ttype="D"; 
$objaccounttrans->purchaseheaderid=$Objpurchaseheader->id;
// geting the id of the entered item
$itemid=DB::select("select id from stocks where branch_id=$r->id order by id desc limit 1");
foreach($itemid as $item){
$objaccounttrans->stockidentify=$item->id;
//echo $item->id;
}
$objaccounttrans->bracid=auth()->user()->branchid;
$objaccounttrans->isInput=1;
$objaccounttrans->transdate=date("Y-m-d", strtotime($request['asof']));
$objaccounttrans->save();
//Crediting Captial 
$objaccounttrans1= new accounttrans();
$objaccounttrans1->accountcode="4500";
$objaccounttrans1->narration="stock in ".$request['name'];
$numbex=$request['unitofmeasure'];
$num=DB::select("select isActive from uoms where id=$numbex");
foreach($num as $n){
    //echo $n['isActive'];
    $num1=$request['openingstock'];
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
   
    if($n->isActive>0){
$objaccounttrans1->amount=str_replace( ',', '',$request['buyingrate'])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$request['buyingrate']);
$objaccounttrans1->total=str_replace( ',', '',$request['buyingrate'])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$request['buyingrate']);
    }else{
$objaccounttrans1->amount=str_replace( ',', '',$request['buyingrate'])*$request['openingstock']*$n->isActive;
$objaccounttrans1->total=str_replace( ',', '',$request['buyingrate'])*$request['openingstock']*$n->isActive;
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


    }catch(\Exception $e){
        DB::rollback();
        echo "Failed ".$e;
       // echo json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));  
    }
    DB::commit();

}
//Auto generated code for updating
public function update(Request $request,$id){
    DB::beginTransaction();
    try{
        $Objstocks=stocks::find($id);

//$Objstocks->id=$request['id'];
$Objstocks->branch_id=auth()->user()->branchid;
$Objstocks->name=$request['name'];
$Objstocks->partno=$request['partno'];
if($request['groupitem']==''){
    $Objstocks->groupitem=1;  
}else{
    $Objstocks->groupitem=$request['groupitem'];
}
$Objstocks->description=$request['description'];
if($request['category']==''){
    $Objstocks->category=1;
}else{
$Objstocks->category=$request['category'];
}
$Objstocks->subcategory=$request['subcategory'];
$numbex=$request['unitofmeasure'];
$num1=DB::select("select isActive from uoms where id=$numbex");
foreach($num1 as $n){
    //echo $n['isActive'];
    $num=$request['openingstock'];
    $whole = (int) $num;  // 5
    $frac  = $num - $whole;
  // echo $this->decimaltoInt($frac)*$frac+$whole;
  
    $this->branchcode=auth()->user()->branchid;
   $trsdate= date("Y-m-d", strtotime($request['asof']));
   $buypx=str_replace( ',', '',$request['buyingrate']);
    if($n->isActive>1){
        $Objstocks->openingstock=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
        $quantity=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
        DB::update("update stocktrans set quantity=$quantity,qua=$quantity,transdate='$trsdate',buyingrate=$buypx  where stockname=$id and isInput=1");
        
    }else{
        
        $Objstocks->openingstock=$request['openingstock']*$n->isActive;
        $quantity=$request['openingstock']*$n->isActive;
        DB::update("update stocktrans set quantity=$quantity ,qua=$quantity,buyingrate=$buypx,transdate='$trsdate'  where stockname=$id and isInput=1");
       // DB::update("update accounttrans set amount=$total where stockidentify=$id and isInput=1");
        
    }
}
$Objstocks->buyingrate=str_replace( ',', '',$request['buyingrate']);
$Objstocks->buyingrateitem=$request['buyingrate'];
$Objstocks->sellingrate=str_replace( ',', '',$request['sellingrate']);
$Objstocks->wholeprice=$request['wholeprice'];
$Objstocks->wholeitemp=$request['wholeitem'];
$Objstocks->unitofmeasure=$numbex;
$Objstocks->barcode=$request['barcode'];
$Objstocks->isActive=$request['isActive'];
$Objstocks->limitlevel=$request['limitlevel'];
$Objstocks->created_at=$request['created_at'];
$Objstocks->updated_at=$request['updated_at'];
$Objstocks->openingstok=$request['openingstock'];
$Objstocks->save();
$total=$request['openingstock']*str_replace( ',', '',$request['buyingrate']);
//DB::update("update stocktrans set quantity=$quantity  where stockname=$id and isInput=1");
$bid=auth()->user()->branchid;
//echo $id;
$branid=DB::select("select id from stocks where branch_id=$bid");
//foreach($branid as $bra){
    $num=DB::select("select isActive from uoms where id=$numbex");
   foreach($num as $n){
    //echo $n['isActive'];
    $num1=$request['openingstock'];
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
    $transd=date("Y-m-d", strtotime($request['asof']));
    if($n->isActive>0){
        $money=str_replace( ',', '',$request['buyingrate'])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$request['buyingrate']);
        DB::update("update accounttrans set amount=$money,total=$money,transdate='$transd' where stockidentify=$id and isInput=1");
    }else{
$money1=str_replace( ',', '',$request['buyingrate'])*$request['openingstock']*$n->isActive;
DB::update("update accounttrans set amount=$money1,total=$money1,transdate='$transd' where stockidentify=$id and isInput=1");
    }
}

    }catch(\Exception $e){
        echo "Failed ".$e;
        DB::rollback();
        echo json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));    
    }
    DB::commit();
//}
}
 public function destroy($id){
    DB::beginTransaction();
    try{
        $stocktrans=DB::select("select sum(quantity) quantity from stocktrans where stockname=$id and isInput!=1 having sum(quantity)>0");
        //foreach($stocktrans as $trans){
        if(count($stocktrans)>0){
            return['isdelete'=>'No'];

        }else{
        $Objstocks=stocks::find($id);
        $Objstocks->delete();
        DB::delete("delete from stocktrans where stockname=$id and isInput=1");
        DB::delete("delete from accounttrans where stockidentify=$id and isInput=1");
        }
//}
    }catch(\Exception $e){
 DB::rollback();
        echo json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));  
    }
DB::commit();

    }

    public function viewcombo($id){

        //return stocks::where('branch_id',$id)->get();
        return DB::select("select *,stocks.id as id,stocks.name as name, uoms.isActive as wholeitem from stocks inner join uoms on stocks.unitofmeasure=uoms.id where branch_id=$id order by stocks.name asc");
    }

    public function bybranch(){

        return stocks::all();
    }
    public function viewstocks(){

        return DB::select('select stockcode,stocks.name,uoms.isActive as numbers,description,buyingrate,sellingrate from stocks inner join uoms on stocks.unitofmeasure=uoms.id inner join branches on branches.id =stocks.branch_id group by stockcode,name,description,buyingrate,sellingrate');
    }
 
    public function stocks($stocks,$limit){
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select COUNT(*) as count from stocks inner join branches on stocks.branch_id=branches.id $stocks");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select groupitem,partno, category,description,DATE_FORMAT(transdate,'%d-%m-%Y') as asof, uoms.name as nam,openingstok as openingstock, limitlevel, stocks.id as id, stocks.name as name ,barcode,stocks.unitofmeasure , stocks.id as id,format(stocks.buyingrate,0)as buyingrate, format(stocks.sellingrate,0) as sellingrate, concat(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)),' ',secondaryuom) as stockavailabe,concat(MOD(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)),uoms.isActive),' ',primaryuom) as Pieces,concat(substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1),' ', secondaryuom)as Dozens,substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1)as available FROM `stocktrans` inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id inner join branches on branches.id=purchaseheaders.branch_id inner join stocks on stocks.id=stocktrans.stockname inner join uoms on stocks.unitofmeasure=uoms.id inner join itemgroups on itemgroups.id=stocks.groupitem inner join categories on categories.id=stocks.category where $limit  group by stocks.id order by stocks.name asc limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);
}

//importing stock items 
public function importstock(Request $request){
    DB::beginTransaction();
   // try{
        try{
       $brai= auth()->user()->branchid;
    $branch=DB::select('select id from branches');
    $max=DB::select('select count(id) as id from stocks');
    $number=0;
    foreach($max as $k){
$number=$k->id;


    }
    //Capturing the image
$file=$request->file('files');
$f=fopen('write.txt','w');
fwrite($f,$file=$request->file('files'));
$destinationPath="stockuploads";
$filename=$file->getClientOriginalName();
//moving it to the folder
$finalfile=$file->move($destinationPath,$filename);
$handle = fopen($finalfile, "r");
$a=0;

while(($data=fgetcsv($handle,1000,","))!==FALSE  ){
    
    foreach($branch as $r){

          $Objstocks=new stocks();
          $Objstocks->name=$data[0];// name
          $Objstocks->description=$data[1];
          if($data[3]==''){
            $Objstocks->category=1;  
          }else{
            $Objstocks->category=$data[3];   
          }
          if($data[4]==''){
            $Objstocks->groupitem=1;  
          }else{
            $Objstocks->groupitem=$data[4];   
          }
          $Objstocks->partno=$data[5];
          $Objstocks->barcode=$data[12];
          //$Objstocks->description=$data[1];// Description
        $cleanstockcode=preg_replace('/[^A-Za-z0-9\-]/', '',$data[0]."-".$a);
          $Objstocks->stockcode=$cleanstockcode;//preg_replace('/[^A-Za-z0-9\-]/', '',substr($data[0], 0, 3)."-".$a);//.date('s');
          $this->stkcode=$cleanstockcode;//preg_replace('/[^A-Za-z0-9\-]/', '',substr($data[0], 0, 3)."-".$a);
          $Objstocks->branch_id=$r->id;
          if($r->id==$data[10]){// First Branch
              // purchase headers;
              $purchaseobj= new purchaseheaders();
        $purchaseobj->transdates=date("Y-m-d", strtotime($data[11]));
        $purchaseobj->branch_id=$data[10];
        $purchaseobj->save();
        $unitofmea=$data[9];
        $num=DB::select("select isActive from uoms where id=$unitofmea");
        foreach($num as $n){
            //echo $n['isActive'];
            $num1=$data[2];
            $whole = (int) $num1;  // 5
            $frac  = $num1 - $whole;
           
            if($n->isActive>1){
                $Objstocks->openingstock=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
                //$Objstocks->buyingrate= str_replace( ',', '',$request['buyingrate'])/(($whole+$frac)*$n->isActive);
            }else{
                
                $Objstocks->openingstock=$data[2]*$n->isActive;
                
            }
        }
        
          $this->branchcode=$data[10];//branch_Id
                    // Debiting inventory
//Getting or fetching next id 
$nextID= DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='rockaboy' AND TABLE_NAME='stocks'");
foreach($nextID as $id){
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1113";
$objaccounttrans->narration="stock in ".$data[0];
$unitofmea=$data[9];
$num=DB::select("select isActive from uoms where id=$unitofmea");
foreach($num as $n){
    //echo $n['isActive'];
    $num1=$data[2];
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
   
    if($n->isActive>0){
$objaccounttrans->amount=str_replace( ',', '',$data[6])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$data[6]);
$objaccounttrans->total=str_replace( ',', '',$data[6])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$data[6]);
    }else{
$objaccounttrans->amount=str_replace( ',', '',$data[6])*$data[2]*$n->isActive;
$objaccounttrans->total=str_replace( ',', '',$data[6])*$data[2]*$n->isActive;
    }
}
$objaccounttrans->ttype="D"; 
$objaccounttrans->isInput=1;
$objaccounttrans->stockidentify=$id->id;
$objaccounttrans->purchaseheaderid= $purchaseobj->id;
$objaccounttrans->bracid=$brai;
$objaccounttrans->transdate=date("Y-m-d", strtotime($data[11]));
$objaccounttrans->save();
//Crediting Captial 
$objaccounttrans1= new accounttrans();
$objaccounttrans1->accountcode="4500";
$objaccounttrans1->narration="stock in ".$data[0];
$unitofmea=$data[9];
$num=DB::select("select isActive from uoms where id=$unitofmea");
foreach($num as $n){
    //echo $n['isActive'];
    $num1=$data[2];
    $whole = (int) $num1;  // 5
    $frac  = $num1 - $whole;
   
    if($n->isActive>0){
$objaccounttrans1->amount=str_replace( ',', '',$data[6])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$data[6]);
$objaccounttrans1->total=str_replace( ',', '',$data[6])*($whole*$n->isActive)+($this->decimaltoInt($frac)*$frac)*str_replace( ',', '',$data[6]);
    }else{
$objaccounttrans1->amount=str_replace( ',', '',$data[6])*$data[2]*$n->isActive;
$objaccounttrans1->total=str_replace( ',', '',$data[6])*$data[2]*$n->isActive;
    }
}
$objaccounttrans1->ttype="C"; 
$objaccounttrans1->isInput=1;
$objaccounttrans1->stockidentify=$id->id;
$objaccounttrans1->purchaseheaderid= $purchaseobj->id;
$objaccounttrans1->transdate=date("Y-m-d", strtotime($data[11]));
$objaccounttrans1->bracid=$brai;
$objaccounttrans1->save();
}
          }
       /*   if($r->id==$data[9]){// Second  Branch
            // purchase headers;
            $purchaseobj= new purchaseheaders();
      $purchaseobj->transdates=date("Y/m/d");
      $purchaseobj->branch_id=$data[9];
      $purchaseobj->save();
      // Getting or Fetching the next stocks 
      $nextID= DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='partycorner' AND TABLE_NAME='stocks'");
      foreach($nextID as $id){
        $Objstocks->openingstock=$data[10];//Opening stock
        $this->branchcode=$data[9];//branch_Id
                    // Debiting inventory

                    $objaccounttrans= new accounttrans();
                    $objaccounttrans->accountcode="1113";
                    $objaccounttrans->narration="stock in ".$data[0];
                    $objaccounttrans->amount=$data[3]*$data[10];;
                    $objaccounttrans->ttype="D"; 
                    $objaccounttrans->isInput=1;
                    $objaccounttrans->stockidentify=$id->id;
                    $objaccounttrans->purchaseheaderid= $purchaseobj->id;
                    $objaccounttrans->save();
                    //Crediting Captial 
                    $objaccounttrans1= new accounttrans();
                    $objaccounttrans1->accountcode="4500";
                    $objaccounttrans1->narration="stock in ".$data[0];
                    $objaccounttrans1->amount=$data[3]*$data[10];;
                    $objaccounttrans1->ttype="C"; 
                    $objaccounttrans1->isInput=1;
                    $objaccounttrans1->stockidentify=$id->id;
                    $objaccounttrans1->purchaseheaderid= $purchaseobj->id;
                    $objaccounttrans1->save();
      }

        }

        // Third Branch 

        if($r->id==$data[11]){// Second  Branch
            // purchase headers;
            $purchaseobj= new purchaseheaders();
      $purchaseobj->transdates=date("Y/m/d");
      $purchaseobj->branch_id=$data[11];
      $purchaseobj->save();

        $Objstocks->openingstock=$data[12];//Opening stock
        $this->branchcode=$data[11];//branch_Id
                            // Debiting inventory
      // Getting or Fetching the next stocks 
      $nextID= DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='partycorner' AND TABLE_NAME='stocks'");
      foreach($nextID as $id){
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1113";
$objaccounttrans->narration="stock in ".$data[0];
$objaccounttrans->amount=$data[3]*$data[12];;
$objaccounttrans->ttype="D"; 
$objaccounttrans->isInput=1;
$objaccounttrans->stockidentify=$id->id;
$objaccounttrans->purchaseheaderid= $purchaseobj->id;
$objaccounttrans->save();
//Crediting Captial 
$objaccounttrans1= new accounttrans();
$objaccounttrans1->accountcode="4500";
$objaccounttrans1->narration="stock in ".$data[0];
$objaccounttrans1->amount=$data[3]*$data[12];;
$objaccounttrans1->ttype="C"; 
$objaccounttrans1->isInput=1;
$objaccounttrans1->stockidentify=$id->id;
$objaccounttrans1->purchaseheaderid= $purchaseobj->id;
$objaccounttrans1->save();
      }
        }

        // Fourth Branch

        if($r->id==$data[13]){// Second  Branch
            // purchase headers;
            $purchaseobj= new purchaseheaders();
      $purchaseobj->transdates=date("Y/m/d");
      $purchaseobj->branch_id=$data[13];
      $purchaseobj->save();

        $Objstocks->openingstock=$data[14];//Opening stock
        $this->branchcode=$data[13];//branch_Id
                    // Debiting inventory
      // Getting or Fetching the next stocks 
      $nextID= DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='partycorner' AND TABLE_NAME='stocks'");
      foreach($nextID as $id){
                    $objaccounttrans= new accounttrans();
                    $objaccounttrans->accountcode="1113";
                    $objaccounttrans->narration="stock in ".$data[0];
                    $objaccounttrans->amount=$data[3]*$data[14];;
                    $objaccounttrans->ttype="D"; 
                    $objaccounttrans->stockidentify=$id->id;
                    $objaccounttrans->isInput=1;
                    $objaccounttrans->purchaseheaderid= $purchaseobj->id;
                    $objaccounttrans->save();
                    //Crediting Captial 
                    $objaccounttrans1= new accounttrans();
                    $objaccounttrans1->accountcode="4500";
                    $objaccounttrans1->narration="stock in ".$data[0];
                    $objaccounttrans1->amount=$data[3]*$data[14];;
                    $objaccounttrans1->ttype="C"; 
                    $objaccounttrans1->stockidentify=$id->id;
                    $objaccounttrans1->isInput=1;
                    $objaccounttrans1->purchaseheaderid= $purchaseobj->id;
                    $objaccounttrans1->save();
      }
        }

        // Fifth Branch
        if($r->id==$data[15]){// Second  Branch
            // purchase headers;
            $purchaseobj= new purchaseheaders();
      $purchaseobj->transdates=date("Y/m/d");
      $purchaseobj->branch_id=$data[15];
      $purchaseobj->save();

        $Objstocks->openingstock=$data[16];//Opening stock
        $this->branchcode=$data[15];//branch_Id

                            // Debiting inventory
      // Getting or Fetching the next stocks 
      $nextID= DB::select("SELECT  AUTO_INCREMENT as  id from information_schema.TABLES WHERE TABLE_SCHEMA='partycorner' AND TABLE_NAME='stocks'");
      foreach($nextID as $id){
$objaccounttrans= new accounttrans();
$objaccounttrans->accountcode="1113";
$objaccounttrans->narration="stock in ".$data[0];
$objaccounttrans->amount=$data[3]*$data[16];;
$objaccounttrans->ttype="D"; 
$objaccounttrans->stockidentify=$id->id;
$objaccounttrans->isInput=1;
$objaccounttrans->purchaseheaderid= $purchaseobj->id;
$objaccounttrans->save();
//Crediting Captial 
$objaccounttrans1= new accounttrans();
$objaccounttrans1->accountcode="4500";
$objaccounttrans1->narration="stock in ".$data[0];
$objaccounttrans1->amount=$data[3]*$data[16];;
$objaccounttrans1->stockidentify=$id->id;
$objaccounttrans1->ttype="C"; 
$objaccounttrans1->isInput=1;
$objaccounttrans1->purchaseheaderid= $purchaseobj->id;
$objaccounttrans1->save();
      }
        }*/


         // $Objstocks->openingstock=$request['openingstock'];
          $Objstocks->limitlevel=$data[8];//Limt Level
          $Objstocks->buyingrate=str_replace( ',', '',$data[6]);//Buyingrate

          $Objstocks->buyingrateitem=str_replace( ',', '',$data[6]);//Buying Rate item
          $Objstocks->sellingrate=$data[7];//selling rate
          $Objstocks->isActive=1;
          $Objstocks->openingstok=$data[2];
          $Objstocks->unitofmeasure=$data[9];//unit of measure
          $Objstocks->save();


  
       //}
       //Saving into stocktrans;
       $stocktranobj= new stocktrans();
       if($r->id==$data[10]){
       $stocktranobj->stockname=$Objstocks->id;
       $unitofmea=$data[9];
       $num=DB::select("select isActive from uoms where id=$unitofmea");
       foreach($num as $n){
           //echo $n['isActive'];
           $num1=$data[2];
           $whole = (int) $num1;  // 5
           $frac  = $num1 - $whole;
          
           if($n->isActive>1){
            $stocktranobj->quantity=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
            $stocktranobj->qua=($whole*$n->isActive)+$this->decimaltoInt($frac)*$frac;
               //$Objstocks->buyingrate= str_replace( ',', '',$request['buyingrate'])/(($whole+$frac)*$n->isActive);
           }else{
               
            $stocktranobj->quantity=$data[2]*$n->isActive;
            $stocktranobj->qua=$data[2]*$n->isActive;
               
           }
       }
       $stocktranobj->type="I";
       $stocktranobj->isInput=1;
       $stocktranobj->buyingrate=str_replace( ',', '',$data[6]);
       $stocktranobj->branchno=$data[10];
       $stocktranobj->transdate=date("Y-m-d", strtotime($data[11]));
       $stocktranobj->purchaseheaderid=$purchaseobj->id;
       $stocktranobj->save();
       
       }
      /* if($r->id==$data[9]){
        $stocktranobj->stockname=$Objstocks->id;
        $stocktranobj->quantity=$data[10];
        $stocktranobj->type="I";
        $stocktranobj->isInput=1;
        $stocktranobj->purchaseheaderid=$purchaseobj->id;
        $stocktranobj->save();
        
        }

        if($r->id==$data[11]){
            $stocktranobj->stockname=$Objstocks->id;
            $stocktranobj->quantity=$data[12];
            $stocktranobj->type="I";
            $stocktranobj->isInput=1;
            $stocktranobj->purchaseheaderid=$purchaseobj->id;
            $stocktranobj->save();
            
            }

            if($r->id==$data[13]){
                $stocktranobj->stockname=$Objstocks->id;
                $stocktranobj->quantity=$data[14];
                $stocktranobj->type="I";
                $stocktranobj->isInput=1;
                $stocktranobj->purchaseheaderid=$purchaseobj->id;
                $stocktranobj->save();
                
                }
                // Fifth Branch 

                if($r->id==$data[15]){
                    $stocktranobj->stockname=$Objstocks->id;
                    $stocktranobj->quantity=$data[16];
                    $stocktranobj->type="I";
                    $stocktranobj->isInput=1;
                    $stocktranobj->purchaseheaderid=$purchaseobj->id;
                    $stocktranobj->save();
                    
                    }*/


       
      }
      $a++;
}
}catch(\Exception $e){
    DB::rollback();
    echo $e->getMessage();
           //echo json_encode(array('isError'=>true,'Error'=>'Record Not saved, Please Save it again'));  
}

DB::commit();
}
//}

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
public function updatequa(){
    $items=DB::select("select * from stocktrans where type='I' ");
    foreach($items as $t){
        $quantity=$t->quantity;
        $id2=$t->id;
       echo $quantity;
       
     DB::update("update stocktrans set qua=$quantity where id=$id2");
    }

}

public function stockdetails(){
return view ("stockdetails/index");
}
public function getstockdetails(){
   $id= $_GET['result'];
    DB::statement("set @CumulativeSum := 0;");
    return DB::select("select DATE_FORMAT(transdate,'%d-%m-%Y') as date,stocks.name as name,description,(@CumulativeSum := @CumulativeSum + case when type='i' then quantity when type='o' then -quantity when quantity is Null then 0 end ) as available,transdate,if(type='I',quantity,-quantity) as quantity,type from stocktrans inner join stocks on stocks.id=stocktrans.stockname where stockname=$id");
}
}