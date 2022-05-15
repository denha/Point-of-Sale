
<div style="font-size:18px;font-weight: bold;">
@foreach($company as $companys)
{{$companys->name}}<br>
{{$companys->location}} {{$companys->boxno}}<br>
Tel :{{$companys->phone}}<br>
Email:{{$companys->email}}<br>
<?php echo "<img src='images/$companys->logo' style='position:absolute;left:580px;top:-16px;' width='140px' alt='' />"; ?>
@endforeach

</div>
@foreach($client as $clnt)
<center><h3> Customer Name : {{$clnt->name}}  <br>{{$asof}}  </h3></center>
@endforeach
<hr>
<table   width="100%">
<tr><td width="50px"><b>Date</b></td><td width="100px"><b>Item Name</b></td> <td width="50px"><b>Qty</b></td><td width="50px"><b>Total Amount</b></td><td width="50px"><b>Total Paid</b></td><td width="50px"><b>Bal</b></td>  </tr>
</table>
<hr>
<table  width="100%">
@foreach($expense as $led)
<tr>
<td width="50px"> {{$led->transdate}}</td>
<td width="100px"> {{$led->stocknames}}</td>
<td width="50px"> {{$led->quantity}}</td>
<td width="50px"> {{$led->totalamt}}</td>
<td width="50px"> {{$led->totalpaid}}</td>
<td width="50px"> {{$led->bal}}</td>
</tr>
@endforeach
</table>
<hr>
<table  width="100%">
@foreach($expensetotal as $led)
<tr>
<td width="50px"> </td>
<td width="100px"> </td>
<td width="50px"> </td>
<td width="50px"> {{$led->totalamt}}</td>
<td width="50px"> {{$led->totalpaid}}</td>
<td width="50px"> {{$led->bal}}</td>
</tr>
@endforeach
</table>