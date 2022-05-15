<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use App\suppliers;
 use Illuminate\Support\Facades\DB;
 class suppliersController extends Controller{

public function index(){
    

    return view('suppliers/index');
}
public function view(){
    $results=array();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
    $offset = ($page-1)*$rows;
    $rs =DB::getPdo();
    $krows = DB::select('select COUNT(*) as count from suppliers');
    $results["total"]=$krows[0]->count;
    $sth =  DB::getPdo()->prepare("select * from suppliers limit $offset,$rows");
    $sth->execute();

    $dogs = $sth->fetchAll(\PDO::FETCH_OBJ);
    $results["rows"]=$dogs;
   echo json_encode($results);


   

}
public function save(Request $request){
    $Objsuppliers=new suppliers();
//$Objsuppliers->id=$request['id'];
$Objsuppliers->companyName=$request['companyName'];
$Objsuppliers->contactPerson=$request['contactPerson'];
$Objsuppliers->tel=$request['tel'];
$Objsuppliers->email=$request['email'];
$Objsuppliers->address1=$request['address1'];
$Objsuppliers->address2=$request['address2'];
$Objsuppliers->isDefault=$request['isDefault'];
$Objsuppliers->created_at=$request['created_at'];
$Objsuppliers->updated_at=$request['updated_at'];
$Objsuppliers->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objsuppliers=suppliers::find($id);

//$Objsuppliers->id=$request['id'];
$Objsuppliers->companyName=$request['companyName'];
$Objsuppliers->contactPerson=$request['contactPerson'];
$Objsuppliers->tel=$request['tel'];
$Objsuppliers->email=$request['email'];
$Objsuppliers->address1=$request['address1'];
$Objsuppliers->address2=$request['address2'];
$Objsuppliers->isDefault=$request['isDefault'];
$Objsuppliers->created_at=$request['created_at'];
$Objsuppliers->updated_at=$request['updated_at'];
$Objsuppliers->save();
}
 public function destroy($id){
        $Objsuppliers=suppliers::find($id);
        $Objsuppliers->delete();



    }
    public function viewcombo(){

        return suppliers::all();

    }
}
