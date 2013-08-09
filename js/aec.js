$(function()
	{
	if(!$.browser.mobile)
		{
		$('#panel').affix(
			{
			offset: {top: 165}
			});
		}
	
	$('#inputword').typeahead(
		{
		source: function (query, process) 
			{
			if(query.match(/^[A-Za-z\s\`-]+$/))
				{
				var language='en';
				}
			if(query.match(/^[А-ЯЁа-яё\s-]+$/))
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
		minLength: 2,
		updater: function (item)
			{
			if(item.match(/^[-A-Za-z\s\`\(\)]+.$/))
				{
				var language='en';
				}
			if(item.match(/^[-А-ЯЁа-яё\s\(\)]+.*$/))
				{
				var language='ru';
				}
			$.post( 'ajax.php',
					{'language':language,'translation':item},
					function(data)
						{
						$('#answer').html(data.table);
						$('#title').css('display','block');
						$('#title').html(data.title);
						},
					'json'
					)
			return item;
			}
		});
	$('#course a').bind('click',function()
		{
		$('#course').parent().removeClass('open');
		$.post( 'ajax.php',
				{'course':$(this).text()},
				function(data)
					{
					$('#answer').html(data.table);
					$('#title').css('display','block');
					$('#title').html(data.title);
					},
				'json'
				)
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
			$.post( 'ajax.php',
					{'lesson':$(this).text()},
					function(data)
						{
						$('#answer').html(data.table);
						$('#title').css('display','block');
						$('#title').html(data.title);
						},
					'json'
					)
			}
		return false;
		});

	$('#englishalphabet a').bind('click',function()
		{
		$('#englishalphabet').parent().removeClass('open');
		$.post( 'ajax.php',
				{'letter':$(this).text(),'language':'en'},
				function(data)
					{
					$('#answer').html(data.table);
					$('#title').css('display','block');
					$('#title').html(data.title);
					},
				'json'
				);
		return false;
		});

	$('#russianalphabet a').bind('click',function()
		{
		$('#russianalphabet').parent().removeClass('open');
		if(!$(this).hasClass('disabled'))
			{
			$.post( 'ajax.php',
					{'letter':$(this).text(),'language':'ru'},
					function(data)
						{
						$('#answer').html(data.table);
						$('#title').css('display','block');
						$('#title').html(data.title);
						},
					'json'
					);
			}
		return false;
		});
	})