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
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgchartofaccounts' toolbar='#chartofaccounts'><form id='frmchartofaccounts'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Account Code</label></div><input style="width:100%;height:34px;" class='easyui-textbox form-control' name='accountcode' 
 id='accountcode' readonly /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Account Name</label></div><input style="width:100%;height:34px;" class='easyui-textbox form-control' name='accountname' 
 id='accountname' readonly /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Accounttype</label></div><input style="width:100%" type='text' data-options="url:'comboaccounttypes',method:'get',valueField:'id',textField:'accounttype'" class='easyui-combobox form-control' name='accounttype' 
 id='accounttype' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>isActive</label></div><input type='text' class='form-control' name='isActive' 
 id='isActive' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>isDefault</label></div><select  style="width:100%;height:34px;" class='easyui-combobox form-control' name='isDefault' 
 id='isDefault' >
 <option value=1>Yes</option>
 <option value=0>No</option>
 </select></div>
</div>

<div style='padding:5px;' id='chartofaccounts' /><a href='javascript:void(0)' class='btn btn-primary'id='savechartofaccounts'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' striped='true' title='Account Inventory' iconCls='fa fa-table' singleSelect='true' url='combochartofaccounts/1' pagination='true' id='gridchartofaccounts' method='get' fitColumns='true' style='width:100%'rowNumbers='true' toolbar='#chartofaccountstoolbar'>
<thead><tr>
<th field='id'  hidden="true" width='100'>id</th>
<th field='accountcode' width='100'>Accountcode</th>
<th field='accountname' width='100'>Account Name</th>
<th field='accounttype' hidden  width='100'>Accounttype</th>
<th field='isDefault' width='100'>isDefault</th>

</tr></thead>
</table>
<div id='chartofaccountstoolbar'>
 <!--<a href='javascript:void(0)' class='easyui-linkbutton' id='newchartofaccounts' iconCls='icon-add' >New</a>-->
<a href='javascript:void(0)' class='btn btn-primary' id='editchartofaccounts'  ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<!--<a href='javascript:void(0)' class='easyui-linkbutton' id='deletechartofaccounts' iconCls='icon-remove' > Delete</a>--> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newchartofaccounts').click(function(){
       $('#dlgchartofaccounts').dialog('open').dialog('setTitle','New chartofaccounts');
url='/savechartofaccounts';
$('#frmchartofaccounts').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editchartofaccounts').click(function(){
       
 var row=$('#gridchartofaccounts').datagrid('getSelected');
       $('#dlgchartofaccounts').dialog('open').dialog('setTitle','Edit Accounts Inventory');

       $('#frmchartofaccounts').form('load',row);
       url='/editinventoryaccounts/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savechartofaccounts').click(function(){ 
var id=$('#id').val();
var accountcode=$('#accountcode').val();
var accountname=$('#accountname').val();
var accounttype=$('#accounttype').val();
var mainaccount=$('#mainaccount').val();
var openingbal=$('#openingbal').val();
var Inventory=$('Inventory').val();
var asof=$('#asof').val();
var isActive=$('#isActive').val();
var isDefault=$('#isDefault').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'accountcode':accountcode,'accountname':accountname,'accounttype':accounttype,'mainaccount':mainaccount,'openingbal':openingbal,'asof':asof,'isActive':isActive,'isDefault':isDefault,'Inventory':'Inventory','created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(){
    $('#gridchartofaccounts').datagrid('reload');
}
});
  
$('#dlgchartofaccounts').dialog('close');
  
//$('#gridchartofaccounts').datagrid('reload');
});
//Auto generated code for deleting
$('#deletechartofaccounts').click(function(){

    var a=$('#gridchartofaccounts').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridchartofaccounts').datagrid('getSelected');
                $.ajax({
                 url:'/destroychartofaccounts/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridchartofaccounts').datagrid('reload');
                 }
                });
                
            }

});
}
});

});
</script>