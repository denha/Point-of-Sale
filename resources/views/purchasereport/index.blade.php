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
<table class='easyui-datagrid'  striped='true' rowNumbers="true" title='Purchase Report' iconCls='fa fa-table' showFooter="true" singleSelect='true' url='' pagination='true' id='gridcustomers'  fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<thead><tr>
<th field='transdate' width='100'>Date</th>
<th field='purchaseheaderid' width='80'>Trans #</th>
<th field='companyName' width='100'>Supplier</th>
<th field='itemcode' width='100'>Itemname</th>
<th field='quantity' width='80'>Qty</th>
<th field='totalamt'  width='80'>TotalAmt</th>
<th field='totalpaid' hidden width='100'>Payment</th>
<th field='totaldue' hidden width='100'>Bal</th>
</tr></thead>
</table>

<div id='customerstoolbar'>
<a href="javascript:void()" class="btn btn-primary" id="del"><i class="fa fa-trash"></i> Del</a>
 <label>Date</label>
<input  class='easyui-datebox'  required  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" name="date2"  required/>
<!--<label>Product</label>
<input class="easyui-combobox" id="product" name="product" data-options="url:'',valueField:'id',textField:'name',method:'get' "/>
<label>Branch</label>
<input class="easyui-combobox" id="branche" name="branche" data-options="url:'combobranches',valueField:'id',textField:'branchname',method:'get' "/>-->&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>

 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="excel" name="excel"><i class="fa fa-file"></i> Export To Excel</a>&nbsp;
 <a href="javascript:void()" class="btn btn-primary" id="editsales"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
 <!--<a href="javascript:void()" class="easyui-linkbutton" id="edit"><i class="fa fa-pencil-square-o"></i> Edit</a>-->

</div>

{{csrf_field()}}
<!--Dialog for Editing-

<div class="easyui-dialog" closed='true' id='dlgtrans' style="width:50%;">
    <div style='padding:5px;' id='purchaseheaders' /></div>
    <form style='width:100%;padding:5px;'  id='edittrans' toolbar='#purchaseheaders'>
  
    <div class='col-lg-6'>
    <div class='form-group'>
    <div><label>Date</label></div><input  class='easyui-datebox form-control' style="width:100%;height:34px;" name='transdate' 
     id='transdate' required  /></div>
    </div>
    <div class='col-lg-6'>
        <div class='form-group'>
        <div><label>Transcation No</label></div><input  class='form-control' readonly  name='purchaseheaderid' 
         id='purchaseheaderid' /></div>
        </div>
    <div class='col-lg-6'>
    <div class='form-group'>
    <div><label>Supplier Name</label></div><input  class='form-control'   name='companyName' 
     id='companyName' /></div>
    </div>
 
 <input  type="hidden"   name='accountcode' 
     id='accountcode'  />
     
    
        
            <div class='col-lg-6'>
                    <div class='form-group'>
                    <div><label>Destination Account</label></div>
                    <input  style="height:34px;width:100%"class="easyui-combobox" id="accountname" name="accountname" data-options="url:'combochartofaccounts/1',valueField:'accountcode',textField:'accountname',method:'get' "/>
                </div>
                    </div>
                   
                       
    </form>
    <div id='toolbaredit'>

        </div>
        <table id="tt" class="easyui-datagrid" toolbar="#toolbaredit"  rownumbers='true' iconCls='fa fa-table' singleSelect='true'  pagination='true' id='tt'  fitColumns='true' style='width:100%'  fitColumns='true' showFooter="true"
        url="viewstock/26" method="get" title="Editable DataGrid" iconCls="icon-edit"
        singleSelect="true" idField="itemid" fitColumns="true">
    <thead>
        <tr> <th field='_token' editor="textbox" hidden="true" width='100'>_token</th>
                <th field='name' data-options="editor:
				{type:'combobox',options:{id:'product',url:'stockscombo/1',method:'get',valueField:'name',textField:'name',
			onSelect:function(rows){
				var tr=$(this).closest('tr.datagrid-row');
				var idx=parseInt(tr.attr('datagrid-row-index'));
				var ed=$('#tt').datagrid('getEditor',{index:idx,field:'buyingrate'});
				var ed1=$('#tt').datagrid('getEditor',{index:idx,field:'productid'});
				$(ed.target).numberbox('setValue',rows.buyingrate);
				$(ed1.target).numberbox('setValue',rows.id);
			

   


			}}}" width='150'>PdtName</th>
                <th field='buyingrate' editor="numberbox"width='100'>BuyingRate</th>
				<th field='quantity' editor="numberbox" width='80'>Quantity</th>
				<th field='totalamt' editor='numberbox' width='100'>TotalAmt</th>
				<th field='totalpaid' editor='numberbox' width='100'>Totalpaid</th>
                <th field='totaldue' editor="numberbox"  width='100'>Totaldue</th>
                <th field='id'  width='100' hidden='true'>id</th>
                <th field='accountcode' editor="numberbox"  width='100' hidden="true" >Accountcode</th>
                <th field='date' editor="textbox"  width='100'  >Date</th>
            <th field="action" width="80" align="center" formatter="formatAction">Action</th>
        </tr>
    </thead>
</table>
    </div>-->
<script>
    //Start of Javascript
    function formatAction(value,row,index){
    if (row.editing){
        var s = '<a href="#" onclick="saverow(this)">Save</a> ';
        var c = '<a href="#" onclick="cancelrow(this)">Cancel</a>';
        return s+c;
    } else {
        var e = '<a href="#" onclick="editrow(this)">Edit</a> ';
        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
        return e+d;
    }
}


$.extend($.fn.datagrid.defaults.editors, {
    numberspinner: {
        init: function(container, options){
            var input = $('<input type="text">').appendTo(container);
            return input.numberspinner(options);
        },
        destroy: function(target){
            $(target).numberspinner('destroy');
        },
        getValue: function(target){
            return $(target).numberspinner('getValue');
        },
        setValue: function(target, value){
            $(target).numberspinner('setValue',value);
        },
        resize: function(target, width){
            $(target).numberspinner('resize',width);
        }
    }
});
$(function(){
    $('#tt').datagrid({
        onBeforeEdit:function(index,row){
            $(this).datagrid('updateRow', {index:index,row:{editing:true}})
        },
        onAfterEdit:function(index,row){
            $(this).datagrid('updateRow', {index:index,row:{editing:false}})
        },
        onCancelEdit:function(index,row){
            $(this).datagrid('updateRow', {index:index,row:{editing:false}})
        }
    });
});
function getRowIndex(target){
    var tr = $(target).closest('tr.datagrid-row');
    return parseInt(tr.attr('datagrid-row-index'));
}
function editrow(target){
    $('#tt').datagrid('beginEdit', getRowIndex(target));
}
function deleterow(target){
    var row=$('#tt').datagrid('getSelected');
    if(row==null){

        $.messager.alert("Message","Please select a record to delete");
    }else{
    $.messager.confirm('Confirm','Are you sure?',function(r){
        if (r){
           
            $('#tt').datagrid('deleteRow', getRowIndex(target));
            $.ajax({
                url:'deletesales',
                method:'post',
                data:{'id':row.id,'_token':$('input[name=_token]').val()},



            });
           
            
        }
    });
}
}
function saverow(target){
    var $row=$(target).closest('tr');
    var rows = $('#tt').datagrid('getRows');
$.each(rows, function(i, row) {
  $('#tt').datagrid('endEdit', i);
  
  var url = row.isNewRecord ? 'test.php?savetest=true' : 'updatepurchase';
  $.ajax(url, {
      type:'POST',
      dataType: 'json',
      data:row
  });
});
}
function cancelrow(target){
    $('#tt').datagrid('cancelEdit', getRowIndex(target));
}
$('#tt').edatagrid({
    onClickRow:function(rowIndex){
        if (lastIndex != rowIndex){
            $(this).datagrid('endEdit', lastIndex);
            $(this).datagrid('beginEdit', rowIndex);
        }
        lastIndex = rowIndex;
    },
    
    onBeginEdit:function(rowIndex){
        var editors = $('#tt').datagrid('getEditors', rowIndex);
        var token = $(editors[0].target);
       token.textbox('setValue',$('input[name=_token]').val());
       var quantity=$(editors[3].target);
      var totalamt=$(editors[4].target);
       var selling= $(editors[2].target);
       var accountcode= $(editors[7].target);
       var date= $(editors[8].target);
       date.textbox('setValue',$('#transdate').val());
      
       if(isNaN(parseInt($('#accountname').val()))){
          
        accountcode.numberbox('setValue',$('#accountcode').val());  
       }else{
       accountcode.numberbox('setValue',$('#accountname').val());
      
       }
       selling.numberbox({
           onChange:function(){
               var qty=quantity.numberbox('getValue');
               var sale=selling.numberbox('getValue');
               totalamt.numberbox('setValue',qty*sale);


           }

       });
       quantity.numberbox({
           onChange:function(){
            var qty=quantity.numberbox('getValue');
            var sale=selling.numberbox('getValue');
            totalamt.numberbox('setValue',qty*sale);

           }
       });
       var totalpaid=$(editors[5].target);
       var totaldue=$(editors[6].target);
       totalpaid.numberbox({
           onChange:function(){
               totaldue.numberbox('setValue',totalamt.numberbox('getValue')-totalpaid.numberbox('getValue'));


           }
       })


        
    }

    });



    //End of dialog javascript
 var url;
 var finend=null;
 var finstart=null;
 $(document).ready(function(){
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

$('#editsales').click(function(){
        var row=$('#gridcustomers').datagrid('getSelected');
window.location="/editbarcodepurchase/"+row.purchaseheaderid+"/first";
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
      $.ajax({
        async:false,
        url: "activeyear",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
            finend=element.endperiod;
            finstart=element.startperiod;

            });
        }
    });

    $('#gridcustomers').datagrid({
method:'get',
url:'viewdailypurchase?end='+finend+'&start='+finstart,

});
//Auto Generated code for New Entry Code
    $('#branche').combobox({
url:'combobranches',
method:'get',
valueField:'id',
textField:'branchname',
onLoadSuccess:function(){
var data=$(this).combobox('getData');
for (var i = 0;i<data.length;i++ ) {
					if(data[i].isDefault==1){
						$('#branche').combobox('select', data[i].id);
                        $('#product').combobox('reload','/stockscombo/'+data[i].id);
					
					}
}

}
});

   $('#newcustomers').click(function(){
       $('#dlgcustomers').dialog('open').dialog('setTitle','New customers');
url='/savecustomers';
$('#frmcustomers').form('clear');
});

       //Auto Generated code for Edit Code
       $('#edit').click(function(){
 
 var row=$('#gridcustomers').datagrid('getSelected');
 $('#dlgtrans').dialog('open').dialog('setTitle','Edit Purchase Transcations');
  url="/viewstock/"+row.purchaseheaderid;
  edittranscations();
 $('#edittrans').form('load',row);  

 

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
data:{'id':id,'name':name,'phone':phone,'address':address,'tel':tel,'email':email,'isActive':isActive,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()}
});
  
$('#dlgcustomers').dialog('close');
  
$('#gridcustomers').datagrid('reload');
});
//Auto generated code for deleting
$('#del').click(function(){

var a=$('#gridcustomers').datagrid('getSelected');
if(a==null){
    $.messager.alert('Delete','Please select a row to delete');
    
}else{
    $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
        if(r){
            var row=$('#gridcustomers').datagrid('getSelected');
            $.ajax({
             url:'/destroysalesrecord/'+row.purchaseheaderid,
             method:'POST',
             data:{'id':row.purchaseheaderid,'_token':$('input[name=_token]').val()},
             success:function(){
                $('#gridcustomers').datagrid('reload');
             }
            });
            
        }

});
}
});
// Searching
function edittranscations(){

$('#tt').datagrid({
url:url,
onSuccess:function(){

    $('#tt').datagrid('reload');
}


});

    
}


$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    var product=$('#product').val();
    var branch=$('#branche').val();
$('#gridcustomers').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2}

});

});

$('#excel').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    if(date1=='' && date2==''){
        window.location="purchaseexcel/xlsx/today/today";
    }
    else if(date1!='' && date2==''){
        window.location="purchaseexcel/xlsx/"+date1+"/today";  
    }
    else if(date1!='' && date2!=''){
        window.location="purchaseexcel/xlsx/"+date1+"/"+date2;  
    }

});
});
</script>