
@include('layouts/header')
<style>
.datagrid-row-alt{
    background-color: #d9f2e7;

}
.datagrid-row-selected {
  background: grey;
  color: white;
}
</style>
<center><h4>Purchase Stock </h4></center>
<div style='padding:5px;margin-left:13px;' id='purchaseheaders' /><a href='javascript:void(0)' class='btn btn-primary'id='savepurchaseheaders'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a></div>
<form style='width:100%;padding:5px;'  id='frmpurchaseheaders' >

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><div><input  class=" easyui-datebox form-control" style="width:100%;height:34px" name='transdates' 
 id='transdates' required data-options="onSelect:validateDate"  /></div>
</div>
</div>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Mode of Payment</label></div><input  class='form-control easyui-combobox' style="width:100%;height:34px"  data-options="url:'combomodeofpayments',valueField:'id',textField:'name',method:'get',required:'true'" name='mode' 
 id='mode' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Supplier</label></div><input required class='form-control easyui-combobox' style="width:100%;height:34px"  name='supplier_id' 
 id='supplier_id' /></div>
</div>
<div class="col-lg-6">
	<div class="form-group">
		<div><label>Recieving Branch</label></div>
	<div><input type="text" class="form-control easyui-combobox" id='branch' name='branch' style="width:100%;height:34px"/></div>
	</div>
</div>
<input type='hidden' class='form-control' name='id' 
 id='purchaseno'  readonly/>
 <input  type="hidden" class='easyui-combobox'  data-options="method:'get',required:'true'" name='mode' 
	 id='paccount' />
</form>

<div id='toolbaredit'>
	
	<a href="#" class="easyui-linkbutton  "  onclick="addrows()">
		<i class="ace-icon fa fa-plus"></i></a>
<!--	<a href="#" class="easyui-linkbutton " id='save' onclick="saverows()">
		<i class="ace-icon fa fa-floppy-o bigger-160"></i></a>
	<a href="#" class="easyui-linkbutton"  onclick="javascript:$('#tt').edatagrid('cancelRow')">
		<i class="ace-icon fa fa-times"></i>
	</a>-->
	<a href="#" class="easyui-linkbutton" onclick="deleterows()">
			<i class="ace-icon fa fa-trash-o bigger-160"></i>
		</a>
</div>
</div></div>

	<table class="easyui-datagrid" toolbar="#toolbaredit"  striped="true" idField="identity" title='stockitem' rownumbers='true' iconCls='fa fa-table' singleSelect='true'  pagination='true' id='tt'  fitColumns='true' style='width:100%'  fitColumns='true' showFooter="true">
		<thead>
			<tr>
				<th field='stockid' data-options="editor:
				{type:'combobox',options:{id:'product',url:'',method:'get',valueField:'name',textField:'name',
			onSelect:function(rows){
				var tr=$(this).closest('tr.datagrid-row');
				var idx=parseInt(tr.attr('datagrid-row-index'));
				var ed=$('#tt').datagrid('getEditor',{index:idx,field:'buyingrate'});
				$(ed.target).numberbox('setValue',rows.buyingrate);
				var ed1=$('#tt').datagrid('getEditor',{index:idx,field:'productid'});
				$(ed1.target).numberbox('setValue',rows.id);
				var wholecost=$('#tt').datagrid('getEditor',{index:idx,field:'wholecost'});
				$(wholecost.target).textbox('setValue',rows.buyingrate);
				var onecost=$('#tt').datagrid('getEditor',{index:idx,field:'onecost'});
				$(onecost.target).numberbox('setValue',rows.buyingrateitem);
				var price=$('#tt').datagrid('getEditor',{index:idx,field:'price'});
				$(price.target).combobox('setValue',1);
				var number=$('#tt').datagrid('getEditor',{index:idx,field:'number'});
				$(number.target).textbox('setValue',rows.wholeitem);
				
			

   


			}}}" width='400'>ItemName</th>
			<th field='price' data-options="editor:
				{type:'combobox',id:'pricelevel',options:{data:[{'id':1,'name':'Package'},{'id':2,'name':'Piece'}],valueField:'id',textField:'name',
				onChange:function(rowz){
					var tr=$(this).closest('tr.datagrid-row');
				    var idx=parseInt(tr.attr('datagrid-row-index'));
					var wholecost=$('#tt').datagrid('getEditor',{index:idx,field:'wholecost'});
					var onecost=$('#tt').datagrid('getEditor',{index:idx,field:'onecost'});
					var retailpx=$('#tt').datagrid('getEditor',{index:idx,field:'buyingrate'});
					var va=$(this).val();

					if(va==1){
						$(retailpx.target).numberbox('setValue',($(wholecost.target).numberbox('getValue')));

					}else if (va==2){
						$(retailpx.target).numberbox('setValue',($(onecost.target).numberbox('getValue')));	
					}
				
							
				}}
				}" width="100"> Price Level</th>
			<th field='buyingrate' editor="numberbox" width='100'>BuyingRate</th>
				<th field='quantity' editor="numberbox" width='100'>Quantity</th>
				
				<th field='totalamt' editor='numberbox' width='100'>TotalAmt</th>
				<th field='totalpaid' editor='numberbox'   width='100'>Totalpaid</th>
				<th field='totaldue' editor='numberbox'   width='100'>Totaldue</th>
				<th field='_token' hidden editor='numberbox' width='100'>Hidden</th>
				<th field='purcnumber' hidden editor='numberbox'   width='100'>Purchase</th>
				<th field="branch_id" hidden editor="numberbox"  >Branch</th>
				<th field="id" hidden > Id</th>
				<th field="productid" hidden editor="numberbox" >productID</th>
				<th field="paccount" hidden editor="numberbox"  >Paccount</th>
				<th field="date" hidden editor="textbox"   >Date</th>
				<th field="wholecost"  hidden editor="textbox" >WholeCost</th>
				<th field="onecost" hidden  editor="numberbox">OneCost</th>
				<th field="number"   editor="numberbox">Number</th>
				
			</tr>
		</thead>
	</table>
	





   
{{csrf_field()}}
<script>
fixComplete();
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
<script type="text/javascript" src="assets/customjs/stockpurchases.js"></script>

