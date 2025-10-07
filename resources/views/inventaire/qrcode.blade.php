@extends('layouts.dynamique')

@section('content')
<h3>{{ $materiel->type }} - {{ $materiel->code_interne }}</h3>
<div>{!! $qr !!}</div>
@endsection