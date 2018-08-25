@extends('layouts.main')
@section('title', '訂票成功 - ')
@section('type','order')
@section('content')
	<style>
		label{
			color: #33f;
		}
	</style>
	<div id="content">
        <p class="message_ok">
            訂票成功
        </p>
        <p>
            <label>訂票編號: </label>
            <span>{{ $number }}</span>
        </p>
        <p>
            <label>手機號碼: </label>
            <span>{{ $phone }}</span>
        </p>
        <p>
            <label>發車時間: </label>
            <span>{{ $time }}</span>
        </p>
        <p>
            <label>車次: </label>
            <span>{{ $code }}</span>
        </p>
        <p>
            <label>起訖站: </label>
            <span>{{ $station_n_c[$from] }} 到 {{ $station_n_c[$to] }}</span>
        </p>
        <p>
            <label>張數: </label>
            <span>{{ $count }}張/每張{{ $money }}</span>
        </p>
        <p>
            <label>總票價: </label>
            <span>{{ $total_money }}</span>
        </p>
    </div>
@endsection