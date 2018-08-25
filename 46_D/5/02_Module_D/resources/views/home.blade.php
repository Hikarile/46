@extends('layouts.main')
@section('title','首頁')
@section('body','home')
@section('content')
    <form>
        <fieldset>
            <legend>列車查詢</legend>
            <p>
                <label for="from">起程站</label>
                <select id="from">
                    @foreach(station_ec() as $key=>$value)
                    	<option value="{{$key}}">{{$value}}站</option>
                    @endforeach
                </select>
            </p>
            <p>
                <label for="to">到達站</label>
                <select id="to">
                    @foreach(station_ec() as $key=>$value)
                    	<option value="{{$key}}">{{$value}}站</option>
                    @endforeach
                </select>
            </p>
            <p>
                <label for="type">車種</label>
                {{type_form()}}
            </p>
            <p>
                <label for="date">搭乘日期</label>
                <input type="date" value="2016-06-23" id="date" required>
            </p>
            <p>
            	<input type="button" value="送出" onclick="home_search('{{url('/train-lookup')}}');" />
            </p>
        </fieldset>
    </form>
@endsection
