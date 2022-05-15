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

<table class='easyui-datagrid' rowNumbers="true" title='Sales Report' striped="true" showFooter="true" iconCls='fa fa-table' singleSelect='true'  pagination='true' id='gridcustomers' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<thead><tr>

<th field='transdate' width='80'>Date</th>
<th field='purchaseheaderid'  width='50'>Trans No</th>
<th field='customer' width='100'>Customer</th>
<th field='itemcode' width='100'>Itemname</th>
<th field='custoid' hidden width='100'>Customer Id</th>
<th field='quantity' width='100'>Qty</th>
<th field='totalamt' width='100'>TotalAmt</th>
<th field='totalpaid' hidden width='100'>Payment</th>
<th field='totaldue' hidden width='100'>Bal</th>
<th field='transfercode' hidden  width='100'>headerid</th>
</tr></thead>
</table>
<div id='customerstoolbar'>
<a href="javascript:void()" class="btn btn-primary" id="del"><i class="fa fa-trash"></i> Del</a>&nbsp;
 <label>Date</label>

<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>
<!--<label>Product</label>
<input class="easyui-combobox" id="product" name="product" data-options="method:'get',url:'',valueField:'id',textField:'name'"/>
<label>Branch</label>
<input class="easyui-combobox" id="branche" name="branch" />-->&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="excel" name="excel"><i class="fa fa-file"></i> Export To Excel</a>
 
 &nbsp;<!--<a href="javascript:void()" class="easyui-linkbutton" id="edit"><i class="fa fa-pencil-square-o"></i> Edit</a>-->
 <a href="javascript:void()" class="btn btn-primary" id="editsales"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
</div>
<!--Dialog for Editing-->


{{csrf_field()}}
<script type="text/javascript" src="assets/customjs/salesreport.js"></script>