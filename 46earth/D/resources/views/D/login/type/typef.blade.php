@extends('D\start')

@section('title', 'type')
@section('text')
	<script src="{{asset('./media/js/jquery.min.js')}}"></script>
    <script>
    	$(function(){
			$("#sub").submit(function(){
				if($("#type").val()==''){
					alert('車種名稱未填');
					return false;
				}
				if($("#car").val()==''){
					alert('車廂數量未填');
					return false;
				}
				if($("#singlecar").val()==''){
					alert('單一車廂未填量');
					return false;
				}
				if($("#total").val()==''){
					alert('乘載量未填');
					return false;
				}
			})
		})
    </script>
	
	<p>&nbsp;</p>
	<input type="button" value="返回" onClick="location.href='{{route('type')}}'">
	
	<form method="post" action="{{route('typesave')}}" id="sub">
		<fieldset>
			<legend>修改車種</legend><p/>
            車種名稱:<input id="type" type="text" name="type" value="{{$post->type}}"><p/>
            車廂數量:<input id="car" type="number" name="car" value="{{$post->car}}"><p/>
            單一車廂量:<input id="singlecar" type="number" name="singlecar" value="{{$post->singlecar}}"><p/>
            <input type="hidden" name="id" value="{{$post->id}}">
			<input type="hidden" name="aaa" value="2">
            {{ csrf_field()}}
            <input type="submit" value="確定">
		</fieldset>
	</form>
	
@endsection