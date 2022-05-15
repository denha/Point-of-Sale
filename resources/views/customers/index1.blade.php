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
<div class='easyui-dialog'  style='width:50%;padding:5px;' closed='true' id='dlgcustomers' toolbar='#customers'><form id='frmcustomers'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input style="height:34px;width:100%;" required type='text' class='easyui-textbox form-control' name='name' 
 id='name' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Tel 1</label></div><input style="height:34px;width:100%;" type='text' mask="(999) 999-999999" class='easyui-maskedbox form-control' name='phone' 
 id='phone' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Address</label></div><input  style="height:34px;width:100%;" type='text' class=' easyui-textbox  form-control' name='address' 
 id='address' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Tel 2</label></div><input style="height:34px;width:100%;" type='text' class='easyui-textbox  form-control' name='tel' 
 id='tel' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Email</label></div><input style="height:34px;width:100%;" type='text' class='easyui-textbox form-control' name='email' 
 id='email' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>isActive</label></div><input type='text' class='form-control' name='isActive' 
 id='isActive' /></div>
</div>-->

<div style='padding:5px;' id='customers' /><a href='javascript:void(0)' class='btn btn-primary'id='savecustomers'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid'  striped="true" showFooter="true" title='Customers' iconCls='fa fa-table' singleSelect='true' url='viewcustomers' rownumbers="true" pagination='true' id='gridcustomers' method='get' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<thead><tr>
<th field='id' hidden="true" width='100'>CustomerId</th>
<th field='name' width='100'>Name</th>
<th field='phone' width='100'>Tel 1</th>
<th field='address'  width='100'>Address</th>
<th field='tel' width='100'>Tel 2</th>
<th field='email' width='100'>Email</th>
<th field='isActive'  hidden width='100'>isActive</th>

</tr></thead>
</table>
<div id='customerstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newcustomers' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editcustomers' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletecustomers' iconCls='icon-remove'><i class="fa fa-minus-circle" aria-hidden="true"></i>  Delete</a> 
<a href='javascript:void(0)' class='btn btn-primary' style="float:right;" id='clickmessages' iconCls='icon-remove'><i class="fa fa-envelope" aria-hidden="true"></i>  Messages</a></div>
 </div>
<div class='easyui-dialog'  style='width:25%;padding:5px;' closed='true' id='dlgmessages' toolbar='#messages'>
<form id='frmmessages'>

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Text Message</label></div><input style="width:300px;height:100px" required type='text'data-options="multiline:true" class='easyui-textbox form-control' name='textmsg' 
 id='textmsg' /><br><br>
 <div style="width:200px;">
 <a href='javascript:void(0)' class='btn btn-primary'id='send'>Send</a> &nbsp;&nbsp; Word Count : <b id="count">0</b>
 </div>
 </div>
 </form>
</div>
</div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
//Auto Generated code for New Entry Code
  
   $('#newcustomers').click(function(){
       $('#dlgcustomers').dialog('open').dialog('setTitle','New customers');
url='/savecustomers';
$('#frmcustomers').form('clear');
});
$('#clickmessages').click(function(){
    $('#dlgmessages').dialog('open').dialog('setTitle','Send Messages');
    $('#frmmessages').form('clear');
});
$('#send').click(function(){
var text=$('#textmsg').val();
if(text!=''){
$.ajax({
url:'/sendmsg',
method:'POST',
data:{'text':text,'_token':$('input[name=_token]').val()},
success:function(){
    $.messager.alert('Notification','Messages sent successfully !','info');

}
});
$('#dlgmessages').dialog('close');
}else{
    $.messager.alert('Notification','Message Cannot be Empty !','info');
}

});
// Text Message count
$('#textmsg').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            var length = this.value.length;
            $('#count').html(length);
			
		}
	})
});
       //Auto Generated code for Edit Code
 $('#editcustomers').click(function(){
       
 var row=$('#gridcustomers').datagrid('getSelected');
       $('#dlgcustomers').dialog('open').dialog('setTitle','Edit customers');

       $('#frmcustomers').form('load',row);
       url='/editcustomers/'+row.id;
       
       
       });
//Auto Generated Code for Saving
$('#savecustomers').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var phone=$('#phone').val();
var address=$('#address').val();
var tel=$('#tel').val();
var email=$('#email').val();
var isActive=$('#isActive').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
$.ajax({
url:url,
method:'POST',
data:{'id':id,'name':name,'phone':phone,'address':address,'tel':tel,'email':email,'isActive':isActive,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(){
    $('#gridcustomers').datagrid('reload');
}
});
  
$('#dlgcustomers').dialog('close');
  

});
//Auto generated code for deleting
$('#deletecustomers').click(function(){

    var a=$('#gridcustomers').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridcustomers').datagrid('getSelected');
                $.ajax({
                 url:'/destroycustomers/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(){
                    $('#gridcustomers').datagrid('reload');
                 }
                });
               
            }

});
}
});

});
</script>