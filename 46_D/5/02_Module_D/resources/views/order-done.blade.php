@extends('layouts.main')
@section('title','訂票成功')
@section('body','order')
@section('content')
	<style>
    	label{
			display: inline-block;
			width: 70px;
			text-align: right;
		}
    </style>
    <p class="message_ok">
        訂票成功
    </p>
    <p>
        <label>訂票編號</label>
        <span>{{ $order->unique }}</span>
    </p>
    <p>
        <label>手機號碼</label>
        <span>{{ $order->phone }}</span>
    </p>
    <p>
        <label>發車時間</label>
        <span>{{ $order->start_time }}</span>
    </p>
    <p>
        <label>車次</label>
        <span>{{ $order->code }}</span>
    </p>
    <p>
        <label>起訖站</label>
        <span>{{$order->from}} 到 {{$order->to}}</span>
    </p>
    <p>
        <label>張數</label>
        <span>{{$order->count}}張/每張{{ number_format($order->money / $order->count) }}</span>
    </p>
    <p>
        <label>總票價</label>
        <span>{{ number_format($order->money) }}</span>
    </p>
@endsection
