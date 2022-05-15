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

<table class='easyui-datagrid' rowNumbers="true" title='Customer Ledger' striped="true" showFooter="true" iconCls='fa fa-table' singleSelect='true'  pagination='true' id='gridcustomers' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<thead><tr>

<th field='transdate' width='80'>Date</th>
<th field='purchaseheaderid'  width='50'>Trans No</th>
<th field='customer' hidden width='100'>Customer</th>
<th field='stocknames'   width='100'>Item Name</th>
<th field='custoid' hidden  width='100'>Customer Id</th>
<th field='quantity'  width='100'>Qty</th>
<th field='totalamt' width='100'>TotalAmt</th>
<th field='totalpaid'  width='100'>Payment</th>
<th field='bal' width='100'>Bal</th>

<th field='totaldue' hidden width='100'>Bal</th>
</tr></thead>
</table>
<div id='customerstoolbar'>
<!--<a href="javascript:void()" class="btn btn-primary" id="del"><i class="fa fa-balance-scale"></i> Pay</a>&nbsp;-->
 <label>Date</label>

<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>
<!--<label>Product</label>
<input class="easyui-combobox" id="product" name="product" data-options="method:'get',url:'',valueField:'id',textField:'name'"/>
<label>Branch</label>

<input class="easyui-combobox" id="branche" name="branch" />-->&nbsp;
<input style="height:34px;width:20%" required class='easyui-combobox form-control' data-options="url:'customerscombo',method:'get',valueField:'id',textField:'name'" name='name' 
 id='name' />
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;
<a href="javascript:void()" class="btn btn-primary" id="print"><i class="fa fa-print"></i> Preview</a>
 <!--<a href="javascript:void(0)" class="btn btn-primary"
 id="excel" name="excel"><i class="fa fa-file"></i> Export To Excel</a>-->
 
 &nbsp;<!--<a href="javascript:void()" class="easyui-linkbutton" id="edit"><i class="fa fa-pencil-square-o"></i> Edit</a>-->
</div>
<!--Dialog for Editing-->

<div class='easyui-dialog'  style='width:50%;padding:5px;' closed='true' id='dlgbankings' toolbar='#bankings'><form id='frmbankings'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Date</label></div><input required style="width:100%;height:34px;"  class='easyui-datebox form-control' name='date' 
 id='date' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Amount</label></div><input required  style="width:100%;height:34px;" class='easyui-textbox form-control' name='amount' 
 id='amount' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Trans No</label></div><input required  readonly style="width:100%;height:34px;" class='easyui-textbox form-control' name='purchaseheaderid' 
 id='purchaseheaderid' /></div>
</div>
<input type="hidden" id="custoid" name="custoid"/>
<br>
<table  class="easyui-datagrid">
<th>Item</th> <th>Quantity</th>

</table>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Bank Account</label></div><input required  style="width:100%;height:34px;" class='easyui-combobox form-control' name='bankid' 
 id='bankid' /></div>-->
</div>


<div style='padding:5px;' id='bankings' /><a href='javascript:void(0)' class='btn btn-primary'id='savebankings'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
{{csrf_field()}}
<script>
$(document).ready(function(){
  $('#date1').datebox({
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
    $('#date2').datebox({
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
    $('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    var name=$('#name').val();
    
$('#gridcustomers').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,name:name}

});

});
$('#print').click(function(){
    var date1=$('#date1').val();
         var date2=$('#date2').val();
         var customer=$('#name').val();
         if(date1=='' && date2=='' && customer !=''){
            window.open("/customerled/today/0/"+customer,'_newtab');
         }else if (date1!=''&& date2=='' && customer !=''){
            window.open('/customerled/'+date1+'/0/'+customer,'_newtab');
         } 
         else if(date1!='' && date2!='' && customer !=''){
            window.open('/customerled/'+date1+'/'+date2+'/'+customer,'_newtab');
         }

			 
});

});

</script>
<script type="text/javascript" src="assets/customjs/customerledger.js"></script>