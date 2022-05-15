@include('layouts/header')
<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">	
	<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>	
	<script type="text/javascript" src="{{asset('assets/js/echarts.min.js')}}"></script>
	@foreach($company as $companys)
<div>
<div style="position:absolute;top:28%;opacity: .3;height:500px;width:100%;background-image:url(<?php echo "images/$companys->logo";?>); background-repeat: no-repeat; background-position: center;
     ">

</div>

@endforeach

<div style="font-size:25px;margin-left:18%;margin-top:0%">
<b><u>Daily Summary</u></b>

@if(Auth::user()->admin==1)<b style="font-size:25px;margin-left:42%;margin-top:0%;"><u>General Summary</u></b>
@endif
</div>
<div class="row">
<b></b>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa fa-calculator fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								@foreach($totalsales as $totalsales)
                                    <div style="font-size:20px" class="">{{$totalsales->totalamt}} <b style="font-size:14px">UGX</b></div>
									@endforeach
                                    <div style="font-size:15px;"><a href="/salesreport" style="color:white;">Total Sales
                                    
                                    </a></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   @foreach($cashathand as $cash)
                                    <div style="font-size:20px" class="">{{$cash->amount}} <b style="font-size:14px">UGX</b></div>
									@endforeach
                                    <div style="font-size:15px;"><a href="/viewcode/3600" style="color:white;">Cash At Hand</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->admin==1)
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                @if(Auth::user()->admin==1)
                                   @foreach($stockvalue as $value)
                                    <div  style="font-size:20px" class="">{{$value->amount}} <b style="font-size:14px">UGX </b></div>
									@endforeach
                                    @else
                                    <div  style="font-size:20px" class="">0 <b style="font-size:14px">UGX </b></div>

                                    @endif
                                    <div style="font-size:15px;" ><a href="/viewcode/1113" style="color:white;">Stock Value</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endif

@if(Auth::user()->admin==1)
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-sort-amount-desc  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    @foreach($outofstock as $stock)
                                    <div style="font-size:20px" class="">{{$stock->stock}}<b style="font-size:14px"> Product (s) </b></div>
									@endforeach
                                    <div style="font-size:15px;"><a href="/stockreport" style="color:white"> Out of Stock</a></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
@endif

            </div>
            <div class="row">
            <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-balance-scale fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								@foreach($totalexpenses as $totalexpenses)
                                    <div style="font-size:20px"  class="">{{$totalexpenses->amount}} <b style="font-size:14px">UGX </b></div>
                                    <div style="font-size:15px;" ><a href="/totalexpenses" style="color:white;">Total  Expenses</a></div>
									@endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-th-large  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <!-- Loop -->@foreach($credit as $crdt)
                                    <div  style="font-size:20px" class="">{{$crdt->amount}}<b style="font-size:15px;color:white;"> UGX</b></div>
									<!-- End loop -->@endforeach
                                   <a href="/salespending"> <div style="color:white;font-size:15px;"> Credit Sales </div></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->admin==1)
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-product-hunt  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                  @foreach($allitems as $allitems)
                                    <div style="font-size:20px" class="">{{$allitems->items}} <b style="font-size:15px">Products </b></div>
									@endforeach<!-- End loop -->
                                    <div style="font-size:15px;"><a href="/stocks" style="color:white">All Items</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::user()->admin==1)
                <div class="col-lg-3 col-md-6">
                    <div  style=";" class="panel  panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cart-plus   fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   @foreach($instock as $instock)
                                    <div style="font-size:20px" class="">{{$instock->instock}} <b style="font-size:14px">Products </b></div>
									@endforeach
                                    <div style="font-size:15px;" >In Stock</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endif
@if(Auth::user()->admin==1)
            <div class="col-md-6">
	<h1 class="text-center" style="font-size:14px;;font-weight:700">Top Demanded Products</h1>
    <div class="col-md-8 col-md-offset-2">
    	<div class="col-xl-6">
    		<div class="card">
    			<div class="card-body">
    				<div class="chart-container">
    					<div class="chart has-fixed-height" id="bars_basic"></div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>	
</div>
@endif
@if(Auth::user()->admin==1)
<div class="col-md-6">
	<h1 class="text-center" style="font-size:14px;;font-weight:700">Least Demanded Products</h1>
    <div class="col-md-8 col-md-offset-2">
    	<div class="col-xl-6">
    		<div class="card">
    			<div class="card-body">
    				<div class="chart-container">
    					<div class="chart has-fixed-height" id="least"></div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>	
</div>
@endif
</div>
</body>
            <script type="text/javascript">
var bars_basic_element = document.getElementById('bars_basic');
if (bars_basic_element) {
    var bars_basic = echarts.init(bars_basic_element);
    bars_basic.setOption({
        color: ['#3398DB'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {            
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                data: [  @foreach($topDemandPdt as $top)
                    "{{$top->name}}",

@endforeach],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],
        series: [
            {
                name: 'Total Products',
                type: 'bar',
                barWidth: '50%',
                data: [
                    @foreach($topDemandPdt as $top)
                    {{$top->counts}},

@endforeach
                ]
            }
        ]
    });
}
// Least
var bars_basic_element = document.getElementById('least');
if (bars_basic_element) {
    var bars_basic = echarts.init(bars_basic_element);
    bars_basic.setOption({
        color: ['#3398DB'],
        extraCssText: "width:200px; white-space:pre-wrap;",
        tooltip: {
            trigger: 'axis',
            axisPointer: {            
                type: 'shadow'
            },
            
        },
        label:{
show:false,
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
            
        },
        xAxis: [
            {
                type: 'category',
                data: [@foreach($leastDemandPdt as $top)
                    "{{$top->name}}",

@endforeach],
                triggerEvent: true,
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],
        series: [
            {
                name: 'Total Products',
                type: 'bar',
                barWidth: '50%',
                data: [
                    @foreach($leastDemandPdt as $top)
                    {{$top->counts}},

@endforeach
                ]
            }
        ]
    });
}
</script>
