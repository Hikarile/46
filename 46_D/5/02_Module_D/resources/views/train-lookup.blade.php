@extends('layouts.main')
@section('title','列車查詢')
@section('body','home')
@section('content')
    <p class="message_ok">
        您查詢<b>{{$date}}</b>班次，從<b>{{$from}}</b>到<b>{{$to}}</b>的班次如下
    </p>
    <table class="table_style1">
        <thead>
            <tr>
                <th>車種</th>
                <th>列車編號</th>
                <th>發車/終點站</th>
                <th>開車時間</th>
                <th>到達時間</th>
                <th>行駛時間</th>
                <th>票價</th>
                <th>訂票</th>
            </tr>
        </thead>
        <tbody>
            @foreach($result as $value)
                <tr>
                    @foreach($value as $value2)
                        <td>{!! $value2 !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
