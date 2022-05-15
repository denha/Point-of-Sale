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

.datagrid-row-alt{
    background-color: #d9f2e7;

}
.datagrid-row-selected {
  background: grey;
  color: white;
}
</style>

<script type="text/javascript">
	var rowIndex;
	//var purchase = null;
  
	fixComplete();
	$("#transdates").val(new Date().toISOString().substring(0, 10));
	function saverows(){
		var id=$('#purchaseno').val();
		$('#gridaccounttrans').edatagrid('saveRow');
		$('#gridaccounttrans').datagrid({
			url:"/viewtrans/"+id+'/D',
			method:'get'
		});


	}

	function deleterows(){
        var rows=$('#gridaccounttrans').datagrid('getSelected');
		$.ajax({
			url:'/delnewpurchase/'+rows.id,
			method:'POST',
			data:{'id':rows.id,'_token':$('input[name=_token]').val()},
			success:function(){
				$('#gridaccounttrans').datagrid('reload');
			}


		});
	
		
	}
	function addrows(){
		//var result=validateform();
		//if(result){
		$('#gridaccounttrans').edatagrid('addRow');
		//}
		
	}

	$(function(){
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
    
        // Feeding the customers
        $('#custo').combobox({
url:'/supplierscombo',
method:'get',
valueField:'id',
textField:'companyName',
onLoadSuccess:function(){
    $('#custo').combobox('select',$('#supp').val());
}
    })
   // $ (' #epsId_combo '). ComboBox (' SelectedIndex ', 0);
$('#transdates').datebox('setValue', today);
		$.ajax({
        async:false,
        url: "/newmaximum",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#purchaseno').val(element.id);

            });
        }
    });

    $.ajax({
        async:false,
        url: "maxnumber",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#header').val(element.id);

            });
        }
    });


			$('#gridaccounttrans').datagrid({
				saveUrl:'/savenewpurchase',
				url:'/viewnewpurchase/'+$('#typeahead').val(),
				method:'get',
				updateUrl:'/editnewpurchases',
				onClickRow:function(rowIndex){
					if (lastIndex != rowIndex){
						$(this).datagrid('endEdit', lastIndex);
						$(this).datagrid('beginEdit', rowIndex);
					}
					lastIndex = rowIndex;
				},
				
				onBeginEdit:function(rowIndex){
					var editors = $('#gridaccounttrans').datagrid('getEditors', rowIndex);
                    var token = $(editors[0].target);
                    var _token=$('input[name=_token]').val();
                    token.textbox('setValue',_token);
                    var maximum = $(editors[1].target);
                    maximum.textbox('setValue',$('#purchaseno').val())
                    var name = $(editors[2].target);
                    var quantity = $(editors[3].target);
                    var price = $(editors[4].target);
                    var subtotal = $(editors[5].target);
                    var header = $(editors[6].target);

                    quantity.numberbox({required:true,onChange:function(){
                        subtotal.textbox('setValue',(quantity.numberbox('getValue')*price.textbox('getValue').split(",").join("")).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    }});
                    quantity.numberbox({required:true});
                    header.textbox('setValue',$('#header').val())

                    price.textbox({required:true,
                    onChange:function(){
                        subtotal.textbox('setValue',(quantity.numberbox('getValue')*price.textbox('getValue').split(",").join("")).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    },
						inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})});



                

					/*var token = $(editors[0].target);
					var _token=$('input[name=_token]').val();
					token.textbox('setValue',_token);
					var pno=$(editors[1].target);
					pno.numberbox('setValue',$('#purchaseno').val());
					var payingaccount=$(editors[3].target);
					payingaccount.numberbox('setValue',$('#payingaccount').val());

					var amount=$(editors[6].target);
					amount.numberbox({required:true,
						inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})});
					var dat=$(editors[7].target);
					var actualdate=$('#transdates').val();
					dat.textbox('setValue',actualdate);*/
					


					

				
					
		
				}
			

			});
		});
		
	</script>

<center><h4>View Purchases </h4></center>

<form id="barcodeform" method="POST" action="{{ url('editbarcodepurchases') }}" >
    <input  type="hidden" id="header" />
<input name="_token" type="hidden" value="{{ csrf_token() }}">
<div class="form-group">
<input type="text"  name="typeahead" value={{$id}} readonly class="typeahead tt-query" id="typeahead" placeholder="Bar code" />

</div>
</form>

<div style="position:absolute;left:250px;top:40px">
<form id="dateform" method="POST" action="">
	@foreach($purc as $p)
	<input type="hidden" id="supp" value="{{$p->supplierName}}" />
<input type="text" id="transdates" value="{{$p->invoiceDate}}" style="width:56%;height:34px;" class="easyui-datebox"/>
<input  class="easyui-combobox"   style="width:56%;height:34px;" id="custo" />

@endforeach
<input type="text" id="purchaseno" hidden />
<input name="_token" type="hidden" value="{{ csrf_token() }}">
</form>
</div>



<table class='easyui-datagrid' striped="true" idField="id" rowNumbers='true' title='Items' iconCls='fa fa-table' singleSelect='true' url='' pagination='true' id='gridaccounttrans' method='get' fitColumns='true' style='width:100%' toolbar='#expensestoolbar'>
	<thead><tr>
	<th field="_token" hidden editor="textbox"  >_token</th>
	<th field="purchaseno" hidden editor="numberbox" >purchaseno</th>
	<th field='id' hidden width='100' >id</th>
	<th field='name' width='200'  editor="textbox">Name</th>
	<th field='qty' width='90' editor="numberbox">Qty</th>
	<th field='price' width='90' editor="textbox" >Price</th>
	<th field="subtotal" width='90' editor="textbox"  >Sub Total</th>
    <th field="header" hidden  width="40" editor="textbox">Header</th>

	</tr></thead>
	</table>

    <div id='expensestoolbar'>
	<!--
	<a href="#" class="easyui-linkbutton  "  onclick="addrows()">
		<i class="ace-icon fa fa-plus"></i></a>
	</a>
	<a href="#" class="easyui-linkbutton" onclick="deleterows()">
			<i class="ace-icon fa fa-trash-o bigger-160"></i>
		</a>-->
</div>
<br><!--<a href="javascript:void()" class="btn btn-primary" style="float:right;padding-left:34px;padding-right:34px;" id="save"> save </a>-->
<script>
$(document).ready(function(){
$('#save').click(function(){
    var date= $('#transdates').val();
    var supplier=$('#custo').val();
    
    $.ajax({
        method:'POST',
        url:'/saveinvoices',
        data:{'date':date,'supplier':supplier,'_token':$('input[name=_token]').val()},
        success:function(){

            $.ajax({
        async:false,
        url: "maxnumber",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#header').val(element.id);


            });
        }
    });

            $.ajax({
        async:false,
        url: "/newmaximum",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#purchaseno').val(element.id);
	  var emtpy="";
	  //$('#transdates').val(emtpy);
	  var id=$('#purchaseno').val();
		$('#gridaccounttrans').datagrid({
			
			url:'/viewnewpurchase/'+id,
			method:'get'
		});
	 
		
	  $.messager.progress('close');
	  $.messager.show({title:'Info',msg:'Transcation succesfully Saved'});

            });
        }
    });
        }
    });


})

});
</script> 
{{csrf_field()}}