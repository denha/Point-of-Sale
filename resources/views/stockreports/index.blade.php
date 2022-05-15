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
<table class='easyui-datagrid'  striped='true' rownumbers="true" title='Stock Report' iconCls='fa fa-table' singleSelect='true' url='viewdailystock' pagination='true' id='gridcustomers' method='get' fitColumns='true' style='width:100%' toolbar='#customerstoolbar'>
<thead><tr>
<th field='itemname' width='100'>Product</th>
<th field='description' hidden  width='100'>Description</th>
<th field='buyingrate' width='100'>BuyingRate</th>
<th field='Dozens'hidden  width='100'> Qty Available</th><!-- important for multiple units of measure -->
<th field='stockavailabe'  width='100'> Qty Available</th>
<th field='Pieces' hidden width='100'>Quantity</th>

<th field='limitlevel' width='100'>Reorder-Point</th>
<th field='ctrlLimit' hidden width='100'>Limit</th>
<th field="available" hidden width="100">Available</th>

</tr></thead>
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
 id="group" name="group"> By Item Group</a>
 &nbsp;<a href="javascript:void(0)" class="btn btn-primary"
 id="category" name="category"> By Item Category</a>
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
$('#group').click(function(){
    window.location="/stockgroupview";
})
$('#category').click(function(){
    window.location="/stockcategoryview";
})
});
</script>