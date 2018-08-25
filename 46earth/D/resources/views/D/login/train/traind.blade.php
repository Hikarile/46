@extends('D/start')

@section('title', 'train')
@section('text')

<h1><center>
	此列車還沒有發車你確定要刪除?<p/>
	<input type="button" value="確定" onClick="location.href='{{route('d')}}/2/{{$text['id']}}'">
	<input type="button" value="取消" onClick="location.href='{{route('d')}}/3/{{$text['id']}}'">
</h1></center>
    
@endsection