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
	
	//fixComplete();
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
    $('#custo').combobox('select',1);
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
        url: "/maxnumber",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#header').val(element.id);

            });
        }
    });


			$('#gridaccounttrans').edatagrid({
				saveUrl:'/saveinvoiceexpense',
				url:'/viewstockentry/'+$('#typeahead').val(),//url:'/viewexp/'+$('#header').val(),
				method:'get',
				updateUrl:'/updatestockentry',
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
					var name = $(editors[1].target);
					name.textbox({required:true});
					var description = $(editors[2].target);
					description.textbox({required:true});
					var limit = $(editors[3].target);
					limit.numberbox({required:true});
					var cat = $(editors[4].target);
					cat.textbox({required:true});
					var sell = $(editors[9].target);
					sell.textbox({required:true,
						inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})});
				

                   /* var maximum = $(editors[1].target);
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
*/


                



					

				
					
		
				}
			

			});
		});
		
	</script>

<center><h4> Stock Entry  </h4></center>

<form id="barcodeform" method="POST" action="{{ url('editbarcodepurchases') }}" >
    <input  type="hidden" id="header" />
<input name="_token" type="hidden" value="{{ csrf_token() }}">
<div class="form-group">
<input type="text"  name="typeahead" value="{{$id}}" readonly class="typeahead tt-query" id="typeahead" placeholder="Bar code" />

</div>
</form>

<div style="position:absolute;left:250px;top:40px">
<form id="dateform" method="POST" action="">
<input type="text" id="transdates" style="width:56%;height:34px;" class="easyui-datebox"/>
<input  class="easyui-combobox"  style="width:56%;height:34px;" id="custo" />

<input type="text" hidden id="purchaseno"  />
<input name="_token" type="hidden" value="{{ csrf_token() }}">
</form>
</div>
<table class='easyui-datagrid' idField="accounttransid" rowNumbers='true' title='' iconCls='fa fa-table' singleSelect='true' url='' pagination='true' id='gridaccounttrans' method='get' fitColumns='true' style='width:100%' toolbar='#expensestoolbar'>
	<thead><tr>
	<th field="_token" hidden editor="textbox"  hidden="true">_token</th>
    <th field="name" editor="textbox" width="150">Name </th>
	<th field="description" editor="textbox" width="180">Description </th>
	<th field="limits" width="50" editor="numberbox">Limit  </th>
	<th field="category"  width="50"
	data-options="editor:
	{type:'combobox',options:{url:'/categoriescombo',method:'get',valueField:'id',textField:'name',
		onSelect:function(rows){
	var tr=$(this).closest('tr.datagrid-row');
				var idx=parseInt(tr.attr('datagrid-row-index'));
				var ed=$('#gridaccounttrans').datagrid('getEditor',{index:idx,field:'categorycode'});
				$(ed.target).numberbox('setValue',rows.id);


}}}" >Category </th>
	<th field="qty" width="50">Qty</th>
	<th field="dmgqty" editor="numberbox" width="80">Damaged Qty</th>
	<th field="recqty" editor="numberbox" width="80">Recieved Qty</th>
	<th field="remarks" editor="textbox" width="50">Remarks</th>
	<th field="costperitem" editor="textbox" width="50">Cost </th>
	<th field="selling" editor="textbox" width="50">Selling</th>
	<th field="id" hidden  width="50">ID</th>
	<th field="categorycode" editor="numberbox" hidden>Category code </th>
	
	
	
	
	
	
	
	

	</tr></thead>
	</table>

<div id='expensestoolbar'>
	
<!--	<a href="#" class="easyui-linkbutton  "  onclick="addrows()">
		<i class="ace-icon fa fa-plus"></i></a>

	</a>
	<a href="#" class="easyui-linkbutton" onclick="deleterows()">
			<i class="ace-icon fa fa-trash-o bigger-160"></i>
		</a>-->
</div>


<br><a href="javascript:void()" class="btn btn-primary" style="float:right;padding-left:34px;padding-right:34px;" id="save"> save </a>
<script>
$(document).ready(function(){
$('#save').click(function(){
    var date= $('#transdates').val();
    var supplier=$('#custo').val();
	var id = $('#typeahead').val();
    $.ajax({
        method:'POST',
        url:'/savecalculatedstock',
        data:{ 'id':id,'asof':date,'supplier':supplier,'_token':$('input[name=_token]').val()},
		success:function(data){
			if(data.sellingPrice==false){
				$.messager.alert('Validation','You must fill in the selling price ','warning');
			}else if(data.description==false){
				$.messager.alert('Validation','You must fill in the price Description ','warning');	
			}
			else if(data.limits==false){
				$.messager.alert('Validation','You must fill in the limit level ','warning');	
			}else{
			//window.location='/newpurchasereports';
			}
		}


});

});
});
Denis();
function Denis(){
	var url1="/isComplete";
	$.getJSON(url1,function(data){
    $.each(data, function (index, value) {
        var countresults=value.count;
        if(countresults>0){
            $.messager.alert('Warning','There is an Incomplete Transaction, Click ok to fix this Issue','warning');  
        }
        }); 
    });  
}

</script> 
{{csrf_field()}}