@include('layouts/header')
<style type="text/css">
.bs-example{
	font-family: sans-serif;
	position: relative;
	margin: 50px;
}
.typeahead, .tt-query, .tt-hint {
	border: 2px solid #CCCCCC;
	border-radius: 8px;
	font-size: 24px;
	height: 34px;
	line-height: 30px;
	outline: medium none;
	padding: 8px 12px;
	width: 220px;
}
.typeahead {
	background-color: #FFFFFF;
}
.typeahead:focus {
	border: 2px solid #0097CF;
}
.tt-query {
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
	color: #999999;
}
.tt-dropdown-menu {
	background-color: #FFFFFF;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 0px;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	margin-top: 12px;
	padding: 0px 0;
	width: 220px;
}
.tt-suggestion {
	font-size: 14px;
	line-height: 24px;
	padding: 0px 15px;
}
.tt-suggestion.tt-is-under-cursor {
	background-color: #0097CF;
	color: #FFFFFF;
}
.tt-suggestion p {
	margin: 0;
}
</style>
<script>


</script>
<?php
if (isset($_POST['id1'])) {
  $var = $_GET['id1'];
  echo($var);
}

use Illuminate\Support\Facades\DB;
if(isset($_POST['typeahead'])){
$typehead=$_POST['typeahead'];
if(is_numeric($typehead)){
  
  $items=DB::select("select id,name,buyingrate,partno,description,sellingrate,barcode from stocks where barcode=$typehead");
}else{
  $items=DB::select("select id,name,partno,buyingrate,description,sellingrate,barcode from stocks where name='$typehead'");
}
$name="";
$code="";
$buyingrate="";
$sellingrate="";
$barcode="";
if(count($items)<1){

}
foreach($items as $item){
  $name=$item->name;
  $code=$item->id;
  $buyingrate=$item->buyingrate;
  $sellingrate=$item->sellingrate;
  $barcode=$item->barcode; 
}

$cartArray = array(
	$code=>array(
	'name'=>$name,
	'code'=>$code,
	'buyingrate'=>$buyingrate,
	'quantity'=>1,
  'sellingrate'=>count($items)<1 ? 0 : $sellingrate,
  'barcode'=>$barcode,
  )
);

if(empty($_SESSION["shopping_cart"])) {
  $_SESSION["shopping_cart"] = $cartArray;
 
}else{
  $array_keys = array_keys($_SESSION["shopping_cart"]);

  $_SESSION["shopping_cart"] = array_merge(
  $_SESSION["shopping_cart"],
  $cartArray
  );

}
}
if(isset($_POST['removebtn'])){
if (isset($_POST['action']) && $_POST['action']=="remove"){

 
  if(!empty($_SESSION["shopping_cart"])) {
      foreach($_SESSION["shopping_cart"] as $key => $value) {
        //print_r($_SESSION["shopping_cart"]);
        if($_POST["code"] == $value['code']){
          unset($_SESSION["shopping_cart"][$key]);

        }
        if(empty($_SESSION["shopping_cart"]))
        unset($_SESSION["shopping_cart"]);
        }		
  }
}
}
if (isset($_POST['changeprice']) && isset($_POST['quantity']) ){
  if(!empty($_SESSION["shopping_cart"])) {
  foreach($_SESSION["shopping_cart"] as &$value){
$_POST['code'];
    if($value['code'] == $_POST['code']){
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
}
  }  	
}

?>

<center><h4> Sales </h4></center>

<form id="barcodeform" method="POST" action="{{ url('editbarcodesales') }}" >
<input name="_token" type="hidden" value="{{ csrf_token() }}">
<div class="form-group">
<input type="text"  name="typeahead" class="typeahead tt-query" id="typeahead" placeholder="Bar code" />


</div>
</form>

<div style="position:absolute;left:250px;top:40px">
<form id="dateform" method="POST" action="">
<input type="text" id="transdates"  style="width:108%;height:34px;" class="easyui-datebox"  />
<input type="text" id="purchaseno"  hidden/>
<input name="_token" type="hidden" value="{{ csrf_token() }}">
</form>
</div>
<table class="table table-bordered">
<tr>
<th width="140px">Part No</th>
<th width="320px">Item Name</th>
<th width="150px">Qty</th>
<th width="150px">Cost</th>
<th width="150px">Sub Total</th>
<th width="150px">Remove</th>
</tr>
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
}
?>

<?php		
if(!empty($_SESSION["shopping_cart"])) {
foreach ($_SESSION["shopping_cart"] as $product){
?>

<tr>
<td width="140px"><?php echo $product['barcode']; ?>
<td width="320px" ><?php echo $product['name']; ?>
<td width="150px">
<form  method="POST"   id="price" action="{{ url('editbarcodesales') }}">
<input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
<input type='hidden' name='changeprice' value="changeprice" />
<input type='text' name='quantity[]' value='<?php echo $product['quantity']=5; ?>'
 </td>
<td width="150px"><?php echo number_format($product['sellingrate'],0); ?>
<td width="150px"><?php echo number_format($product["sellingrate"]*$product["quantity"],0); ?></td>
<td width="150px" >

<form>
<form  method="POST" id="removeform" name="removeform" action="{{ url('editbarcodesales') }}">
<input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' name='removebtn'>Remove</button>
<input name="_token" type="hidden" value="{{ csrf_token() }}">
</form>
</td>

</tr>

<?php
$total_price += ($product["sellingrate"]*$product["quantity"]);
}
}
?>
</table>

<div style="float:right;" >
<div class="form-group">
<input type="hidden"value="<?php 
if(!empty($_SESSION["shopping_cart"])){
echo $total_price;
}
 ?>" id="tot" />
<label> <b style="color:grey;">TOTAL COST  :</b></label><input readonly value="<?php
if(!empty($_SESSION["shopping_cart"])){
  echo "UGX ".number_format($total_price,0);
}
 ?>"  id="totalcost" type="text" style="width:170px;margin-left:75px;" /><br>
<label> <b style="color:grey">CASH PAID  :</b></label><input type="text" id="cashpaid" name="cashpaid" style="width:170px;margin-left:89px;" /><br>
<label> <b style="color:grey">BAL  :</b></label><input id="bal" type="text" style="width:170px;margin-left:136px;" />
<br><br><a href="javascript:void()" class="btn btn-primary" style="width:100px;margin-left:207px;" id="save"> save </a>

</div>

</div>

<script>
$(function() {
  $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search/%QUERY',
        limit : 10
    });
  $("#typeahead").focus();
$('#cashpaid').keyup(function(event){
  if(event.which>=37 && event.which<=40)return;
  $(this).val(function(index,value){
    return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  });
  var han=$('#tot').val().replace(/\D/g, "");
var sum1=$('#cashpaid').val().replace(/\D/g, "")-han;
$('#bal').val(sum1);
});

$.ajax({
        async:false,
        url: "maxnumber",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#purchaseno').val(element.id);

            });
        }
    });
/* seting todays date */
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = dd + '-' + mm + '-' + yyyy;
$('#transdates').datebox({
        formatter : function(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
        },
        parser : function(s){

            if (!s) return new Date();
            var ss = s.split('-');
            var y = parseInt(ss[2],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[0],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d)
            } else {
                return new Date();
            }
        }

    });
$('#transdates').datebox('setValue', today);	
/* End Todays date */
/* save data to barcodesalessave */
$('#save').click(function(){
var transdates=$('#transdates').val();
var purchaseno=$('#purchaseno').val();
var cashpaid=$('#cashpaid').val();
var totalcost=$('#totalcost').val();
var bal=$('#bal').val();

$.ajax({
'url':'barcodesalessave',
'method':'POST',
'data':{'transdates':transdates,'bal':bal,'totalcost':totalcost,'purchaseno':purchaseno,'cashpaid':cashpaid,'_token':$('input[name=_token]').val()},
success:function(data){
  $('#dateform').submit();
  //windows.href="";

}

});

});
$(document).on("keypress", "input.typeahead", function(e){
        if(e.which == 13){
            var inputVal = $(this).val();
            $('#barcodeform').submit();
        }
    });
});
/*($(document).on("keypress", "input.cashpaid", function(e){
        if(e.which == 13){
            var inputVal = $(this).val();
            if(inputVall!=''){
              $('#dateform').submit();
            }
           
        }
    });
});*/
function submitting(){
  document.forms.price.submit();

}


</script>
<script type="text/javascript" src="assets/customjs/typeahead.min.js"></script>