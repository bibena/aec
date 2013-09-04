function wts()
	{
	if($(window).width() >= 976)
		{
		$('#panel').affix({offset: {top: 165}});
		if($('#panel').hasClass("affix-force-top"))
			{
			$('#panel').removeClass("affix-force-top");
			}
		if($('#panel').hasClass("row"))
			{
			$('#panel').removeClass("row");
			$('#searchword').removeClass("col-xs-4 col-sm-4");
			$('#lol').removeClass("col-xs-4 col-sm-4");
			$('#alphabet').removeClass("col-xs-4 col-sm-4");
			}
		if($("#css-type").attr("href")!='css/aec.css')
			{
			$("#css-type").attr("href", "css/aec.css");
			}
		}
	else
		{
		if(!$('#panel').hasClass("row"))
			{
			$('#panel').addClass("row");
			$('#searchword').addClass("col-xs-4 col-sm-4");
			$('#lol').addClass("col-xs-4 col-sm-4");
			$('#alphabet').addClass("col-xs-4 col-sm-4");
			}
		if(!$('#panel').hasClass("affix-force-top"))
			{
			$('#panel').addClass("affix-force-top");
			}
		if($("#css-type").attr("href")!='css/aec-mobile.css')
			{
			$("#css-type").attr("href", "css/aec-mobile.css");
			}
		}
	}
$(window).resize(wts);
$(wts);