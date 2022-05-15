<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\itemgroups;

 class itemgroupsController extends Controller{

public function index(){
    return view('itemgroups/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from itemgroups ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from itemgroups limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objitemgroups=new itemgroups();
$Objitemgroups->id=$request['id'];
$Objitemgroups->name=$request['name'];
$Objitemgroups->updated_at=$request['updated_at'];
$Objitemgroups->created_at=$request['created_at'];
$Objitemgroups->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
    if($id==1){
        return['isDel'=>'No'];
    }else{
        $Objitemgroups=itemgroups::find($id);

//$Objitemgroups->id=$request['id'];
$Objitemgroups->name=$request['name'];
$Objitemgroups->updated_at=$request['updated_at'];
$Objitemgroups->created_at=$request['created_at'];
$Objitemgroups->save();
    }
}
 public function destroy($id){
     if($id==1){
         return['isDel'=>'No'];
     }else{
        $Objitemgroups=itemgroups::find($id);
        $Objitemgroups->delete();
     }



    }

public function viewcombo(){


    return itemgroups::all();
}
}