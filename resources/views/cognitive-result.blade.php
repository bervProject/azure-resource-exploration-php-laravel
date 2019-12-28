@extends('layout.main')
@section('content')
<div class="container">
<h2 class="title">Cognitive Result</h2>
<img src='{{$file}}' />
<h3 class="subtitle">{{$captions}}</h3>
@endsection
