<div style="font-size:18px;font-weight: bold;">
@foreach($company as $companys)
{{$companys->name}}<br>
{{$companys->location}} {{$companys->boxno}}<br>
Tel :{{$companys->phone}}<br>
Email:{{$companys->email}}<br>
<?php echo "<img src='images/$companys->logo' style='position:absolute;left:580px;top:-14px;' width='140px' alt='' />"; ?>
@endforeach



</div>

<center><h3> @foreach($name as $name)Ledger Report ({{$name->accountname}}) @endforeach   {{$asof}}  </h3></center>

<hr>
<table   width="106%">
<tr><td width="80px"><b>Date</b></td><td width="350px"><b>Narration</b></td> <td width="50px"><b>Debit</b></td><td width="50px"><b>Credit</b></td><td width="100px"><b>Ledger Bal</b></td>  </tr>
</table>
<hr>
<table  width="106%">
@foreach($ledger as $led)
<tr>
<td width="80px"> {{$led->transdates}}</td>
<td width="350px"> {{$led->narration}}</td>
<td width="50px"> {{$led->debits}}</td>
<td width="50px"> {{$led->credits}}</td>
<td width="100px"> {{$led->runningbal}}</td>
</tr>
@endforeach
</table>
<hr>
<table  width="106%">
@foreach($ledgerfooter as $led)
<tr>
<td width="80px"> </td>
<td width="350px"> </td>
<td width="50px"> {{$led->debits}}</td>
<td width="50px"> {{$led->credits}}</td>
<td width="100px"> </td>
</tr>
@endforeach
</table>
