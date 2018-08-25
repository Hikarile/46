@extends("D/start")

@section('title', 'login')
@section('text')
    
	@if(session('error'))
	<p class="message_error">
		{{session('error')}}
	</p>
	@endif
	
	<p>&nbsp;&nbsp;<p/>
	
	<form method="post" action="{{route('dnlu')}}">
		<fieldset>
			<p>
				<label for="ac">帳號:</label>
				<input type="text" name="ac" id="ac" value="{{old('ac')}}">
				<span class="message"></span>
			</p>
			<p>
				<label for="ps">密碼:</label>
				<input type="password" name="ps" id="ps">
				<span class="message"></span>
			</p>
			<p>
				{{ csrf_field()}}
				<input type="submit" name="ok" value="登入">
			</p>
		</fieldset>
	</form>
	
@endsection