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
<div class='easyui-dialog' style='width:20%;padding:5px;' closed='true' id='dlgitemgroups' toolbar='#itemgroups'><form id='frmitemgroups'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Group Name</label></div><input type='text' style="width:225%" class='easyui-textbox form-control' name='name' 
 id='name' /></div>
</div>

<div style='padding:5px;' id='itemgroups' /><a href='javascript:void(0)' class='btn btn-primary'id='saveitemgroups'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' rowNumbers="true" striped='true' title='Group Items' iconCls='fa fa-table' singleSelect='true' url='viewitemgroups' pagination='true' id='griditemgroups' method='get' fitColumns='true' style='width:100%' toolbar='#itemgroupstoolbar'>
<thead><tr>

<th field='name' width='100'>Group Name</th>
<th field='id'  width='100'>Group No</th>

</tr></thead>
</table>
<div id='itemgroupstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newitemgroups' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='edititemgroups' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i>  Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deleteitemgroups' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newitemgroups').click(function(){
       $('#dlgitemgroups').dialog('open').dialog('setTitle','New itemgroups');
url='/saveitemgroups';
$('#frmitemgroups').form('clear');
});

       //Auto Generated code for Edit Code
 $('#edititemgroups').click(function(){
       
 var row=$('#griditemgroups').datagrid('getSelected');
       $('#dlgitemgroups').dialog('open').dialog('setTitle','Edit itemgroups');

       $('#frmitemgroups').form('load',row);
       url='/edititemgroups/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#saveitemgroups').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var updated_at=$('#updated_at').val();
var created_at=$('#created_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'name':name,'updated_at':updated_at,'created_at':created_at,'_token':$('input[name=_token]').val()},
success:function(data){
    if(data.isDel=='No'){
        $.messager.alert({title:'Warning',icon:'warning',msg:'You cannot Edit this item Group  please'});
    }else{
    $('#griditemgroups').datagrid('reload');
    }
}
});
  
$('#dlgitemgroups').dialog('close');
  

});
//Auto generated code for deleting
$('#deleteitemgroups').click(function(){

    var a=$('#griditemgroups').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#griditemgroups').datagrid('getSelected');
                $.ajax({
                 url:'/destroyitemgroups/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(data){
                     if(data.isDel=='No'){
                        $.messager.alert({title:'Warning',icon:'warning',msg:'You cannot delete this Item Group please'});
                     }else{
                    $('#griditemgroups').datagrid('reload');
                     }
                 }
                });
                
            }

});
}
});

});
</script>