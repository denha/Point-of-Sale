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
$member_id = 2;
require_once "ShoppingCart.php";
$shoppingCart = new ShoppingCart();
use Illuminate\Support\Facades\DB;
if(isset($_POST['typeahead'])){
$typehead=$_POST['typeahead'];
if(is_numeric($typehead)){
  
  $items=DB::select("select id,name,partno,description,buyingrate,sellingrate,barcode from stocks where barcode=$typehead");
}else{
  $items=DB::select("select id,name,partno,description,buyingrate,sellingrate,barcode from stocks where name='$typehead'");
}

foreach($items as $ite){
  //print_r($product_array);
  $productResult = $shoppingCart->getProductByCode($ite->id);
                
  $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $member_id);
  $shoppingCart->addToCart($productResult[0]["id"], 1, $member_id,$ite->buyingrate,getQty($ite->id));
 
}
}

$member_id = 2; // you can your integerate authentication module here to get logged in member


if (! empty($_GET["action"])) {
	echo "denis";
    switch ($_GET["action"]) {
        case "add":
		echo "My";
            if (! empty($_GET["quantity"])) {
                echo "yes";
                $productResult = $shoppingCart->getProductByCode($_GET["code"]);
                
                $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $member_id);
                
                if (! empty($cartResult)) {
                    // Update cart item quantity in database
                    $newQuantity = $cartResult[0]["quantity"] + $_GET["quantity"];
                    $shoppingCart->updateCartQuantity($newQuantity, $cartResult[0]["id"]);
                } else {
                    // Add to cart table
                    $shoppingCart->addToCart($productResult[0]["id"], $_GET["quantity"], $member_id,0);
                }
            }
            break;
        case "remove":
            // Delete single entry from the cart
            $shoppingCart->deleteCartItem($_GET["id"]);
            break;
        case "empty":
            // Empty cart
            $shoppingCart->emptyCart($member_id);
            break;
    }
}
?>

<center><h4> Purchases </h4></center>

<form id="barcodeform" method="POST" action="" >
<input name="_token" type="hidden" value="{{ csrf_token() }}">
<div class="form-group">
<input type="text"  name="typeahead" class="typeahead tt-query" id="typeahead" placeholder="Bar code" />


</div>
</form>

<div style="position:absolute;left:250px;top:40px">
<form id="dateform" method="POST" action="">
<input type="text" id="transdates" style="width:56%;height:34px;" class="easyui-datebox"   />
<input  class="easyui-combobox"  style="width:56%;height:34px;" id="custo" />
<input type="text" id="purchaseno"  hidden/>
<input name="_token" type="hidden" value="{{ csrf_token() }}">
</form>
</div>
<?php

$cartItem = $shoppingCart->getMemberCartItem($member_id);
if (! empty($cartItem)) {
    $item_quantity = 0;
    $item_price = 0;
    if (! empty($cartItem)) {
        foreach ($cartItem as $item) {
            $item_quantity = $item_quantity + $item["quantity"];
            $item_price = $item_price + ($item["sellingpx"] * $item["quantity"]);
            
        }
    }
}
?>
<table class="table table-bordered">
<tr>
<th width="140px">Part No</th>
<th width="320px">Item Name</th>
<th width="150px">Available</th>
<th width="150px">Qty</th>
<th width="150px">Cost</th>
<th width="150px">Sub Total</th>
<th width="150px">Remove</th>
</tr>

<tr>
<?php
if (! empty($cartItem)) {
    ?>
	<?php
    foreach ($cartItem as $item) {
        ?>
			
                    
					
<td width="140px"><?php echo $item['barcode']; ?></td>
<td width="320px" ><?php echo $item["name"]; ?></td>
<td width="150px" ><b><?php echo getQty($item['id']);  ?></b></td>
<td width="150px">
<input style="width:100%;height:20%;" class="input-quantity"
                        id="input-quantity-<?php echo $item["cart_id"]; ?>" value="<?php echo $item["quantity"]; ?>" 
						onBlur="increment_quantity(<?php echo $item["cart_id"]; ?>, document.getElementById('pricex-<?php echo $item['cart_id']; ?>').value)"/>
</td>
<th width="150px"><input class="prices" style="width:100%;height:20%" id="pricex-<?php echo $item["cart_id"]; ?>" name='price' value='<?php echo  number_format($item["sellingpx"],0); ?>'
onBlur="increment_quantity(<?php echo $item["cart_id"]; ?>, document.getElementById('pricex-<?php echo $item['cart_id']; ?>').value)" /></th>
<th width="150px">
                <div class="cart-info price" id="cart-price-<?php echo $item["cart_id"]; ?>">
                        <?php echo  number_format(($item["sellingpx"] * $item["quantity"]),0); ?>
                    </div>
</th>
<th width="150px">                <div class="cart-info action">
                 
                    <a  class='remove'  id="<?php echo $item['cart_id']; ?>" href="javascript:void(0)"
                    
                        class="btnRemoveAction"><img
                        src="icon-delete.png" alt="icon-delete"
                        title="Remove Item" /></a>
                </div></th>
</tr>
 				<?php
				//echo $item["cart_id"];
    }
    ?>

  <?php
}
?>
</table>
<div style="float:right;" >
<div class="form-group">
<input id='tot' hidden value="<?php 
if (! empty($cartItem)) {
  echo $item_price;
 } ?>"/>
<label> <b style="color:grey;">TOTAL COST  :</b></label><input readonly value="
  <?php
  if (! empty($cartItem)) { 
  echo "UGX ".number_format($item_price,0); 
  }

 ?>"  id="totalcost" type="text" style="width:170px;margin-left:75px;" /><br>
<label> <b style="color:grey">CASH PAID  :</b></label><input type="text" id="cashpaid" name="cashpaid" style="width:170px;margin-left:89px;" /><br>
<label> <b style="color:grey">BAL  :</b></label><input id="bal" type="text" style="width:170px;margin-left:136px;" />
<br><br><a href="javascript:void()" class="btn btn-primary" style="width:100px;margin-left:207px;" id="save"> save </a>

</div>

</div>

<script>

function increment_quantity(cart_id, price) {
    var inputQuantityElement = $("#input-quantity-"+cart_id);
	var inpuPric=$("#pricex-"+cart_id);
	pric=parseInt($(inpuPric).val().replace(/,/g,''));
    var newQuantity = parseInt($(inputQuantityElement).val());
    var newPrice = newQuantity * pric;
	//alert(newQuantity);
    save_to_db(cart_id, newQuantity, newPrice,pric);
    $("#typeahead").focus();
}

function decrement_quantity(cart_id, price) {
    var inputQuantityElement = $("#input-quantity-"+cart_id);
    if($(inputQuantityElement).val() > 1) 
    {
    var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
    var newPrice = newQuantity * price;
    save_to_db(cart_id, newQuantity, newPrice);
    }
}

function save_to_db(cart_id, new_quantity, newPrice,pric) {
	var inputQuantityElement = $("#input-quantity-"+cart_id);
	var priceElement = $("#cart-price-"+cart_id);
    $.ajax({
		url : "updatequantity",
		data : "cart_id="+cart_id+"&new_quantity="+new_quantity+"&price="+pric+"&_token="+$('input[name=_token]').val(),
		type : 'post',
		success : function(response) {
			$(inputQuantityElement).val(new_quantity);
            $(priceElement).text(""+newPrice.toLocaleString());
            var totalQuantity = 0;
            $("input[id*='input-quantity-']").each(function() {
                var cart_quantity = $(this).val();
                totalQuantity = parseInt(totalQuantity) + parseInt(cart_quantity);
            });
            $("#total-quantity").text(totalQuantity);
            var totalItemPrice = 0;
            $("div[id*='cart-price-']").each(function() {
                var cart_price = $(this).text().replace("","");
                totalItemPrice = parseInt(totalItemPrice) + parseInt(cart_price.replace(/,/g,''));
                //alert();
            });
            $("#totalcost").val('UGX '+totalItemPrice.toLocaleString());
            $("#tot").val(totalItemPrice);
		}
	});
}

fixComplete();
$(function() {
  $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'/search/%QUERY',
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

<?php
if (! empty($cartItem)) {
    ?>
	<?php
    foreach ($cartItem as $item) {
        ?>

$('#pricex-<?php echo $item['cart_id']; ?>').keyup(function(event){
  if(event.which>=37 && event.which<=40)return;
  $(this).val(function(index,value){
    return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  });

});

<?php
    }
  }
?>

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
//$('#transdates').val(today);	
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
$('.remove').click(function(){
  var del_id = $(this).attr("id");
  var info = 'id=' + del_id+"&_token="+$('input[name=_token]').val();
  $.ajax({
           type : "POST",
           url : "delbarcodeitem", 
           data : info,
           success : function() {
            $('#dateform').submit();
                        }
          });
  
});
$('#custo').combobox({
url:'/supplierscombo',
method:'get',
valueField:'id',
textField:'companyName',
onLoadSuccess:function(){
    $('#custo').combobox('select',1);
}
    })
$('#save').click(function(){
var transdates=$('#transdates').val();
var purchaseno=$('#purchaseno').val();
var cashpaid=$('#cashpaid').val();
var totalcost=$('#totalcost').val();
var bal=$('#bal').val();
var custo=$('#custo').val();
if(cashpaid==''){
  $.messager.alert('Warning','Please Fill in Cash Paid Field ','warning'); 
}else{

$.ajax({
'url':'/barcodepurchasesave',
'method':'POST',
'data':{'supplier':custo,'transdates':transdates,'bal':bal,'totalcost':totalcost,'purchaseno':purchaseno,'cashpaid':cashpaid,'_token':$('input[name=_token]').val()},
success:function(data){
  $('#dateform').submit();
  //windows.href="";

}

});
}
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
function fixComplete(){
    $.getJSON('isComplete',function(data){
    $.each(data, function (index, value) {
        var countresults=value.count;
        if(countresults>0){
           // $.messager.alert('Warning','There is an Incomplete Transaction, Click ok to fix this Issue','warning');  
        }
        }); 
    });  
}

</script>
<script type="text/javascript" src="assets/customjs/typeahead.min.js"></script>
<?php
function getQty($product){
$branch=auth()->user()->branchid;
$results=DB::select("Select categories.name as categoryname,categories.id as catid, itemgroups.name as groupname, groupitem, stocks.name as itemname,primaryuom,secondaryuom,uoms.isActive as num,round((stocks.limitlevel),0) as limitlevel,if(uoms.isActive>1,substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1),substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1))ctrlLimit,description,format(stocks.buyingrate,0)as buyingrate,concat(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)),' ',secondaryuom) as stockavailabe,concat(MOD(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)),uoms.isActive),' ',primaryuom) as Pieces,concat(substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1),' ', secondaryuom)as Dozens,substring_index(cast(sum(if( type='I'or type='IT', quantity,0))-sum(if( type='O' or type='OT', quantity,0)) AS unsigned) / uoms.isActive ,'.',1)as available FROM `stocktrans` inner join purchaseheaders on stocktrans.purchaseheaderid=purchaseheaders.id inner join branches on branches.id=purchaseheaders.branch_id inner join stocks on stocks.id=stocktrans.stockname inner join uoms on stocks.unitofmeasure=uoms.id inner join itemgroups on itemgroups.id=stocks.groupitem inner join categories on categories.id=stocks.category where stockname=$product AND branches.id=$branch   group by stockname order by stocks.name asc");
foreach($results as $rs){
    return $rs->available;
}
}
?>