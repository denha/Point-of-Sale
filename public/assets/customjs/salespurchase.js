var rowIndex;
	var Purch;
	//var d= new Date();

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
			data:{'id':rows.id,'_token':$('input[name=_token]').val()}


		});
	$('#tt').datagrid('reload');
		
	}
	function addrows(){
		//$('#frmpurchaseheaders').form('submit',{
		
                //onSubmit: function(){
					
                    //if($(this).form('validate')){
						$('#tt').edatagrid('addRow');
						//}
					
               // },
				
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
				saveUrl:'savesalespurchases',
				onError: function(index,row){
					alert(row.msg);
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
					var unitpx = $(editors[1].target);
					var txtQuantity = $(editors[2].target);
					var txtAmt=$(editors[3].target);
					var totalpay=$(editors[4].target);
					var totaldue=$(editors[5].target);
					var _token=$(editors[6].target);
					var number=$(editors[7].target);
					var branch=$(editors[8].target);
					var branch_id=$('#branch').val();
					var productsid = $(editors[9].target);
					var raccount= $(editors[10].target);
					var dat=$(editors[11].target);
					var actualdate=$('#transdates').val();
					dat.textbox('setValue',actualdate);
					raccount.numberbox('setValue',$('#raccount').val());
					branch.numberbox('setValue',branch_id);
					var pno=$('#purchaseno').val();
					number.numberbox('setValue',pno);
					var token=$('input[name=_token]').val();
					_token.textbox('setValue',token);
					var bra=$('#branch').val();
					$(products).combobox('reload','stockscombo/'+bra);
					
					txtQuantity.numberbox({
						required:true,
						onChange:function(){
							var total=unitpx.numberbox('getValue');
							var qty=txtQuantity.numberbox('getValue');
							txtAmt.numberbox('setValue',total*qty);
							var url = "/pdtbranch/"+productsid.numberbox('getValue')+"/"+bra;

                      $.getJSON(url, function (data) {
	              $.each(data, function (index, value) {
					
	  
	                    if(qty>value.stockavailabe){
							$.messager.alert('Info','Not Enough stock !! Please Restock');
							//qty.numberbox('setValue',3);
						}
	                           });
                             });
						}
						});
					totalpay.numberbox({
						required:true,
						onChange:function(){
							var Due=unitpx.numberbox('getValue')*txtQuantity.numberbox('getValue')-totalpay.numberbox('getValue');
							totaldue.numberbox('setValue',Due);
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
//$('#transdates').datebox('setValue','10/07/2018');
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

today = mm + '-' + dd + '-' + yyyy;
$('#transdates').datebox('setValue',today);	

//Auto Generated code for New Entry Code
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
//setting default recieving account for inventory

$('#raccount').combobox({
	url:'combochartofaccounts/1',
	valueField:'accountcode',
	textField:'accountname',
onLoadSuccess:function(){
	var data = $(this).combobox("getData");
	
	for (var i = 0;i<data.length;i++ ) {
	   if(data[i].isDefault==1 && data[i].isInventory==1){
		   $('#raccount').combobox('select', data[i].accountcode);
	   
	   }
  
   }

},
onSelect:function(data){

$.ajax({
url:'updatebranch1',
method:'post',
data:{'payingaccount':data.accountcode,'pno':$('#purchaseno').val(),'_token':$('input[name=_token]').val()}

});

}

});
// Setting parameters for customers
$('#customer_id').combobox({
url:'customerscombo',
method:'get',
valueField:'id',
textField:'name',
required:'true',
icons:[{
	iconCls:'icon-add',handler:function(){
		$('#dlgcustomers').dialog('open').dialog('setTitle','New customers');
      // url='/savecustomers';
      $('#frmcustomers').form('clear');

}
}]



});
//Auto Generated Code for Saving
$('#savecustomers').click(function(){ 

newcustomer();

	
	});
$('#savepurchaseheaders').click(function(){ 
var id=$('#id').val();
var transdates=$('#transdates').val();
var mode=$('#mode').val();
var supplier_id=$('#supplier_id').val();
var customer_id=$('#customer_id').val();
var branch_id=$('#branch').val();
var isActive=$('#isActive').val();
var created_at=$('#created_at').val();
var updated_at=$('#updated_at').val();

$('#frmpurchaseheaders').form('submit',{
	onSubmit: function(){
                    if($(this).form('validate')){
						$.messager.progress({title:'Saving',msg:"Please wait...."});


$.ajax({
url:'/savesales',
method:'POST',
data:{'id':id,'transdates':transdates,'mode':mode,'supplier_id':supplier_id,'customer_id':customer_id,'branch_id':branch_id,'isActive':isActive,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(){
	$.ajax({
        async:false,
        url: "maxnumber",
        method:"get",
        dataType:"json",
        success: function(data){
            $.each(data, function(index, element) {
				$('#purchaseno').val(element.id);
	  var emtpy="";
	  $('#transdates').val(emtpy);
	  var id=$('#purchaseno').val();
		$('#tt').datagrid({
			
			url:'/viewstock/'+id,
			method:'get'
		});
	 
		
	  $.messager.progress('close');
	  $.messager.show({title:'Info',msg:'Transcation succesfully Saved'});

            });
        }
    });
}
});

					
					}
                }
	});
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
                 data:{'id':row.id,'_token':$('input[name=_token]').val()}
                });
                $('#gridpurchaseheaders').datagrid('reload');
            }

});
}
});


// adding a new row to the grid
//fetching Purchase stock id 
function newcustomer(){

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
url:'savecustomers',
method:'POST',
data:{'id':id,'name':name,'phone':phone,'address':address,'tel':tel,'email':email,'isActive':isActive,'created_at':created_at,'updated_at':updated_at,'_token':$('input[name=_token]').val()},
success:function(){
	$('#customer_id').combobox('reload','customerscombo');
}
});


$('#dlgcustomers').dialog('close');
}



});

