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
function home_search(url){
	var date = $('#date').val();
	var from = $('#from').val();
	var to = $('#to').val();
	var type = $('#type').val();
	
	if(from == to){ alert('起程站不可與到達站相同');return; }
	
	location.href = url + '/' + date + '/' + from + '/' + to + '/' + type;
}