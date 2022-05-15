<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\workers;

 class laptopsController extends Controller{

public function andrew(){

    echo "its this very easy";
}
public function denis($id){
    return view('andrew/andrew');
}

}