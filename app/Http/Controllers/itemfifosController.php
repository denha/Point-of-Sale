<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\itemfifos;

 class itemfifosController extends Controller{

public function index(){
$items=DB::select("select * from stocktrans where type='i' and stockname=2 order by id asc");
$stockavailable=0;
$Qtytaken=170;
$Qtytaken2=170;
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
    $items=DB::select("select * from stocktrans where type='i' and stockname=2 order by id asc");
    foreach($items as $ite){
        if($overQty<=$ite->qua){
            $overBal=$overBal+($Qtytaken2-$overQty)*$ite->buyingrate;
        }
    }
}


echo $overBal+$amount+$amount2;

}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from itemfifos ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from itemfifos limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objitemfifos=new itemfifos();
$Objitemfifos->id=$request['id'];
$Objitemfifos->stockin=$request['stockin'];
$Objitemfifos->stockout=$request['stockout'];
$Objitemfifos->stockid=$request['stockid'];
$Objitemfifos->buyingpx=$request['buyingpx'];
$Objitemfifos->created_at=$request['created_at'];
$Objitemfifos->updated_at=$request['updated_at'];
$Objitemfifos->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objitemfifos=itemfifos::find($id);

$Objitemfifos->id=$request['id'];
$Objitemfifos->stockin=$request['stockin'];
$Objitemfifos->stockout=$request['stockout'];
$Objitemfifos->stockid=$request['stockid'];
$Objitemfifos->buyingpx=$request['buyingpx'];
$Objitemfifos->created_at=$request['created_at'];
$Objitemfifos->updated_at=$request['updated_at'];
$Objitemfifos->save();
}
 public function destroy($id){
        $Objitemfifos=itemfifos::find($id);
        $Objitemfifos->delete();



    }

public function viewcombo(){


    return itemfifos::all();
}
}