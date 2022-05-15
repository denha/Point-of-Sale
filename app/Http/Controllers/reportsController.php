<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\stocktrans;

 class reportsController extends Controller{
     public function indexprofit(){

        return view('itemprofits/index');
     }
     public function stockcategoryview(){
       return view('stockcategoryview/index');
     }
     public function totalprofits(){
        $today=date("'Y-m-d'"); 
        $branch=auth()->user()->branchid;
        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1'])&& empty($_GET['date2']) && empty($_GET['product'])){
          $this->profits("where branchno=$branch AND transdate=$today");
        }
        else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& empty($_GET['date2']) && empty($_GET['product'])){
          $date1=date("Y-m-d", strtotime($_GET['date1']));
          $this->profits("where branchno=$branch AND transdate<='$date1'");
        }
        else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& !empty($_GET['date2']) && empty($_GET['product'])){
          $date1=date("Y-m-d", strtotime($_GET['date1']));
          $date2=date("Y-m-d", strtotime($_GET['date2']));
          $this->profits("where branchno=$branch AND  transdate BETWEEN '$date1' AND '$date2' ");
        }

        if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1'])&& empty($_GET['date2']) && !empty($_GET['product'])){
          $product=$_GET['product'];
          $this->profits("where branchno=$branch AND transdate=$today AND stockname=$product");
        }
        else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& empty($_GET['date2']) && !empty($_GET['product'])){
          $date1=date("Y-m-d", strtotime($_GET['date1']));
          $product=$_GET['product'];
          $this->profits("where branchno=$branch AND transdate<='$date1' AND stockname=$product");
        }
        else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& !empty($_GET['date2']) && !empty($_GET['product'])){
          $date1=date("Y-m-d", strtotime($_GET['date1']));
          $date2=date("Y-m-d", strtotime($_GET['date2']));
          $product=$_GET['product'];
          $this->profits("where branchno=$branch AND  transdate BETWEEN '$date1' AND '$date2' and stockname=$product ");
        }



     }

public function index(){

    return view('salesreport/index');
}
public function stockgroupview(){
  return view("stockgroupview/index");
}

public function viewdaily(){
    $today=date("Y-m-d");
  
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1'])&& empty($_GET['date2'])){
      $this->dailysales("transdate='$today'");
    }
    else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& empty($_GET['date2'])){
      if(auth()->user()->admin==1){
      $date1=date("Y-m-d", strtotime($_GET['date1']));
      $this->dailysales("transdate<='$date1'");
    }
    }
    else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& !empty($_GET['date2'])){
      if(auth()->user()->admin==1){
      $date1=date("Y-m-d", strtotime($_GET['date1']));
      $date2=date("Y-m-d", strtotime($_GET['date2']));
      $this->dailysales("transdate BETWEEN '$date1' AND '$date2' ");
      }
    }
}
public function stockreport(){

    return view('stockreports/index');
}
public function viewdailystock(){
  $branchid=auth()->user()->branchid; 
    if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['product']) && empty($_GET['date1']) && empty($_GET['date2'])){
      
    $this->viewstockreport("where branches.id=$branchid");
   
   
} 
else if (!empty($_GET['product']) && isset($_GET['rows'])&& isset($_GET['page']) && empty($_GET['date1']) && empty($_GET['date2'])){
    $product=$_GET['product'];
    
    
        $this->viewstockreport("where stockname=$product AND branches.id=$branchid"); 
        
    }
    else if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['product']) && !empty($_GET['date1']) && empty($_GET['date2'])){
      $date1=date("Y-m-d", strtotime($_GET['date1']));
      $this->viewstockreport("where branches.id=$branchid and transdate<='$date1'");
     
     
     
  } 
  else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['product']) && !empty($_GET['date1']) && empty($_GET['date2'])){
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $product=$_GET['product'];
    $this->viewstockreport("where branches.id=$branchid and transdate<='$date1' and stockname=$product");
   
   
   
} 
  else if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['product']) && !empty($_GET['date1']) && !empty($_GET['date2'])){
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $date2=date("Y-m-d", strtotime($_GET['date2']));
    $this->viewstockreport("where branches.id=$branchid and transdate BETWEEN '$date1' AND '$date2' "); 
} 
else if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['product']) && !empty($_GET['date1']) && !empty($_GET['date2'])){
  $date1=date("Y-m-d", strtotime($_GET['date1']));
  $date2=date("Y-m-d", strtotime($_GET['date2']));
  $product=$_GET['product'];
  $this->viewstockreport("where branches.id=$branchid and transdate BETWEEN '$date1' AND '$date2' and stockname=$product "); 
}
}
public function purchasereport(){

    return view('purchasereport/index');
}
public function productavailable($product,$branch){
    return DB::select("select stocks.name as itemname,description,stocks.buyingrate,sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) as stockavailabe FROM `stocktrans` inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id inner join branches on branches.id=purchaseheaders.branch_id inner join stocks on stocks.id=stocktrans.stockname where stockname=$product AND branches.id= $branch group by stockname ");

}
public function viewdailypurchase(){
  $today=date("Y-m-d");
  
  if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['date1'])&& empty($_GET['date2'])){
    $this->dailypurchases("transdate='$today'");
  }
  else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& empty($_GET['date2'])){
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $this->dailypurchases("transdate<='$date1'");
  }
  else if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['date1'])&& !empty($_GET['date2'])){
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $date2=date("Y-m-d", strtotime($_GET['date2']));
    $this->dailypurchases("transdate BETWEEN '$date1' AND '$date2' ");
  }
 
    }
public function outstandingcusto(){
    $today=date("'Y/m/d'");
    
    if($this->checksearchparam()==2){
  if(isset($_REQUEST['product']) && isset($_REQUEST['branch']) ){
    $start=$_GET['start'];
    $end=$_GET['end'];
      $product=$_REQUEST['product'];
      $branch=$_REQUEST['branch'];
  $this->reportview("inner join customers on customers.id=purchaseheaders.customer_id inner join stockbals on purchaseheaders.id=stockbals.headno","where stockname='$product' AND purchaseheaders.branch_id=$branch AND transdates=$today AND transdates BETWEEN '$start' AND '$end' AND balance!=0","stockname='$product'AND purchaseheaders.branch_id=$branch AND transdates=$today AND transdates BETWEEN '$start' AND '$end' AND balance!=0");
  
  }
    }else if($this->checksearchparam()==1){
      if(isset($_GET['branch'])){
        $start=$_GET['start'];
        $end=$_GET['end'];
          $branch=$_GET['branch'];
          $this->reportview("inner join customers on customers.id=purchaseheaders.customer_id inner join stockbals on purchaseheaders.id=stockbals.headno","where purchaseheaders.branch_id=$branch AND transdates=$today AND transdates BETWEEN '$start' AND '$end' AND balance!=0","purchaseheaders.branch_id=$branch AND transdates=$today AND transdates BETWEEN '$start' AND '$end' AND balance!=0");
      
      }
  }else if($this->checksearchparam()==3){
      $branch=isset($_GET['branch']);
      $start=$_GET['start'];
      $end=$_GET['end'];
      $this->reportview("inner join customers on customers.id=purchaseheaders.customer_id inner join stockbals on purchaseheaders.id=stockbals.headno","where  transdates=$today AND transdates BETWEEN '$start' AND '$end' AND branches.isDefault=1 AND balance!=0"," transdates=$today AND transdates BETWEEN '$start' AND '$end' AND branches.isDefault=1 AND balance!=0");
  
      } 
      else if($this->checksearchparam()==4){
        $branch=$_GET['branch'];
        $start=$_GET['start'];
        $end=$_GET['end'];
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $this->reportview("inner join customers on customers.id=purchaseheaders.customer_id inner join stockbals on purchaseheaders.id=stockbals.headno","where  transdates BETWEEN '$date1' AND '$date2' AND transdates BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch AND balance!=0","transdates BETWEEN '$start' AND '$end' AND transdates BETWEEN  '$date1' AND '$date2' AND purchaseheaders.branch_id=$branch  AND balance!=0"); 
      }
      else if($this->checksearchparam()==5){
        $branch=$_GET['branch'];
        $product=$_GET['product'];
        $start=$_GET['start'];
        $end=$_GET['end'];
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $this->reportview("inner join customers on customers.id=purchaseheaders.customer_id inner join stockbals on purchaseheaders.id=stockbals.headno","where  transdates BETWEEN '$date1' AND '$date2' AND transdates BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch AND stockname=$product AND  balance!=0"," transdates BETWEEN '$date1' AND '$date2' AND transdates BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch AND stockname=$product AND balance!=0"); 
      }
    
}

public function pending(){
    $today=date("'Y/m/d'");
    
    if($this->checksearchparam()==2){
  if(isset($_REQUEST['product']) && isset($_REQUEST['branch']) ){
    $start=$_GET['start'];
    $end=$_GET['end'];
      $product=$_REQUEST['product'];
      $branch=$_REQUEST['branch'];
  $this->reportview("inner join suppliers on suppliers.id=purchaseheaders.supplier_id inner join stockbals on purchaseheaders.id=stockbals.headno","where stockname='$product' AND purchaseheaders.branch_id=$branch AND transdate=$today AND transdate BETWEEN '$start' AND '$end' AND balance!=0","stockname='$product'AND purchaseheaders.branch_id=$branch AND transdate=$today AND transdate BETWEEN '$start' AND '$end' AND balance!=0");
  
  }
    }else if($this->checksearchparam()==1){
      if(isset($_GET['branch'])){
          $branch=$_GET['branch'];
          $start=$_GET['start'];
          $end=$_GET['end'];
          $this->reportview("inner join suppliers on suppliers.id=purchaseheaders.supplier_id inner join stockbals on purchaseheaders.id=stockbals.headno","where purchaseheaders.branch_id=$branch AND transdate=$today AND transdate BETWEEN '$start' AND '$end' AND balance!=0","purchaseheaders.branch_id=$branch AND transdate=$today AND transdate BETWEEN '$start' AND '$end' AND balance!=0");
      
      }
  }else if($this->checksearchparam()==3){
      $branch=isset($_GET['branch']);
      $start=$_GET['start'];
      $end=$_GET['end'];
      $this->reportview("inner join suppliers on suppliers.id=purchaseheaders.supplier_id inner join stockbals on purchaseheaders.id=stockbals.headno","where  transdate=$today AND transdate BETWEEN '$start' AND '$end' AND branches.isDefault=1 AND balance!=0"," transdate=$today AND transdate BETWEEN '$start' AND '$end' AND branches.isDefault=1 AND balance!=0");
  
      }
      
      else if($this->checksearchparam()==4){
        $branch=$_GET['branch'];
        $start=$_GET['start'];
        $end=$_GET['end'];
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $this->reportview("inner join suppliers on suppliers.id=purchaseheaders.supplier_id inner join stockbals on purchaseheaders.id=stockbals.headno","where  transdate BETWEEN '$date1' AND '$date2' AND transdate BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch AND balance!=0"," transdate BETWEEN '$date1' AND '$date2' AND transdate BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch  AND balance!=0"); 
      }
      else if($this->checksearchparam()==5){
        $branch=$_GET['branch'];
        $product=$_GET['product'];
        $start=$_GET['start'];
        $end=$_GET['end'];
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $this->reportview("inner join suppliers on suppliers.id=purchaseheaders.supplier_id inner join stockbals on purchaseheaders.id=stockbals.headno","where  transdate BETWEEN '$date1' AND '$date2' AND transdate BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch AND stockname=$product AND  balance!=0"," transdate BETWEEN '$date1' AND '$date2' AND transdate BETWEEN '$start' AND '$end' AND purchaseheaders.branch_id=$branch AND stockname=$product AND balance!=0"); 
      }

}
    public function reportview($join,$whereclause,$limit){
        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select("select count(*) as count from (select COUNT(transdate) as count,format(totalamt,0) as totalamt ,format(totalpaid,0) as totalpaid,format(totaldue,0) as totaldue,stocks.name as itemcode from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id) das");
       //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select *,if(MOD(quantity,uoms.isActive)=0,concat(round(quantity/uoms.isActive,0),' ',primaryuom),concat(quantity,' ',secondaryuom)) as quantity,stocks.id as stockid,format(totalamt,0) as totalamt ,format(totalpaid,0) as totalpaid,format(totaldue,0) as totaldue,stocks.name as itemcode from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid inner join uoms on stocks.unitofmeasure=uoms.id  $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       //Showing The footer and totals 
       $footer =  DB::getPdo()->prepare("select format(sum(totalamt),0) as totalamt,format(sum(totalpaid),0) as totalpaid ,format(if(sum(totaldue)<0,0,sum(totaldue)),0) as totaldue  from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname $join inner join branches on branches.id=purchaseheaders.branch_id where $limit   limit $offset,$rows ");
       $footer->execute();
       $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
       $results['footer']=$foots;
       echo json_encode($results);
}
public function dailysales($where){
  $branch=auth()->user()->branchid;
  $results=array();
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
  $offset = ($page-1)*$rows;
  $rs =DB::getPdo();
  $krows = DB::select("select COUNT(*) as count from stocktrans inner join stocks on stocks.id=stocktrans.stockname  where type='O' and branchno=$branch  and $where");
 //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
  $results['total']=$krows[0]->count;
  $rst =  DB::getPdo()->prepare("select transfercode, customers.id as custoid,stocks.name as itemcode,description,customers.name customer,stocktrans.id,purchaseheaderid, DATE_FORMAT(transdate,'%d-%m-%Y') as transdate,quantity,format(totalpaid,2) as totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join customers on customers.id= stocktrans.customer where type='O' and branchno=$branch and $where order by stocktrans.id, purchaseheaderid asc limit $offset,$rows");
  $rst->execute();

  $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
 $results['rows']=$viewall;
 //Showing The footer and totals 
 $footer =  DB::getPdo()->prepare("select format(sum(totalpaid),2) totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname where type='O' and branchno=$branch and $where ");
 $footer->execute();
 $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
 $results['footer']=$foots;
 echo json_encode($results);
}
public function dailypurchases($where){
  $branch=auth()->user()->branchid;
  $results=array();
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
  $offset = ($page-1)*$rows;
  $rs =DB::getPdo();
  $krows = DB::select("select COUNT(*) as count from stocktrans inner join stocks on stocks.id=stocktrans.stockname  where type='I' and branchno=$branch  and $where");
 //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
  $results['total']=$krows[0]->count;
  $rst =  DB::getPdo()->prepare("select transfercode, suppliers.id as custoid,stocks.name as itemcode,description,companyName,stocktrans.id,purchaseheaderid, DATE_FORMAT(transdate,'%d-%m-%Y') as transdate,quantity,format(totalpaid,2) as totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join suppliers on suppliers.id= stocktrans.customer where type='I' and branchno=$branch and $where order by stocktrans.id, purchaseheaderid asc limit $offset,$rows");
  $rst->execute();

  $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
 $results['rows']=$viewall;
 //Showing The footer and totals 
 $footer =  DB::getPdo()->prepare("select format(sum(totalpaid),2) totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname where type='I' and branchno=$branch and $where ");
 $footer->execute();
 $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
 $results['footer']=$foots;
 echo json_encode($results);
}

public function viewstockreport($where){
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select count(*) as count from ( select stockname  from stocktrans inner join stocks on stocktrans.stockname=stocks.id inner join purchaseheaders on purchaseheaders.id=stocktrans.purchaseheaderid inner join branches on stocks.branch_id=branches.id inner join itemgroups on itemgroups.id=stocks.groupitem inner join categories on categories.id=stocks.category $where group by stockname)  f ");
    //$krows->execute();
    //$krows = DB::select("select stockname  from stocktrans group by stockname ");
    //$krows = DB::select("select COUNT(*) as count,stockname,purchaseheaders.branch_id,description,sum(if( type='I', quantity,0))-sum(if( type='O', quantity,0)) as stockavailabe,stocks.buyingrate FROM `stocktrans` inner join stocks on stocktrans.stockname=stocks.name inner join purchaseheaders on purchaseheaders.id=stocktrans.purchaseheaderid $where group by name,description,stocks.buyingrate,purchaseheaders.branch_id");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare(" Select categories.name as categoryname,categories.id as catid, itemgroups.name as groupname, groupitem, stocks.name as itemname,primaryuom,secondaryuom,uoms.isActive as num,round((stocks.limitlevel),0) as limitlevel,if(uoms.isActive>1,substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1),substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1))ctrlLimit,description,format(stocks.buyingrate,0)as buyingrate,concat(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)),' ',secondaryuom) as stockavailabe,concat(MOD(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)),uoms.isActive),' ',primaryuom) as Pieces,concat(substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1),' ', secondaryuom)as Dozens,substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1)as available FROM `stocktrans` inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id inner join branches on branches.id=purchaseheaders.branch_id inner join stocks on stocks.id=stocktrans.stockname inner join uoms on stocks.unitofmeasure=uoms.id inner join itemgroups on itemgroups.id=stocks.groupitem inner join categories on categories.id=stocks.category $where  group by stockname order by stocks.name asc limit $offset,$rows ");
    $rst->execute();

    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   
   echo json_encode($results);
}

public function profits($where){
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select("select  COUNT(*) as count from stocktrans inner join stocks on stocks.id=stocktrans.stockname  inner join customers on customers.id=stocktrans.customer $where and type='o' ");
    $results['total']=$krows[0]->count;
    $rst =  DB::getPdo()->prepare("select  customers.name as name,stocks.name as itemcode,format(stocktrans.buyingrate,0)buyingrate,format(stocktrans.sellingrate,0) as totalpaid,DATE_FORMAT(transdate,'%d-%m-%Y') as transdates,quantity,format(stocktrans.sellingrate-stocktrans.buyingrate,0) as diff from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join customers on customers.id=stocktrans.customer $where and type='o' limit $offset,$rows");
   // $rst =  DB::getPdo()->prepare("select transdates, customers.name,stocks.name as itemcode,stocktrans.quantity,stocks.buyingrate,stocktrans.totalpaid,stocks.buyingrate*stocktrans.quantity as totalbuying,stocktrans.totalpaid-stocks.buyingrate*stocktrans.quantity as diff from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join customers on customers.id=purchaseheaders.customer_id inner join branches on branches.id=purchaseheaders.branch_id $where limit $offset,$rows");
    $rst->execute();

    $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
   $results['rows']=$viewall;
   //Showing The footer and totals 
   $footer =  DB::getPdo()->prepare(" select format(sum(stocktrans.sellingrate-stocktrans.buyingrate),0) as diff from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join customers on customers.id=stocktrans.customer $where and type='o' ");
   $footer->execute();
   $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
   $results['footer']=$foots;
   echo json_encode($results);
}

public function salespendings(){
  return view('salespendings/index');
}
public function viewsalespendings(){
  if(isset($_GET['page'])&& isset($_GET['rows'])  && empty($_GET['date1']) && empty($_GET['date2'])  && empty($_GET['name']) ){
    $today=date("'Y-m-d'");
    $this->creditpendings("transdate<=$today ");
 }
 else if(isset($_GET['page'])&& isset($_GET['rows'])  && empty($_GET['date1']) && empty($_GET['date2'])  && !empty($_GET['name']) ){
  $today=date("'Y-m-d'");
  $name=$_GET['name'];
  $this->creditpendings("transdate<=$today AND customer=$name ");
}
 else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && empty($_GET['date2'])  && !empty($_GET['name']) ){
    //if(auth()->user()->admin==1){
      $name=$_GET['name'];
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $this->viewcustomerLedger("transdate <='$date1' AND customer=$name");
//}

 }
 else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['name']) ){
    //if(auth()->user()->admin==1){
      $name=$_GET['name'];
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $date2=date("Y-m-d", strtotime($_GET['date2']));
    $this->viewcustomerLedger("transdate BETWEEN '$date1' AND '$date2' and customer=$name ");
    //}

 }
}
public function creditpendings($where){
  $branch=auth()->user()->branchid;
  $results=array();
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
  $offset = ($page-1)*$rows;
  $rs =DB::getPdo();
  $krows = DB::select("SELECT  COUNT(*) as count from ( select purchaseheaderid,sum(totalamt) as totalamt, sum(totalpaid) as totalpaid FROM `stocktrans` where $where  group by purchaseheaderid having totalpaid<totalamt) as X");
 //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
  $results['total']=$krows[0]->count;
  $rst =  DB::getPdo()->prepare("select customers.id as custoid,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate,name as customer, purchaseheaderid,sum(totalamt) totalamt, format(sum(totalamt)-sum(totalpaid),0) as bal, sum(totalpaid) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer where $where  group by purchaseheaderid having totalpaid<totalamt limit $offset,$rows");
  $rst->execute();

  $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
 $results['rows']=$viewall;
DB::statement("CREATE OR REPLACE VIEW pendings as select transdate,name as customer, purchaseheaderid,sum(totalamt) totalamt, sum(totalamt)-sum(totalpaid) as bal, sum(totalpaid) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer where $where  group by purchaseheaderid having totalpaid<totalamt ");
 //Showing The footer and totals 
 $footer =  DB::getPdo()->prepare("SELECT format(sum(bal),0) as bal from pendings");
 $footer->execute();
 $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
 $results['footer']=$foots;
 echo json_encode($results); 
}
public function customerLedger(){
  return view('customerledgers/index');
}
public function customerledgerview(){
  if(isset($_GET['page'])&& isset($_GET['rows'])  && empty($_GET['date1']) && empty($_GET['date2'])  && !empty($_GET['name']) ){
    $today=date("'Y-m-d'");
    $name=$_GET['name'];
    $this->viewcustomerLedger("transdate<=$today AND customer=$name");
 }
 else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && empty($_GET['date2'])  && !empty($_GET['name']) ){
    //if(auth()->user()->admin==1){
      $name=$_GET['name'];
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $this->viewcustomerLedger("transdate <='$date1' AND customer=$name");
//}

 }
 else if(isset($_GET['page'])&& isset($_GET['rows'])  && !empty($_GET['date1']) && !empty($_GET['date2']) && !empty($_GET['name']) ){
    //if(auth()->user()->admin==1){
      $name=$_GET['name'];
    $date1=date("Y-m-d", strtotime($_GET['date1']));
    $date2=date("Y-m-d", strtotime($_GET['date2']));
    $this->viewcustomerLedger("transdate BETWEEN '$date1' AND '$date2' and customer=$name ");
    //}

 }
}
 public function dbcustomerledgerview($id){
 
    $today=date("'Y-m-d'");
    $name=$id;
    $this->viewcustomerLedger("transdate<=$today AND customer=$name");
 

}
public function viewcustomerLedger($where){
  $branch=auth()->user()->branchid;
  $results=array();
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
  $offset = ($page-1)*$rows;
  $rs =DB::getPdo();
  $krows = DB::select("select COUNT(*) as count, stocks.name as stocknames,quantity, customers.id as custoid,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate,customers.name as customer, purchaseheaderid, totalamt, totalamt-totalpaid as bal,  totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer inner join stocks on stocks.id=stocktrans.stockname where $where");
 //$krows = DB::select("select COUNT(stocktrans.purchaseheaderid) as count from purchaseheaders inner join stocktrans on purchaseheaders.id=stocktrans.purchaseheaderid inner join stocks on stocks.id=stocktrans.stockname inner join accountnames on stocktrans.purchaseheaderid=accountnames.purchaseheaderid $join inner join branches on branches.id=purchaseheaders.branch_id where $limit group by stocktrans.id");
  $results['total']=$krows[0]->count;
  $rst =  DB::getPdo()->prepare("select stocks.name as stocknames,quantity, customers.id as custoid,DATE_FORMAT(transdate,'%d-%m-%Y') as transdate,customers.name as customer, purchaseheaderid, format(totalamt,0) as totalamt, format(totalamt-totalpaid,0) as bal,  format(totalpaid,0) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer inner join stocks on stocks.id=stocktrans.stockname where $where order by stocktrans.id limit $offset,$rows");
  $rst->execute();

  $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
 $results['rows']=$viewall;
//DB::statement("CREATE OR REPLACE VIEW pendings as select transdate,name as customer, purchaseheaderid,sum(totalamt) totalamt, sum(totalamt)-sum(totalpaid) as bal, sum(totalpaid) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer   group by purchaseheaderid having totalpaid<totalamt ");
 //Showing The footer and totals 
 $footer =  DB::getPdo()->prepare("select  format(sum(totalamt),0) as totalamt, format(sum(totalamt)-sum(totalpaid),0) as bal,  format(sum(totalpaid),0) as totalpaid, stockname FROM `stocktrans` inner join customers on customers.id= stocktrans.customer inner join stocks on stocks.id=stocktrans.stockname where $where");
 $footer->execute();
 $foots=$footer->fetchAll(\PDO::FETCH_OBJ);
 $results['footer']=$foots;
 echo json_encode($results); 
}
public function checksearchparam(){
    $a=0;
    $isDefault="yes";
    
if(!empty($_GET['branch'])){
 
$a=1;
}
if(!empty($_GET['product'])&& !empty($_GET['branch'])){

    $a=2;
}

if(isset($_GET['page'])&& isset($_GET['rows']) && empty($_GET['product'])&& empty($_GET['branch'])){

    $a=3;
}

if(!empty($_GET['page'])&& !empty($_GET['rows']) && empty($_GET['product'])&& !empty($_GET['branch']) && !empty($_GET['date1']) && !empty($_GET['date2'])){

    $a=4;
}
if(isset($_GET['page'])&& isset($_GET['rows']) && !empty($_GET['product'])&& !empty($_GET['branch']) && !empty($_GET['date1']) && !empty($_GET['date2'])){

    $a=5;
}
return $a;
}
public function sendmessages(Request $request){
$con=mysqli_connect('localhost','root','','rockaboy');
$url = "www.egosms.co/api/v1/plain/?";
$sql="select * from customers";
$results=mysqli_query($con,$sql);
	

while($row=mysqli_fetch_array($results)){
	$username ="&username=denha";
$password ="&password=0704531731Denis.";
$sender ="&sender=RockaBoy";
$message = $request['text'];
$msg="&message=".urlencode($message);
$url="http://www.egosms.co/api/v1/plain/?number=";
//urlencode('256'.substr($row['phone'],1)).","
//$live_url=$url.urlencode('256'.substr($row['phone'],0)).$msg.$username.$password.$sender;
$live_url=$url.preg_replace('/\D+/', '', $row['phone']).$msg.$username.$password.$sender;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $live_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
//echo substr($row['phone'],0);
echo  urlencode('256'.substr($row['phone'],0));
$data = curl_exec($curl);
$response = curl_multi_getcontent($curl);
curl_close($curl);

/*if($response=="Message Values Empty"){
	$failed="Please take a close look at the following clients numbers. They were unable to be sent because thier phone numbers are incorrect.\n\n $row[phone]"."\n";
//mail("denisdenha@gmail.com","Failed Messages",$failed);
}*/
}


}

public function doubleClient($id){

  return view('doublecustomerledgers.index')->with('id',$id);
}
 }

 