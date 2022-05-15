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

<table class='easyui-datagrid'   rowNumbers="true" title='Customer Ledger' striped="true" showFooter="true" iconCls='fa fa-table' singleSelect='true'  pagination='true' id='gridcustomers' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
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

 &nbsp;
<a href="javascript:void()" class="btn btn-primary" id="print"><i class="fa fa-print"></i> Preview</a>

 
 &nbsp;<!--<a href="javascript:void()" class="easyui-linkbutton" id="edit"><i class="fa fa-pencil-square-o"></i> Edit</a>-->
</div>




</table>

</div>



</div></div>
{{csrf_field()}}
<script>
$(document).ready(function(){
    $('#gridcustomers').datagrid({
method:'get',
url:"/dbcustomerledgerview/{{$id}}"

});
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

$('#print').click(function(){

         var customer="{{$id}}";
            window.open("/customerled/today/0/"+customer,'_newtab');
         

			 
});

});

</script>
