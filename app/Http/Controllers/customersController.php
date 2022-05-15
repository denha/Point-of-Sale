<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\customers;

 class customersController extends Controller{

public function index(){
    return view('customers/index1');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from customers ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from customers limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);
       

    
}
public function save(Request $request){
    $Objcustomers=new customers();
//$Objcustomers->id=$request['id'];
$Objcustomers->name=$request['name'];
$Objcustomers->phone=$request['phone'];
$Objcustomers->address=$request['address'];
$Objcustomers->tel=$request['tel'];
$Objcustomers->email=$request['email'];
$Objcustomers->isActive=$request['isActive'];
$Objcustomers->created_at=$request['created_at'];
$Objcustomers->updated_at=$request['updated_at'];
$Objcustomers->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objcustomers=customers::find($id);

//$Objcustomers->id=$request['id'];
$Objcustomers->name=$request['name'];
$Objcustomers->phone=$request['phone'];
$Objcustomers->address=$request['address'];
$Objcustomers->tel=$request['tel'];
$Objcustomers->email=$request['email'];
$Objcustomers->isActive=$request['isActive'];
$Objcustomers->created_at=$request['created_at'];
$Objcustomers->updated_at=$request['updated_at'];
$Objcustomers->save();
}
 public function destroy($id){
        $Objcustomers=customers::find($id);
        $Objcustomers->delete();



    }

public function viewcombo(){

    return customers::all();
}
}
