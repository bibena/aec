$('#inputword').typeahead(
	{
	source: function (query, process) 
		{
		if(query.match(/^[A-Za-z\W]+$/))
			{
			var language='en';
			}
		if(query.match(/^[А-ЯЁа-яё\W]+$/))
			{
			var language='ru';
			}
		return $.post('ajax.php', 
					{'word':query,'language':language},
					function (data)
						{
						return process(data);
						},
					'json'
					);
		},
	items: 10,
	minLength: 2,
	updater: function (item)
		{
		if(item.match(/^[A-Za-z `\(\)]+.*$/))
			{
			var language='en';
			}
		if(item.match(/^[А-ЯЁа-яё \(\)]+.*$/))
			{
			var language='ru';
			}
		$('#answer').load('ajax.php',
						{'language':language,'translation':item});
		return item;
		}
	});

$('#course a').bind('click',function()
	{
	$('#course').parent().removeClass('open');
	$('#answer').load('ajax.php',
					{'course':$(this).text()});
	return false;
	});

$('#lesson').prev().bind('click',function()
	{
	$('#lesson div:first-child').css('display','block');
	for(var i=1;i<=$("#lesson div:first-child ul > li").length;i++)
		{
		$('#course'+i).hide();
		}
	});

$('#lesson div:first-child a').bind('click',function()
	{
	$('#lesson div:first-child').css('display','none');
	for(var i=1;i<=$("#lesson div:first-child ul > li").length;i++)
		{
		$('#course'+i).hide();
		}
	$('#course'+$(this).text()).show();
	return false;
	});

$('#course1 a,#course2 a,#course3 a,#course4 a,#course5 a,#course6 a').bind('click',function()
	{
	$('#lesson').parent().removeClass('open');
	if(!$(this).hasClass('disabled'))
		{
		$('#answer').load('ajax.php',
						{'lesson':$(this).text()});
		}
	return false;
	});

$('#englishalphabet a').bind('click',function()
	{
	$('#englishalphabet').parent().removeClass('open');
	$('#answer').load('ajax.php',
					{'letter':$(this).text(),'language':'en'});
	return false;
	});

$('#russianalphabet a').bind('click',function()
	{
	$('#russianalphabet').parent().removeClass('open');
	if(!$(this).hasClass('disabled'))
		{
		$('#answer').load('ajax.php',
					{'letter':$(this).text(),'language':'ru'});
		}
	return false;
	});