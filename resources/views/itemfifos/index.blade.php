@include('layouts/header')
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgitemfifos' toolbar='#itemfifos'><form id='frmitemfifos'>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>stockin</label></div><input type='text' class='form-control' name='stockin' 
 id='stockin' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>stockout</label></div><input type='text' class='form-control' name='stockout' 
 id='stockout' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>stockid</label></div><input type='text' class='form-control' name='stockid' 
 id='stockid' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>buyingpx</label></div><input type='text' class='form-control' name='buyingpx' 
 id='buyingpx' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>created_at</label></div><input type='text' class='form-control' name='created_at' 
 id='created_at' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>updated_at</label></div><input type='text' class='form-control' name='updated_at' 
 id='updated_at' /></div>
</div>
<div style='padding:5px;' id='itemfifos' /><a href='javascript:void(0)' class='btn btn-primary'id='saveitemfifos'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='itemfifos' iconCls='fa fa-table' singleSelect='true' url='viewitemfifos' pagination='true' id='griditemfifos' method='get' fitColumns='true' style='width:100%' toolbar='#itemfifostoolbar'>
<thead><tr>
<th field='id' width='100'>id</th>
<th field='stockin' width='100'>stockin</th>
<th field='stockout' width='100'>stockout</th>
<th field='stockid' width='100'>stockid</th>
<th field='buyingpx' width='100'>buyingpx</th>
<th field='created_at' width='100'>created_at</th>
<th field='updated_at' width='100'>updated_at</th>
</tr></thead>
</table>
<div id='itemfifostoolbar'>
 <a href='javascript:void(0)' class='easyui-linkbutton' id='newitemfifos' iconCls='icon-add' >New</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='edititemfifos' iconCls='icon-edit' > Edit</a>
<a href='javascript:void(0)' class='easyui-linkbutton' id='deleteitemfifos' iconCls='icon-remove' > Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newitemfifos').click(function(){
       $('#dlgitemfifos').dialog('open').dialog('setTitle','New itemfifos');
url='/saveitemfifos';
$('#frmitemfifos').form('clear');
});

       //Auto Generated code for Edit Code
 $('#edititemfifos').click(function(){
       
 var row=$('#griditemfifos').datagrid('getSelected');
       $('#dlgitemfifos').dialog('open').dialog('setTitle','Edit itemfifos');

       $('#frmitemfifos').form('load',row);
       url='/edititemfifos/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#saveitemfifos').click(function(){ 
var id=$('#id').val();
var stockin=$('#stockin').val();
var stockout=$('#stockout').val();
var stockid=$('#stockid').val();
var buyingpx=$('#buyingpx').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'stockin':stockin,'stockout':stockout,'stockid':stockid,'buyingpx':buyingpx,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgitemfifos').dialog('close');
  
$('#griditemfifos').datagrid('reload');
});
//Auto generated code for deleting
$('#deleteitemfifos').click(function(){

    var a=$('#griditemfifos').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#griditemfifos').datagrid('getSelected');
                $.ajax({
                 url:'/destroyitemfifos/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#griditemfifos').datagrid('reload');
            }

});
}
});

});
</script>