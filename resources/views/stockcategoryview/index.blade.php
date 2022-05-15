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
<table class='easyui-datagrid'  striped='true' rownumbers="true"  iconCls='fa fa-table' singleSelect='true' url='' pagination='true' id='gridcustomers'  toolbar='#customerstoolbar'>
<!--<thead><tr>
<th field='itemname' width='100'>Product</th>
<th field='description' hidden  width='100'>Description</th>
<th field='buyingrate' width='100'>BuyingRate</th>
<th field='Dozens'hidden  width='100'> Qty Available</th><!-- important for multiple units of measure -->
<!--<th field='stockavailabe'  width='100'> Qty Available</th>
<th field='Pieces' hidden width='100'>Quantity</th>

<th field='limitlevel' width='100'>Reorder-Point</th>
<th field='ctrlLimit' hidden width='100'>Limit</th>
<th field="available" hidden width="100">Available</th>

</tr></thead>-->
</table>
<div id='customerstoolbar'>
 <label>Date</label>
<input  class='easyui-datebox'  required style="width:15%;height:34px;"  id="date1" name="date1"/>To
<input  class='easyui-datebox' id="date2" style="width:15%;height:34px;" name="date2"  required/>
<label>Product</label>
<input class="easyui-combobox" id="product" style="width:20%;height:34px;" name="product" data-options="url:'/stockscombo/1',valueField:'id',textField:'name',method:'get' "/>
<!--<label>Branch</label>
<input class="easyui-combobox" id="branche" name="branche" data-options="url:'combobranches',valueField:'id',textField:'branchname',method:'get' "/>-->&nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="find" name="find"><i class="fa fa-search"></i> Find</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="item" name="item"><i class="fa fa-eye"></i> By Item</a>

 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="group" name="group"><i class="fa fa-eye"></i> By Item Group</a>
</div>

{{csrf_field()}}
<script>
 var url;
 $(document).ready(function(){
    $('#gridcustomers').datagrid({
    rowStyler:function (index, row) {
       
        
			if (parseInt(row.ctrlLimit)<=parseInt(row.limitlevel)) {
				return 'background-color:rgb(255, 0, 0);';//rgb(209, 91, 71)
			}
		}
});
   
$('#gridcustomers').datagrid({
        pageSize:50,
        pageList:[10,20,30,40,50],


    });
   
    $('#gridcustomers').datagrid({
				title:'Stock Report by Item Category',
				width:'100%',
				rownumbers:true,
				remoteSort:false,
				nowrap:false,
				fitColumns:true,
				url:'/viewdailystock',
                method:'get',
				columns:[[
					{field:'itemname',title:'Product',width:100,sortable:true},
					{field:'description',title:'Description',width:300},
					{field:'buyingrate',title:'Buying Rate',width:100},
					{field:'stockavailabe',title:'Qty Available',width:200},
                    {field:'limitlevel',title:'Reorder-Point',width:200},
                    {field:'ctrlLimit',hidden:'true',title:'ctrl Limit',width:200},
                    {field:'available',hidden:'true',title:'Available',width:200},
				
				]],
				groupField:'catid',
				view: groupview,
					groupFormatter:function(value, rows){
                        //alert(rows[1].Debit);
                        var data = $('#gridcustomers').datagrid('getData');
                     var start=0;
                     var sum=0;
                var type;
         $.map(rows, function(row){
            sum=sum+parseInt(row['available']);
            type=row['categoryname'];
         });
           var nums=rows.length;
          
					return  "<center style='font-size:16px;margin-left:450px;'>"+type+"</center>";
				}
			});
// Searching
$('#find').click(function(){
    var date1=$('#date1').val();
    var date2=$('#date2').val();
    var product=$('#product').val();
    //var branch=$('#branche').val();
$('#gridcustomers').datagrid({
method:'get',
queryParams:{date1:date1,date2:date2,product:product}

});

});
$('#item').click(function(){
window.location="/stockreport";
});
$('#group').click(function(){
window.location="/stockgroupview";
});
});
</script>