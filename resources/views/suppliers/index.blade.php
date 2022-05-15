@include('layouts/header')
<style>
.datagrid-row-alt{
    background-color: #d9f2e7;

}
.datagrid-row-selected {
  background: #009900;
  color: white;
}
</style>
<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgsuppliers' toolbar='#suppliers'><form id='frmsuppliers'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>companyName</label></div><input type='text' class='form-control' name='companyName' 
 id='companyName' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>contactPerson</label></div><input type='text' class='form-control' name='contactPerson' 
 id='contactPerson' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>tel</label></div><input type='text' class='form-control' name='tel' 
 id='tel' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>email</label></div><input type='text' class='form-control' name='email' 
 id='email' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>address1</label></div><input type='text' class='form-control' name='address1' 
 id='address1' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>address2</label></div><input type='text' class='form-control' name='address2' 
 id='address2' /></div>
</div>
<div class='col-lg-6'>
    <div class='form-group'>
    <div><label>isDefault</label></div><select class='form-control' id='isDefault'name='isDefault' > 
        <option value=1>Yes</option>
        <option value="0" selected>No</option> 
    </select></div>
    </div>

<div style='padding:5px;' id='suppliers' /><a href='javascript:void(0)' class='btn btn-primary'id='savesuppliers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' title='suppliers' iconCls='fa fa-table' singleSelect='true' url='viewsuppliers' pagination='true' id='gridsuppliers' method='get' fitColumns='true'  rownumbers='true' style='width:100%' toolbar='#supplierstoolbar'>
<thead><tr>
<th field='id' width='50' hidden="true">SupplierId</th>
<th field='companyName' width='90'>CompanyName</th>
<th field='contactPerson' width='50'>ContactPerson</th>
<th field='tel' width='50'>Tel</th>
<th field='email' width='90'>Email</th>
<th field='address1' width='90'>Address1</th>
<th field='address2' width='40'>Address2</th>
<th field='isDefault' width='40'>isDefault</th>

</tr></thead>
</table>
<div id='supplierstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newsuppliers' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editsuppliers' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletesuppliers' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a> </div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
    
   $('#newsuppliers').click(function(){
       $('#dlgsuppliers').dialog('open').dialog('setTitle','New Suppliers');
     
url='/savesuppliers';
$('#frmsuppliers').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editsuppliers').click(function(){
       
 var row=$('#gridsuppliers').datagrid('getSelected');
       $('#dlgsuppliers').dialog('open');
       $('#frmsuppliers').form('load',row);
       url='/editsuppliers/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savesuppliers').click(function(){ 
var id=$('#id').val();
var companyName=$('#companyName').val();
var contactPerson=$('#contactPerson').val();
var tel=$('#tel').val();
var email=$('#email').val();
var isDefault=$('#isDefault').val();
var address1=$('#address1').val();
var address2=$('#address2').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'companyName':companyName,'contactPerson':contactPerson,'tel':tel,'email':email,'address1':address1,'address2':address2,'created_at':created_at,'updated_at':updated_at,'isDefault':isDefault,'_token':$('input[name=_token]').val()},
success:function(){
    $('#gridsuppliers').datagrid('reload');
}
});

  
$('#dlgsuppliers').dialog('close');
});
//Auto generated code for deleting
$('#deletesuppliers').click(function(){

    var a=$('#gridsuppliers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridsuppliers').datagrid('getSelected');
                $.ajax({
                 url:'/destroysuppliers/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridsuppliers').datagrid('reload');
                 }
                });
               
            }

});
}
});

});
</script>