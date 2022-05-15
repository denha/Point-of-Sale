var rowIndex;
	
	$("#transdates").val(new Date().toISOString().substring(0, 10));
	function saverows(){
		var id=$('#purchaseno').val();
		$('#tt').edatagrid('saveRow');
		$('#tt').datagrid({
			url:'/viewstock/'+id,
			method:'get'
		});


	}

	function deleterows(){
        var rows=$('#tt').datagrid('getSelected');
		$.ajax({
			url:'/destroystocktrans/'+rows.id,
			method:'POST',
			data:{'id':rows.id,'_token':$('input[name=_token]').val()},
			success:function(){
				$('#tt').datagrid('reload');
			}


		});
	$('#tt').datagrid('reload');
		
	}
	function addrows(){
		//$('#frmpurchaseheaders').form('submit',{
		
                //onSubmit: function(){
					
                     //if($(this).form('validate')){
						$('#tt').edatagrid('addRow');
					
						//}
					
              //  },
				
		//});
		
	}
	$(function(){

						$.ajax({
        async:false,
        url: "maxnumber",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#purchaseno').val(element.id);

            });
        }
    });
			$('#tt').edatagrid({
				
				saveUrl:'savestocktrans',
				updateUrl:'editpurchases',
				url:'viewitempurchase/'+$('#purchaseno').val(),
				method:'get',
				onSuccess: function(index,row){
					if(row.isError){
						//alert('not saved');
				//	$.messager.alert('Alert',row.Error);
					$('#tt').datagrid('reload');
					}
					
				},
			


				
				onClickRow:function(rowIndex){
					if (lastIndex != rowIndex){
						$(this).datagrid('endEdit', lastIndex);
						$(this).datagrid('beginEdit', rowIndex);
					}
					lastIndex = rowIndex;
				},
				
				onBeginEdit:function(rowIndex){
					var editors = $('#tt').datagrid('getEditors', rowIndex);
					var products = $(editors[0].target);
					var unitpx = $(editors[2].target);
					var txtQuantity = $(editors[3].target);
					var txtAmt=$(editors[4].target);
					var totalpay=$(editors[5].target);
					var totaldue=$(editors[6].target);
					var _token=$(editors[7].target);
					var number=$(editors[8].target);
					var branch=$(editors[9].target);
					var pac=$(editors[11].target);
					var dat=$(editors[12].target);
					var actualdate=$('#transdates').val();
					pac.numberbox('setValue',$('#paccount').val());
					var branch_id=$('#branch').val();
					branch.numberbox('setValue',branch_id);
					var pno=$('#purchaseno').val();
					number.numberbox('setValue',pno);
					var token=$('input[name=_token]').val();
					_token.textbox('setValue',token);
					var bra=$('#branch').val();
					$(products).combobox('reload','stockscombo/'+bra);
					dat.textbox('setValue',actualdate);

					txtQuantity.numberbox({
						required:true,
						onChange:function(){
							var total=unitpx.numberbox('getValue');
							var qty=txtQuantity.numberbox('getValue');
							txtAmt.numberbox('setValue',total*qty);
							totalpay.numberbox('setValue',total*qty);
						}
						});
					totalpay.numberbox({
						required:true,
						onChange:function(){
							var Due=unitpx.numberbox('getValue')*txtQuantity.numberbox('getValue')-totalpay.numberbox('getValue');
							totaldue.numberbox('setValue',Due);
							}
							});

							unitpx.numberbox({
								onChange:function(){
									//alert('yes');
									txtAmt.numberbox('setValue',(unitpx.numberbox('getValue')*txtQuantity.numberbox('getValue')));
									totalpay.numberbox('setValue',(unitpx.numberbox('getValue')*txtQuantity.numberbox('getValue')));
								}

							});
					
				}
			

			});
		});
		
		function validateDate(date){
$.getJSON('activeyear',function(data){
if(data==''){
$.messager.alert('Warning','Financial Period Not Set..Please set it and try again','warning');
$('#transdates').datebox('setValue','');

}else{
	$.each(data, function (index, value) {
		
var start= new Date(value.startperiod).getTime()/1000;
var end =new Date(value.endperiod).getTime()/1000;
var inputdate=date.getTime()/1000;
if(inputdate<start || inputdate>end){
var a=$.messager.alert('Warning','You can not enter a date that is not with in the Active Financial Period '+value.startperiod+ ' AND '+value.endperiod,'warning');
$('#transdates').datebox('setValue', '');
}

});
}

});

}
 $(document).ready(function(){
	var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = dd + '-' + mm + '-' + yyyy;


$('#transdates').datebox({
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
$('#transdates').datebox('setValue',today);	
//Auto Generated code for New Entry Code



$('#branch').combobox({
url:'combobranches',
method:'get',
valueField:'id',
textField:'branchname',
onLoadSuccess:function(){
	var data = $(this).combobox("getData");
	
                 for (var i = 0;i<data.length;i++ ) {
					if(data[i].isDefault==1){
						$('#branch').combobox('select', data[i].id);
					
					}
               
                }
				var tr=$(this).closest('tr.datagrid-row');
var idx=parseInt(tr.attr('datagrid-row-index'));

var ed=$('#tt').datagrid('getEditor',{index:idx,field:'stockid'});
//$(ed.target).combobox('select','go');

//$(ed.target).combobox('select','go');
				
} ,
onselect:function(results){
var url='/stockscombo/2';
//var tr=$(this).closest('tr.datagrid-row');
//var idx=parseInt(tr.attr('datagrid-row-index'));

//var ed=$('#tt').datagrid('getEditor',{index:idx,field:'stockid'});

//$(ed.target).combobox('select','go');

},
onChange:function(){
	var branch=$(this).combobox('getValue');
	
	$.ajax({
	url:'updatestockbranch',
	method:'POST',
	data:{'branch':branch,'pno':$('#purchaseno').val(),'_token':$('input[name=_token]').val()},
	});
	}
});
$('#mode').combobox({
	onLoadSuccess:function(){
		var data=$(this).combobox('getData');
		for (var i = 0;i<data.length;i++ ) {
			if(data[i].id==1){
				$('#mode').combobox('select', data[i].name);
			
		}
}


	}
});





$('#paccount').combobox({
	url:'combochartofaccounts/1',
	valueField:'accountcode',
	textField:'accountname',
onLoadSuccess:function(){
	var data = $(this).combobox("getData");
	
	for (var i = 0;i<data.length;i++ ) {
	   if(data[i].defaul==1 && data[i].isInventory==1){
		   $('#paccount').combobox('select', data[i].accountcode);
	   
	   }
  
   }
},
// On change paying account
onSelect:function(data){

$.ajax({
url:'updatebranch',
method:'post',
data:{'payingaccount':data.accountcode,'pno':$('#purchaseno').val(),'_token':$('input[name=_token]').val()}

});

}

});
$('#supplier_id').combobox({
url:'supplierscombo',
method:'get',
valueField:'id',
required:'true',
textField:'companyName',

onLoadSuccess:function(){
	var data = $(this).combobox("getData");
	
                 for (var i = 0;i<data.length;i++ ) {
					if(data[i].isDefault==1){
						$('#supplier_id').combobox('select', data[i].id);
					
					}
               
                }
} 
});



//Auto Generated Code for Saving
$('#savepurchaseheaders').click(function(){

var id=$('#id').val();
var transdates=$('#transdates').val();
var mode=$('#mode').val();
var supplier_id=$('#supplier_id').val();
//var customer_id=$('#customer_id').val();
var branch_id=$('#branch').val();
//var isActive=$('#isActive').val();

$('#frmpurchaseheaders').form('submit',{
	onSubmit: function(){
                    if($(this).form('validate')==true ){

	$.ajax({
		url:'/savepurchaseheaders',
		method:'POST',
		data:{'_token':$('input[name=_token]').val(),'transdates':transdates,'mode':mode,'supplier_id':supplier_id,'branch_id':branch_id},
		success:function(){
			$.messager.progress({title:'Saving',msg:"Please wait...."});
			$.ajax({
				async:false,
				url: "maxnumber",
				method:"get",
				dataType:"json",
				success: function(data){
					$.each(data, function(index, element) {
						$('#purchaseno').val(element.id);
			  var emtpy="";
			 // $('#transdates').val(emtpy);
			  var id=$('#purchaseno').val();
				$('#tt').datagrid({
					
					url:'/viewitempurchase/'+id,
					method:'get'
				});
		
		
					});
				}
			});
			  $.messager.progress('close');
			  $.messager.show({title:'Info',msg:'Transcation succesfully Saved'});
		}
	});					
/*$.ajax({
url:'/savepurchaseheaders',
method:'POST',
data:{'id':id,'transdates':transdates,'mode':mode,'supplier_id':supplier_id,'customer_id':customer_id,'branch_id':branch_id,'isActive':isActive,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},

});*/

					
					}
                }
	});


//get purchase number after saving
 

});
//Auto generated code for deleting
$('#deletepurchaseheaders').click(function(){

    var a=$('#gridpurchaseheaders').datagrid('getSelected');
    if(a==null){
        $.messager.alert('Delete','Please select a row to delete');
        
    }else{
        $.messager.confirm('Confirm','Are you sure you want to Delete this Record',function(r){
            if(r){
                var row=$('#gridpurchaseheaders').datagrid('getSelected');
                $.ajax({
                 url:'/destroypurchaseheaders/'+row.id,
                 method:'POST',
				 data:{'id':row.id,'_token':$('input[name=_token]').val()},
				 success:function(){
					$('#gridpurchaseheaders').datagrid('reload'); 
				 }
                });
                
            }

});
}
});



});

