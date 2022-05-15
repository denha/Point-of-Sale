<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\stocks;
use Excel;

 class exportexecelController extends Controller{

public function salereportexcel($type,$date1,$date2){
    $today=date("Y-m-d");
    $data='';
  
    if( $date1=='today'&& $date2=='today'){
        $data= $this->dailysales("transdate='$today'");
       
    }
    else if( $date1!=''&& $date2=='today'){
      if(auth()->user()->admin==1){
      $date1=date("Y-m-d", strtotime($date1));
      $data=$this->dailysales("transdate<='$date1'");
      
    }
    }
    else if( $date1!='' && $date2!=''){
      if(auth()->user()->admin==1){
      $date1=date("Y-m-d", strtotime($date1));
      $date2=date("Y-m-d", strtotime($date2));
     $data= $this->dailysales("transdate BETWEEN '$date1' AND '$date2' ");
     
      }
    }

    return Excel::create('SalesReport', function($excel) use ($data) {
        $excel->sheet('mySheet', function($sheet) use ($data)
        {
            $sheet->fromArray($data);
        });
    })->download($type);
}
public function purchasereportexcel($type,$date1,$date2){
    $today=date("Y-m-d");
    $data='';
  
    if( $date1=='today'&& $date2=='today'){
        $data= $this->dailypurchases("transdate='$today'");
       
    }
    else if( $date1!=''&& $date2=='today'){
      if(auth()->user()->admin==1){
      $date1=date("Y-m-d", strtotime($date1));
      $data=$this->dailypurchases("transdate<='$date1'");
      
    }
    }
    else if( $date1!='' && $date2!=''){
      if(auth()->user()->admin==1){
      $date1=date("Y-m-d", strtotime($date1));
      $date2=date("Y-m-d", strtotime($date2));
     $data= $this->dailypurchases("transdate BETWEEN '$date1' AND '$date2' ");
     
      }
    }

    return Excel::create('PurchaseReport', function($excel) use ($data) {
        $excel->sheet('mySheet', function($sheet) use ($data)
        {
            $sheet->fromArray($data);
        });
    })->download($type);
}

public function expensereportexcel($type,$date1,$date2){
  $today=date("Y-m-d");
  $data='';
 
  if( $date1=='today'&& $date2=='today'){
      $data= $this->expenses("where transdates= '$today'  AND accounttypes.id=7 AND accounttrans.accountcode!=1001 AND ttype='D' AND credit is Null and amount>0 ","format(sum(if(ttype='D',amount,'')),0)as amount","inner join chartofaccounts on chartofaccounts.accountcode=accounttrans.accountcode inner join accounttypes on accounttypes.id=chartofaccounts.accounttype");
     
  }
  else if( $date1!=''&& $date2=='today'){
    if(auth()->user()->admin==1){
    $date1=date("Y-m-d", strtotime($date1));
    $data=$this->expenses("where transdates<= '$date1'  AND accounttypes.id=7 AND accounttrans.accountcode!=1001 AND ttype='D' AND credit is Null and amount>0 ","format(sum(if(ttype='D',amount,'')),0)as amount","inner join chartofaccounts on chartofaccounts.accountcode=accounttrans.accountcode inner join accounttypes on accounttypes.id=chartofaccounts.accounttype");
    
  }
  }
  else if( $date1!='' && $date2!=''){
    if(auth()->user()->admin==1){
    $date1=date("Y-m-d", strtotime($date1));
    $date2=date("Y-m-d", strtotime($date2));
   $data= $this->expenses("where transdates BETWEEN '$date1' AND '$date2'  AND accounttypes.id=7 AND accounttrans.accountcode!=1001 AND ttype='D' AND credit is Null and amount>0 ","format(sum(if(ttype='D',amount,'')),0)as amount","inner join chartofaccounts on chartofaccounts.accountcode=accounttrans.accountcode inner join accounttypes on accounttypes.id=chartofaccounts.accounttype ");
   
    }
  }

  return Excel::create('ExpenseReport', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
          $sheet->fromArray($data);
      });
  })->download($type);

}

public function bankreportexcel($type,$date1,$date2,$bank){
  $today=date("Y-m-d");
  $data='';
 
  if( $date1=='today'&& $date2=='today' && $bank=='bank'){
      $data= $this->banking("date='$today'");
     
  }
  else if( $date1!=''&& $date2=='today' && $bank=='bank'){
    if(auth()->user()->admin==1){
    $date1=date("Y-m-d", strtotime($date1));
    $data=$this->banking("date <='$date1'");
    
  }
  }
  else if( $date1!='' && $date2!='' && $bank=='bank'){
    if(auth()->user()->admin==1){
    $date1=date("Y-m-d", strtotime($date1));
    $date2=date("Y-m-d", strtotime($date2));
   $data= $this->banking("date BETWEEN '$date1' AND '$date2'");
   
    }
  }
  else if( $date1=='today'&& $date2=='today' && $bank!='bank'){
    $branch=$bank;
    $data= $this->banking("date='$today' AND bankid=$branch");
   
}
else if( $date1!=''&& $date2=='today' && $bank!='bank'){
  if(auth()->user()->admin==1){
    $branch=$bank;
  $date1=date("Y-m-d", strtotime($date1));
  $data=$this->banking("date <='$date1' and bankid=$branch");
  
}
}

else if( $date1!=''&& $date2=='today' && $bank!='bank'){
  if(auth()->user()->admin==1){
    $branch=$bank;
  $date1=date("Y-m-d", strtotime($date1));
  $date2=date("Y-m-d", strtotime($date2));
  $data=$this->banking("date BETWEEN '$date1' and '$date2' and bankid=$branch");
  
}
}

  return Excel::create('BankingReport', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
          $sheet->fromArray($data);
      });
  })->download($type);

}

public function stockdetail($type,$id){
   $data=$this->stockdetailExcel($id);
   
  return Excel::create('StockDetailReport', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
          $sheet->fromArray($data);
      });
  })->download($type);
}
public function dailysales($where){
    $branch=auth()->user()->branchid;
    $result= DB::select("select name as Item_Name,description as Description,customer as Customer, DATE_FORMAT(transdate,'%d-%m-%Y') as Transaction_Date,quantity as Quantity,format(totalamt,0) as Amount  from stocktrans inner join stocks on stocks.id=stocktrans.stockname where type='O' and branchno=$branch and $where order by purchaseheaderid asc ");
   return json_decode(json_encode($result), true);
  
  }
  public function dailypurchases($where){
    $branch=auth()->user()->branchid;
    $rst =  DB::select("select  DATE_FORMAT(transdate,'%d-%m-%Y') as Transaction_Date, companyName as Supplier,name as Item_Name,quantity as Quantity,format(totalpaid,0) as totalpaid,format(totaldue,0) as Totaldue,format(totalamt,0) as Totalamt from stocktrans inner join stocks on stocks.id=stocktrans.stockname inner join purchaseheaders on purchaseheaders.id=stocktrans.purchaseheaderid inner join suppliers on suppliers.id=purchaseheaders.supplier_id where type='I' and branchno=$branch and $where  order by purchaseheaderid asc ");
    return json_decode(json_encode($rst), true);
  }

  public function expenses($where){
    $branch=auth()->user()->branchid;
    $rst=DB::select("select  DATE_FORMAT(transdates,'%d-%m-%Y') Transaction_Date,narration as Narration,format(if(ttype='D',amount,''),0)as Amount from (select * from chartofaccounts where branchno=$branch)as chartofaccounts inner join accounttrans on chartofaccounts.accountcode=accounttrans.accountcode inner join purchaseheaders on purchaseheaders.id=accounttrans.purchaseheaderid inner join accounttypes on chartofaccounts.accounttype=accounttypes.id   $where and bracid=$branch");
    return json_decode(json_encode($rst), true);
  }
  public function banking($where){
    $branch=auth()->user()->branchid;
    $rst =  DB::select("select  DATE_FORMAT(date,'%d-%m-%Y') Transaction_Date,accountname as Bank_Name ,paymentdetail as Payment_Details ,format(amount,0) amount from bankings inner join chartofaccounts on chartofaccounts.accountcode=bankings.bankid where bankings.branchno=$branch and $where ");
    return json_decode(json_encode($rst), true);
  }


  public function stockdetailExcel($id){
    DB::statement("set @CumulativeSum := 0;");
    $results= DB::select("select DATE_FORMAT(transdate,'%d-%m-%Y') as date,stocks.name as name,description,if(type='I',quantity,-quantity) as quantity,(@CumulativeSum := @CumulativeSum + case when type='i' then quantity when type='o' then -quantity when quantity is Null then 0 end ) as available from stocktrans inner join stocks on stocks.id=stocktrans.stockname where stockname=$id");
    return json_decode(json_encode($results), true);

  }

}