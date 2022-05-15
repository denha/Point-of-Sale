<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  

    <title>Perpetual Accounting</title>
<style>
.rowz{
    margin:0px;
}
h2{
    margin-top:40px;
}

</style>
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap1.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="row">
@foreach($product as $p)
<div class="col-sm">
<div {{!! DNS1D::getBarcodeHTML($p->barcode,'C128A') !!}}</div>
<h2>{{$p->barcode}} </h2>
</div>
@endforeach
</div>
