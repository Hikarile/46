function toggleRatingForm ()
{
	var formelement = document.getElementById('ratingform');
	var switchelement = document.getElementById('ratingswitch');
	if (formelement.style.visibility == 'collapse')
	{
		switchelement.style.visibility = 'collapse';
		switchelement.style.height = '0px';
		formelement.style.visibility = 'visible';
		formelement.style.height = '170px';
	}
	/* captcha image: replace path to empty captcha (set by default in html) with path to dynamically generated captcha - modify path here */
	document.getElementById('captcha_image').src = '../captcha.gif';
}
$(function(){
	$('body.home #train_search_btn').click(function(){
		var from = $('body.home #from').val();
		var to = $('body.home #to').val();
		var type = $('body.home #type').val();
		var date = $('body.home #date').val();
		if(from == to){ alert('起點與終點相同'); return; }
		location.href = 'train-lookup/' + date + '/' + from + '/' + to + '/' + type;
	})
})

