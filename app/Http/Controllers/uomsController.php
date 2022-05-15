<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\uoms;

 class uomsController extends Controller{

public function index(){
    return view('uoms/index');
}
public function view(){

        $results=array();
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $offset = ($page-1)*$rows;
        $rs =DB::getPdo();
        $krows = DB::select('select COUNT(*) as count from uoms ');
        $results['total']=$krows[0]->count;
        $rst =  DB::getPdo()->prepare("select * from uoms limit $offset,$rows");
        $rst->execute();
    
        $viewall = $rst->fetchAll(\PDO::FETCH_OBJ);
       $results['rows']=$viewall;
       echo json_encode($results);

    
}
public function save(Request $request){
    $Objuoms=new uoms();
//$Objuoms->id=$request['id'];
$Objuoms->name=$request['name'];
$Objuoms->isActive=$request['isActive'];
$Objuoms->created_at=$request['created_at'];
$Objuoms->updated_at=$request['updated_at'];
$Objuoms->primaryuom=$request['primaryuom'];
$Objuoms->secondaryuom=$request['secondaryuom'];

$Objuoms->save();
}
//Auto generated code for updating
public function update(Request $request,$id){
        $Objuoms=uoms::find($id);

        $Objuoms->name=$request['name'];
        $Objuoms->isActive=$request['isActive'];
        $Objuoms->created_at=$request['created_at'];
        $Objuoms->updated_at=$request['updated_at'];
        $Objuoms->primaryuom=$request['primaryuom'];
        $Objuoms->secondaryuom=$request['secondaryuom'];
$Objuoms->save();
}
 public function destroy($id){
        $Objuoms=uoms::find($id);
        $Objuoms->delete();



    }

    public function viewcombo(){

        return DB::select("select id,name from uoms");
    }
}