$(function()
{
	if(!isPhone())
	{
		return;
	}
	$('span[data-action=call]').each(function()
	{
		var $ele = $(this);
		$ele.wrap('<a href="tel:' + $ele.data('tel') + '"></a>');
	});
});

function isPhone()
{
	// Edge除外
	if(navigator.userAgent.indexOf('Edge') >= 0)
	{
		return false;
	}
	// AndroidでMobile電話機判定
	if(navigator.userAgent.indexOf('Android') >= 0 && navigator.userAgent.indexOf('Mobile') >= 0)
	{
		return true;
	}
	// iPhone判定
	return(navigator.userAgent.indexOf('iPhone') >= 0);
}
