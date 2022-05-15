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

<table class='easyui-datagrid' rowNumbers="true" url='/viewnotifications' method='get' title='Credit Sales' striped="true" showFooter="true" iconCls='fa fa-table' singleSelect='true'  pagination='true' id='gridcustomers' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<thead><tr>

<th field='transdat' width='80'>Date</th>
<th field='purchaseheaderid'  width='50'>Trans No</th>
<th field='customer' width='100'>Customer</th>
<th field='itemcode' hidden  width='100'>Itemname</th>
<th field='custoid' hidden  width='100'>Customer Id</th>
<th field='quantity' hidden width='100'>Qty</th>
<th field='totalamt' width='100'>TotalAmt</th>
<th field='bal' width='100'>Bal</th>
<th field='totalpaid' hidden width='100'>Payment</th>
<th field='totaldue' hidden width='100'>Bal</th>
</tr></thead>
</table>
