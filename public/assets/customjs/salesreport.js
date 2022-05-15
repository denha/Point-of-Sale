var rowIndex;
var url;

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
    $('#gridcustomers').datagrid({


    });
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
                success:function(data){
                    $('#tt').datagrid('roload');
                }



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
  
  var url = row.isNewRecord ? 'test.php?savetest=true' : 'upDateUrl';
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
      var date=$(editors[8].target);
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
       date.textbox('setValue',$('#transdate').val());
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

 
 var url;
 var urL2;
 var isLast;
 var finend = null;
 var finstart = null;

$(document).ready(function(){
   
  
    
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
   
});

   
    
 $(document).ready(function(){
//Auto Generated code for New Entry Code
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
//Load Current Period when the page loads
$('#gridcustomers').datagrid({
method:'get',
url:'viewdaily?end='+finend+'&start='+finstart,

});
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

},
onSelect:function(record){
    $('#product').combobox('reload','/stockscombo/1');

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
       $('#dlgtrans').dialog('open').dialog('setTitle','Edit Sales Transcation');
        url="/viewstock/"+row.purchaseheaderid;
        edittranscations();
       $('#edittrans').form('load',row);  

       

       });
       $('#editsales').click(function(){
        var row=$('#gridcustomers').datagrid('getSelected');
window.location="/editbarcodesales/"+row.purchaseheaderid+"/first";
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
				var first=row.purchaseheaderid;
				var last=row.transfercode;
				if(first>0 && last>0){
					urL2=last;
					isLast='yes';
				}else if(first>0 && last==0){
					urL2=first;
					isLast='No';
				}
                $.ajax({
                 url:'/destroysalesrecord/'+urL2,
                 method:'POST',
                 data:{'isLast':isLast,'id':row.purchaseheaderid,'_token':$('input[name=_token]').val()},
                 success:function(data){
                    $('#gridcustomers').datagrid('reload');

                 }
                });
                
            }

});
}
});
// setting Finanical Periods
//Editing 
// Call Grid to diplay Edit Options

    
// Searching
$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    var product=$('#product').val();
    var branch=$('#branche').val();
    var financialend=$('#financialend').val();
    var finanacialstart=$('#financialstart').val();
  
$('#gridcustomers').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,product:product,branch:branch,financialend:financialend,finanacialstart:finanacialstart}

});

});

$('#excel').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    if(date1=='' && date2==''){
        window.location="salesexcel/xlsx/today/today";
    }
    else if(date1!='' && date2==''){
        window.location="salesexcel/xlsx/"+date1+"/today";  
    }
    else if(date1!='' && date2!=''){
        window.location="salesexcel/xlsx/"+date1+"/"+date2;  
    }

});

});
function edittranscations(){

$('#tt').datagrid({
url:url,
onSuccess:function(){

    $('#tt').datagrid('reload');
}


});

    
}