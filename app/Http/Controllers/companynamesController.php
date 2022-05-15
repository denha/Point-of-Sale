<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\companynames;

 class companynamesController extends Controller{

public function index(){
    return view('companynames/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from companynames ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from companynames limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objcompanynames=new companynames();
$Objcompanynames->id=$request['id'];
$Objcompanynames->companyname=$request['companyname'];
$Objcompanynames->boxnumber=$request['boxnumber'];
$Objcompanynames->telphone=$request['telphone'];
$Objcompanynames->location=$request['location'];
$Objcompanynames->created_at=$request['created_at'];
$Objcompanynames->updatated_at=$request['updatated_at'];
$Objcompanynames->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objcompanynames=companynames::find($id);

$Objcompanynames->id=$request['id'];
$Objcompanynames->companyname=$request['companyname'];
$Objcompanynames->boxnumber=$request['boxnumber'];
$Objcompanynames->telphone=$request['telphone'];
$Objcompanynames->location=$request['location'];
$Objcompanynames->created_at=$request['created_at'];
$Objcompanynames->updatated_at=$request['updatated_at'];
$Objcompanynames->save();
}
 public function destroy($id){
        $Objcompanynames=companynames::find($id);
        $Objcompanynames->delete();



    }

public function viewcombo(){


    return companynames::all();
}
}