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
<div><label>Payment No</label></div><input required  style="width:100%;height:34px;" class='easyui-textbox form-control' name='paymentdetail' 
 id='paymentdetail' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Bank Account</label></div><input required  style="width:100%;height:34px;" class='easyui-combobox form-control' name='bankid' 
 id='bankid' /></div>
</div>
<input type="hidden" id="headerno" name="headerno"/>

<div style='padding:5px;' id='bankings' /><a href='javascript:void(0)' class='btn btn-primary'id='savebankings'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' striped='true' rowNumbers="true" title='Deposits' iconCls='fa fa-table' singleSelect='true' url='viewbankings' pagination='true' id='gridbankings' method='get' fitColumns='true' style='width:100%' toolbar='#bankingstoolbar'>
<thead><tr>
<th field='id' hidden width='100'>id</th>
<th field='date' width='80'>Date</th>
<th field='paymentdetail' width='80'>Payment No</th>
<th field='bankid'  hidden width='100'>bankid</th>
<th field='accountname'   width='100'>Bank </th>
<th field='amount' width='80'>Amount</th>

</tr></thead>
</table>
<div id='bankingstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newbankings' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editbankings' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletebankings' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a> 
<label>Date</label>
<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>
&nbsp;<input   data-options="url:'/bankaccounts',valueField:'accountcode',textField:'accountname',method:'get'" style="width:18%;height:34px;" class='easyui-combobox form-control' name='bankid' 
 id='bankid2' />&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="excel" name="excel"><i class="fa fa-file"></i> Export To Excel</a>
 &nbsp;
 <!--<a href='javascript:void(0)' class='btn btn-primary' id='statement' iconCls='icon-remove' ><i class="fa fa-bank" aria-hidden="true"></i> Statement</a> -->
 </div>

{{csrf_field()}}
<script>
fixComplete();
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newbankings').click(function(){
       $('#dlgbankings').dialog('open').dialog('setTitle','New bankings');
url='/savebankings';
$('#frmbankings').form('clear');
});

$('#bankid').combobox({
    url:'/bankaccounts',
    valueField:'accountcode',
    textField:'accountname',
    method:'get',
});
       //Auto Generated code for Edit Code
 $('#editbankings').click(function(){
       
 var row=$('#gridbankings').datagrid('getSelected');
       $('#dlgbankings').dialog('open').dialog('setTitle','Edit bankings');

       $('#frmbankings').form('load',row);
       url='/editbankings/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savebankings').click(function(){ 
var id=$('#id').val();
var date=$('#date').val();
var amount=$('#amount').val();
var paymentdetail=$('#paymentdetail').val();
var bankid=$('#bankid').val();
var branchno=$('#branchno').val();
var headerno=$('#headerno').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$('#frmbankings').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){
                        
$.ajax({
url:url,
method:'POST',
data:{'id':id,'headerno':headerno,'date':date,'amount':amount,'paymentdetail':paymentdetail,'bankid':bankid,'branchno':branchno,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(){
    $('#gridbankings').datagrid('reload');
}
});
  
$('#dlgbankings').dialog('close');
                    }
                }
});
  

});
//Auto generated code for deleting
$('#deletebankings').click(function(){

    var a=$('#gridbankings').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridbankings').datagrid('getSelected');
                $.ajax({
                 url:'/destroybankings/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridbankings').datagrid('reload');
                 }
                });
                
            }

});
}
});
$('#amount').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});

$('#date').datebox({
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
    var branchid=$('#bankid2').val();
    
$('#gridbankings').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,branchid:branchid}

});

});

$('#excel').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    var branchid=$('#bankid2').val();
    if(date1=='' && date2=='' && branchid==''){
        window.location="bankexcel/xlsx/today/today/bank";
    }
    else if(date1!='' && date2=='' && branchid==''){
        window.location="bankexcel/xlsx/"+date1+"/today/bank";  
    }
    else if(date1!='' && date2!='' && branchid==''){
        window.location="bankexcel/xlsx/"+date1+"/"+date2+"/bank";  
    }


    else if(date1=='' && date2=='' && branchid!=''){
        window.location="bankexcel/xlsx/today/today/"+branchid;
    }
    else if(date1!='' && date2=='' && branchid!=''){
        window.location="bankexcel/xlsx/"+date1+"/today/"+branchid;  
    }
    else if(date1!='' && date2!='' && branchid!=''){
        window.location="bankexcel/xlsx/"+date1+"/"+date2+"/"+branchid;  
    }


});

});
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