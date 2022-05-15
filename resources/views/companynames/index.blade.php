@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgcompanynames' toolbar='#companynames'><form id='frmcompanynames'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>companyname</label></div><input type='text' class='form-control' name='companyname' 
 id='companyname' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>boxnumber</label></div><input type='text' class='form-control' name='boxnumber' 
 id='boxnumber' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>telphone</label></div><input type='text' class='form-control' name='telphone' 
 id='telphone' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>location</label></div><input type='text' class='form-control' name='location' 
 id='location' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>created_at</label></div><input type='text' class='form-control' name='created_at' 
 id='created_at' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>updatated_at</label></div><input type='text' class='form-control' name='updatated_at' 
 id='updatated_at' /></div>
</div>
<div style='padding:5px;' id='companynames' /><a href='javascript:void(0)' class='btn btn-primary'id='savecompanynames'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='companynames' iconCls='fa fa-table' singleSelect='true' url='viewcompanynames' pagination='true' id='gridcompanynames' method='get' fitColumns='true' style='width:100%' toolbar='#companynamestoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='companyname' width='100'>companyname</th>
<th field='boxnumber' width='100'>boxnumber</th>
<th field='telphone' width='100'>telphone</th>
<th field='location' width='100'>location</th>
<th field='created_at' width='100'>created_at</th>
<th field='updatated_at' width='100'>updatated_at</th>
</tr></thead>
</table>
<div id='companynamestoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newcompanynames' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='editcompanynames' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deletecompanynames' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newcompanynames').click(function(){
       $('#dlgcompanynames').dialog('open').dialog('setTitle','New companynames');
url='/savecompanynames';
$('#frmcompanynames').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editcompanynames').click(function(){
       
 var row=$('#gridcompanynames').datagrid('getSelected');
       $('#dlgcompanynames').dialog('open').dialog('setTitle','Edit companynames');

       $('#frmcompanynames').form('load',row);
       url='/editcompanynames/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savecompanynames').click(function(){ 
var id=$('#id').val();
var companyname=$('#companyname').val();
var boxnumber=$('#boxnumber').val();
var telphone=$('#telphone').val();
var location=$('#location').val();
var created_at=$('#created_at').val();
var updatated_at=$('#updatated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'companyname':companyname,'boxnumber':boxnumber,'telphone':telphone,'location':location,'created_at':created_at,'updatated_at':updatated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgcompanynames').dialog('close');
  
$('#gridcompanynames').datagrid('reload');
});
//Auto generated code for deleting
$('#deletecompanynames').click(function(){

    var a=$('#gridcompanynames').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridcompanynames').datagrid('getSelected');
                $.ajax({
                 url:'/destroycompanynames/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridcompanynames').datagrid('reload');
            }

});
}
});

});
</script>