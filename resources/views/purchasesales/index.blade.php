
@include('layouts/header')
<center><h4> Sales </h4></center>
<div style='padding:5px;margin-left:13px;' id='purchaseheaders' /><a href='javascript:void(0)' class='btn btn-primary'id='savepurchaseheaders'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a></div>
<form style='width:100%;padding:5px;'  id='frmpurchaseheaders' >
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input  class='easyui-datebox form-control' name='transdates' 
 id='transdates' required  style="width:100%;height:34px" data-options="onSelect:validateDate" /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Mode of Payment</label></div><input  class='form-control easyui-combobox' style="width:100%;height:34px"  data-options="url:'combomodeofpayments',valueField:'id',textField:'name',method:'get',required:'true'" name='mode' 
 id='mode' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Customer</label></div><input required="true" class='form-control easyui-combobox' style="width:100%;height:34px"    name='customer_id' 
 id='customer_id' /></div>
</div>
<div class="col-lg-6">
	<div class="form-group">
		<div><label>Selling Branch</label></div>
		<div><input class="easyui-combobox form-control" id="branch" name="branch" style="width:100%;height:34px"/></div>
	</div>
</div>
<input type='hidden' class='form-control' name='id' 
 id='purchaseno'  readonly/>
 <input type="hidden" class='easyui-combobox'   data-options="url:'combochartofaccounts/1',valueField:'accountcode',textField:'accountname',method:'get',required:'true'" name='mode' 
	 id='raccount' />
</form>

<div style="margin-bottom:10px" id='toolbarsales'>
	<a href="#" class="easyui-linkbutton "  onclick="addrows()">
		<i class="ace-icon fa fa-plus"></i></a>
	<!--<a href="#" class="easyui-linkbutton " id='save' onclick="saverows()">
		<i class="ace-icon fa fa-floppy-o bigger-160"></i></a>
	<a href="#" class="easyui-linkbutton"  onclick="javascript:$('#tt').edatagrid('cancelRow')">
		<i class="ace-icon fa fa-times"></i>
	</a>-->
	<a href="#" class="easyui-linkbutton" onclick="destroyrow()">
			<i class="ace-icon fa fa-trash-o bigger-160"></i>
		</a>
</div>
</div></div>
	<!--<table id="tt" pagination="true" rownumbers="true" singleSelect="true" title="stockitem" iconCls="fa fa-table" fitColumns="true" style="width:100%"></table>-->
	<table class='easyui-datagrid' idField='id'  title='stockitem' rownumbers='true' iconCls='fa fa-table' singleSelect='true'  pagination='true' id='tt'  fitColumns='true' style='width:100%'  fitColumns='true' toolbar="#toolbarsales" >
		<thead>
			<tr>
				<th field='stockid' data-options="editor:
				{type:'combobox',options:{url:'',method:'get',valueField:'name',textField:'name',
			onSelect:function(rows){
				var tr=$(this).closest('tr.datagrid-row');
				var idx=parseInt(tr.attr('datagrid-row-index'));
				var ed=$('#tt').datagrid('getEditor',{index:idx,field:'sellingrate'})
				var ed1=$('#tt').datagrid('getEditor',{index:idx,field:'productid'});
				var ed2=$('#tt').datagrid('getEditor',{index:idx,field:'buyingrate'});
				var whole=$('#tt').datagrid('getEditor',{index:idx,field:'wholesale'});
				var retail=$('#tt').datagrid('getEditor',{index:idx,field:'retail'});
				var itemwhole=$('#tt').datagrid('getEditor',{index:idx,field:'wholeitem'});
				var wholeitemp=$('#tt').datagrid('getEditor',{index:idx,field:'wholeitemp'});
				var buyingrate=$('#tt').datagrid('getEditor',{index:idx,field:'buyingrateitem'});
				$(ed.target).numberbox('setValue',rows.sellingrate);
				$(ed1.target).numberbox('setValue',rows.id);
				$(ed2.target).numberbox('setValue',rows.buyingrate);
				$(whole.target).numberbox('setValue',rows.wholeprice);
				$(retail.target).numberbox('setValue',rows.sellingrate);
				$(itemwhole.target).numberbox('setValue',rows.wholeitem);
				$(wholeitemp.target).numberbox('setValue',rows.wholeitemp);
				$(buyingrate.target).numberbox('setValue',rows.buyingrateitem);
				var combopricelevel=$('#tt').datagrid('getEditor',{index:idx,field:'price'});
				$(combopricelevel.target).combobox('setValue',1);

			}}}" width='400'>ItemName</th>
			<th field='price' data-options="editor:
				{type:'combobox',id:'pricelevel',options:{data:[{'id':1,'name':'Retail'},{'id':2,'name':'WholeSale'},{'id':3,name:'Not Applicable'}],valueField:'id',textField:'name',
				onChange:function(rowz){
					var tr=$(this).closest('tr.datagrid-row');
				    var idx=parseInt(tr.attr('datagrid-row-index'));
				    var ed=$('#tt').datagrid('getEditor',{index:idx,field:'retail'});
					var retlpx=$('#tt').datagrid('getEditor',{index:idx,field:'wholesale'});
					var wholeitemp=$('#tt').datagrid('getEditor',{index:idx,field:'wholeitemp'});
					var retailpx=$('#tt').datagrid('getEditor',{index:idx,field:'sellingrate'});
					var va=$(this).val();

					if(va==1){
						$(retailpx.target).numberbox('setValue',($(ed.target).numberbox('getValue')));

					}else if (va==2){
						$(retailpx.target).numberbox('setValue',($(retlpx.target).numberbox('getValue')));	
					}
					else if(va==3){
						$(retailpx.target).numberbox('setValue',($(wholeitemp.target).numberbox('getValue')));
					}
							
				}}
				}" width="100"> Price Level</th>
				<th field='sellingrate' editor="numberbox"width='100'>UnitPrice</th>
				<th field='quantity' editor="numberbox" width='100'>Quantity</th>
				<th field='totalamt' editor='numberbox' width='100'>TotalAmt</th>
				<th field='totalpaid' editor='numberbox' width='100'>Totalpaid</th>
				<th field='totaldue' editor='numberbox' width='100'>Totaldue</th>
				<th field='_token' editor='numberbox'  hidden="true" width='100'>Hidden</th>
				<th field='purcnumber' editor='numberbox' hidden="true"  width='100'>Purchase</th>
				<th field="branch_id" editor="numberbox" hidden="true" width="100">branch </th>
				<th field="productid"  hidden editor="numberbox">ProductID</th>
				<th field="raccount" hidden="true" editor="numberbox">Recievingac</th>
				<th field="date" editor="textbox"  hidden="true"  >Date</th>
				<th field="buyingrate"  hidden="true" editor="numberbox">Buyingrate</th>
				<th field="wholesale"  hidden="true"  editor="numberbox">WholeSale</th>
				<th field="retail"  hidden="true"  editor="numberbox">Retail</th>
				<th field="wholeitem"  hidden  editor="numberbox">WholeSaleItem</th>
				<th field="wholeitemp" hidden  editor="numberbox">WholeSaleItem</th>
				<th field="buyingrateitem"  hidden editor="numberbox">BuyingRateItem</th>
				<th field="id" hidden >ID</th>

			</tr>
		</thead>
	</table>
	<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgcustomers' toolbar='#customers'><form id='frmcustomers'>
	
		<div class='col-lg-6'>
		<div class='form-group'>
		<div><label>Name</label></div><input type='text' class='form-control' name='name' 
		 id='name' /></div>
		</div>
		<div class='col-lg-6'>
		<div class='form-group'>
		<div><label>Phone</label></div><input type='text' class='form-control' name='phone' 
		 id='phone' /></div>
		</div>
		<div class='col-lg-6'>
		<div class='form-group'>
		<div><label>Address</label></div><input type='text' class='form-control' name='address' 
		 id='address' /></div>
		</div>
		<div style='padding:5px;' id='customers' /><a href='javascript:void(0)' class='btn btn-primary'id='savecustomers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
		</div></div>
{{csrf_field()}}
<script type="text/javascript" src="assets/customjs/salespurchase.js"></script>

