@extends('welcome')

@section('title','繼承頁面')

@section('text')
	@parent
	超級小光
@endsection

@section('cont')
	<p>超級小光div</p>
@endsection