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


<div class='easyui-dialog' style='width:50%;padding:5px;' closed='true' id='dlgstocks' toolbar='#stocks'><form id='frmstocks'>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>id</label></div><input type='text' class='form-control' name='id' 
 id='id' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Name</label></div><input required  style="width:100%;height:34px" class='easyui-textbox form-control' name='name' 
 id='name' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Description</label></div><input required style="width:100%;height:34px" class='easyui-textbox form-control' name='description' 
 id='description' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Category</label></div><input  style="width:100%;height:34px" class='form-control easyui-combobox'  name='category' 
 id='category' style="width:100%" data-options="url:'/categoriescombo',valueField:'id',textField:'name',method:'get'"/></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Group Item</label></div><input  style="width:100%;height:34px" class='form-control easyui-combobox'  name='groupitem' 
 id='groupitem' style="width:100%" data-options="url:'/comboitemgroups',valueField:'id',textField:'name',method:'get'"/></div>
</div><!--
<div class='col-lg-6'>
<div class='form-group'>
<div><label>subcategory</label></div><select class='form-control easyui-combobox'  style="width:100%;height:32px;" name='subcategory' data-options="url:'subcategoriescombo',valueField:'id',textField:'subname',method:'get'" 
 id='subcategory' ></select></div>
</div>-->

<!--<div class='col-lg-6'>
<div class="form-group">
    <div><label>Branch</label></div>
    <div><input class="easyui-combobox" id="branch" name="branch_id" style="width:100%;height:34px;"></div>

</div>

</div>-->

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Cost Price</label></div><input  required style="width:100%;height:34px" class='easyui-textbox form-control' name='buyingrate' 
 id='buyingrate' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>Buyingrate Per Item</label></div><input type='text' class='form-control' name='buyingrateitem' 
 id='buyingrateitem' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Selling Price</label></div><input required  style="width:100%;height:34px" class='easyui-textbox form-control' name='sellingrate' 
 id='sellingrate' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>WholeSale Price</label></div><input type='text' class='form-control' name='wholeprice' 
 id='wholeprice' /></div>
</div>-->
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Openingstock</label></div><input required  style="width:100%;height:34px" class='easyui-textbox form-control' name='openingstock' 
 id='openingstock' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Limit level</label></div><input required  style="width:100%;height:34px" class='easyui-numberbox form-control' name='limitlevel' 
 id='limitlevel' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Barcode</label></div><input readonly  style="width:100%;height:34px" class='easyui-textbox form-control' name='barcode' 
 id='barcode' /></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>Manufactureres Part No</label></div><input   style="width:100%;height:34px" class='easyui-textbox form-control' name='partno' 
 id='partno' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>WholeSale item</label></div><input type='text' class='form-control' name='wholeitemp' 
 id='wholeitem' /></div>
</div>-->

<div class='col-lg-6'>
<div class='form-group'>
<div><label>Unit Of Measure</label></div><input required style="width:100%;height:34px" class='form-control easyui-combobox'  name='unitofmeasure' 
 id='unitofmeasure' style="width:100%" data-options="url:'uomscombo',valueField:'id',textField:'name',method:'get'"/></div>
</div>
<div class='col-lg-6'>
<div class='form-group'>
<div><label>As of</label></div><input required  style="width:100%;height:34px" class='easyui-datebox form-control' name='asof' 
 id='asof' /></div>
</div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>isActive</label></div><input type='text' class='form-control' name='isActive' 
 id='isActive' /><input type="text" id="purchaseid" hidden  /></div>
</div>-->

<div style='padding:5px;' id='stocks' /><a href='javascript:void(0)' class='btn btn-primary'id='savestocks'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<table class='easyui-datagrid' striped='true'  rownumbers="true" title='stocks' iconCls='fa fa-table' singleSelect='true' url='viewstocksbranch' pagination='true' id='gridstocks' method='get' fitColumns='true' style='width:100%' toolbar='#stockstoolbar'>
<thead><tr>
<th field='id' width='35' hidden>id</th>
<th field='name' width='120'>Name</th>
<th field='description' width='180'>Description</th>
<th field='buyingrate' width='60'>Cost Price</th>
<th field='sellingrate' width='60'>Selling Price</th>

<th field='category' hidden width='100'>Category</th>
<!--<th field='subcategory' width='100'>Subcategory</th>-->
<th field='openingstock' width='60'>Opening Stock</th>
<th field='limitlevel' width='60'>Re-order Point</th>

<!--<th field='buyingrateitem' hidden width='100'>Item Buyingrate</th>-->

<!--<th field='wholeprice' width='100'>Wholesale Px</th>
<th field='wholeitemp' hidden width='100'> Item Wholesale Px</th>-->
<th field='Dozens' width='60'>Available</th>
<th field='nam' hidden width='60'>Unitofmeasure</th>
<th field='unitofmeasure' hidden width='100'>Unit of Measure</th>
<th field='branch_id' hidden width='100'>BranchID</th>
<th field='barcode'  width='70'>Barcode</th>
<th field='asof'  width='60'>As of</th>
<!--<th field='isActive' width='60'>isActive</th>-->
<!--<th field='branch_id' width='60'>isActive</th>-->
</tr></thead>
</table>

<div id='stockstoolbar'>
 <a href='javascript:void(0)' class='btn btn-primary' id='newstocks' iconCls='icon-add' ><i class="fa fa-plus-circle" aria-hidden="true"></i> New</a>
<a href='javascript:void(0)' class='btn btn-primary' id='editstocks' iconCls='icon-edit' ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
<a href='javascript:void(0)' class='btn btn-primary' id='deletestocks' iconCls='icon-remove' ><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</a>
<a href='javascript:void(0)' class='btn btn-primary' id='printbar' iconCls='icon-remove' ><i class="fa fa-print" aria-hidden="true"></i> Print</a>
&nbsp;<!--<input class="easyui-combobox" id='branch1' class='branch1' /> -->
<input class="easyui-textbox" id="search" style="width:20%;height:33px;" name="search" />
<form id="formupload" method="POST" enctype="multipart/form-data">
<!--<div id="form-attachments">-->
    <input id="file" style="display:inline;" type="file" name= data-options="prompt:'Choose a file...'" style="width:30%">
    <a href="javascript:void(0)" id="import" class="btn btn-primary"><i class="fa fa-file"></i> Import</a>

</form>
<!--</div>-->
<div class='easyui-dialog' style='width:20%;padding:5px;' closed='true' id='dlgcategories' toolbar='#categories'><form id='frmcategories'>

<div class='col-lg-12'>
<div class='form-group'>
<div><label>Quantity</label></div><input type='text' class='easyui-textbox form-control' style="width:100%" name='name' 
 id='sqty' /></div>
</div>
<div class='col-lg-12'>
<div class='form-group'>
<div><label>Date</label></div><input type='text' class='easyui-datebox form-control' style="width:100%" name='sdate' 
 id='sdate' /></div>
</div>
<div style='padding:5px;' id='categories' /><a href='javascript:void(0)' class='btn btn-primary'id='savecategories'>Save</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-primary'>Close</a>
</div></div>
<!--<div class='col-lg-6'>
<div class='form-group'>
<div><label>isActive</label></div><input type='text' class='form-control' name='isActive' 
 id='isActive' /></div>-->
</div>
</div>
</div>

{{csrf_field()}}
<script>
   
fixComplete();
 var url;
 $(document).ready(function(){
     $('#savecategories').click(function(){
        var row=$('#gridstocks').datagrid('getSelected');
        var r=$('#sqty').val();
            var sdate=$('#sdate').val();
$('#frmcategories').form('clear');
$.ajax({
url:'/printbarselect',
method:'POST',
data:{'id':row.id,'copies':r,'sdate':sdate,'_token':$('input[name=_token]').val()},
success:function(){
    $('#gridstocks').datagrid('reload');
}

}); 
$('#dlgcategories').dialog('close');
     });
     $('#printbar').click(function(){
        var row=$('#gridstocks').datagrid('getSelected');
        if(row==null){
            $.messager.alert('Barcode Print','Please select an item to Print ','warning');
        }else{
            $('#dlgcategories').dialog('open').dialog('setTitle','New categories');
     
	}
        

       /* $.messager.prompt(' Print Barcodes', 'Please Enter the No of Copies :', function(r){
	if (r){
        $.ajax({
url:'/printbarselect',
method:'POST',
data:{'id':row.id,'copies':r,'_token':$('input[name=_token]').val()}

});      
	}
        
});*/
        //}
     });
    $('#asof').datebox({
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
$('#sdate').datebox({
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
//Auto Generated code for New Entry Code
$('#branch1').combobox({
url:'combobranches',
method:'get',
valueField:'id',
textField:'branchname',
onLoadSuccess:function(){
var data=$(this).combobox('getData');
for (var i = 0;i<data.length;i++ ) {
					if(data[i].isDefault==1){
						$('#branch1').combobox('select', data[i].id);
					
					}
}

}

});

  
   $('#newstocks').click(function(){
    var url2 = "maxnumber";

$.getJSON(url2, function (data) {
	$.each(data, function (index, value) {
	  
	$('#purchaseid').val(value.id);
	});
});
       $('#dlgstocks').dialog('open').dialog('setTitle','New stocks');
       $('#branch').combobox({
url:'combobranches',
method:'get',
valueField:'id',
textField:'branchname',
onLoadSuccess:function(){
var data=$(this).combobox('getData');
for (var i = 0;i<data.length;i++ ) {
					if(data[i].isDefault==1){
						$('#branch').combobox('select', data[i].id);
					
					}
}

}

});
url='/savestocks';
$('#frmstocks').form('clear');
});

       //Auto Generated code for Edit Code
 $('#editstocks').click(function(){
       
 var row=$('#gridstocks').datagrid('getSelected');
       $('#dlgstocks').dialog('open').dialog('setTitle','Edit stocks');

       $('#frmstocks').form('load',row);
       url='/editstocks/'+row.id;
       
       
       });
       $('#gridstocks').datagrid({
        pageSize:50,
        pageList:[10,20,30,40,50],


    });
//Auto Generated Code for Saving
$('#savestocks').click(function(){ 
var id=$('#id').val();
var name=$('#name').val();
var description=$('#description').val();
var category=$('#category').val();
var subcategory=$('#subcategory').val();
var branch_id=$('#branch').val();
var openingstock=$('#openingstock').val();
var limitlevel=$('#limitlevel').val();
var buyingrate=$('#buyingrate').val();
var buyingrateitem=$('#buyingrateitem').val();
var sellingrate=$('#sellingrate').val();
var wholeprice=$('#wholeprice').val();
var unitofmeasure=$('#unitofmeasure').val();
var isActive=$('#isActive').val();
var wholeitem=$('#wholeitem').val();
var purchaseid=$('#purchaseid').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();
var barcode=$('#barcode').val();
var openingstok=$('#openingstok').val();
var asof=$('#asof').val();
var groupitem=$('#groupitem').val();
var partno=$('#partno').val();
$('#frmstocks').form('submit',{
				
				onSubmit:function(){
					if($(this).form('validate')==true){

$.ajax({
url:url,
method:'POST',
data:{'partno':partno,'groupitem':groupitem,'asof':asof,'openingstok':openingstok,'barcode':barcode,'id':id,'name':name,'buyingrateitem':buyingrateitem,'wholeitem':wholeitem,'wholeprice':wholeprice,'description':description,'category':category,'branch_id':branch_id,'subcategory':subcategory,'openingstock':openingstock,'limitlevel':limitlevel,'buyingrate':buyingrate,'sellingrate':sellingrate,'unitofmeasure':unitofmeasure,'isActive':isActive,'created_at':created_at,'updated_at':updated_at,'purchaseno':purchaseid,'_token':$('input[name=_token]').val()},
success:function(){
    $.getJSON('/checkPrint',function(data){
        if(data.isbarcode==0){
            $('#gridstocks').datagrid('reload');
        }else{
            $.messager.prompt('Print Barcodes', 'Please Enter Number of Copies:', function(r){
	if (r){
$.ajax({
url:'/printbars/'+r,
method:'POST',
data:{'id':r,'_token':$('input[name=_token]').val()}

});
	}
});
        $('#gridstocks').datagrid('reload');
        }
});
    

   
},
});
$('#dlgstocks').dialog('close');
                    }
                }
});
  

  

});
//Auto generated code for deleting
$('#deletestocks').click(function(){

    var a=$('#gridstocks').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridstocks').datagrid('getSelected');
                $.ajax({
                 url:'/destroystocks/'+row.id,
                 method:'POST',
                 data:{'id':row.id,'_token':$('input[name=_token]').val()},
                 success:function(data){
                    if(data.isdelete=='No'){
        $.messager.alert({title:'Warning',icon:'warning',msg:'Operation Failed,This product has data associated with it. '});
    }else{
                    $('#gridstocks').datagrid('reload');
    }
                 }
                });
              
            }

});
}
});
$('#buyingrate').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
$('#sellingrate').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            if(e.which >= 37 && e.which <= 40) return;
            $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
			
		}
	})
});
//Search Button
$('#search').click(function(){
    var branch=$('#branch1').val();
    var token=$('input[name=_token]').val();
    $('#gridstocks').datagrid({
method:'get',
queryParams:{branch_id:branch}

    });


});

//Importing stock items
$('#import').click(function(){
    //var reg = /(.*?)\.(jpg|bmp|jpeg|png)$/;
       
var file_data =$('#file').prop('files')[0]; //$('#file')[0].files;
var form_data = new FormData();
form_data.append('files', file_data);
form_data.append('_token', $('input[name=_token]').val());
$.messager.progress({title:'Importing',msg:"Importing ...."});
$.ajax({
         url:'importstock',
   type: "POST",
   data:  form_data,
   contentType: false,
         cache: false,
   processData:false, 
   success:function(data){

      $.messager.progress('close');
	  $.messager.show({title:'Info',msg:'Import Complete!!!'});
      $('#gridstocks').datagrid('reload');
   }         
    });
    

    
//}  
});

$('#search').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
            livesearch($(this).val());
            $('#search').textbox('textbox').focus();
            	
		}
	})
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
function livesearch(search){
    
    $('#gridstocks').datagrid({
method:'get',
queryParams:{search:search}

});

}
</script>