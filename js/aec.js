function format(result,language)
	{	
	if(result instanceof Array && result.length>0)
		{
		if(typeof language ==='undefined')
			{
			var language='en';
			}
		var tlanguage=language==='en' ? 'ru' : 'en';
		var output='<table class="table table-striped table-hover"><tbody>';
		var row2obj=new Object();
		result.forEach(function(row)
			{
			if(typeof row2obj[row[language]] === 'undefined')
				{
				row2obj[row[language]]=new Object();
				}
			if(typeof row2obj[row[language]][row[tlanguage]] === 'undefined')
				{
				row2obj[row[language]][row[tlanguage]]=new Array();
				}
			row2obj[row[language]][row[tlanguage]].push('level '+row.level+', lesson '+row.lesson);
			});
		for(word in row2obj)
			{
			var list_of_int=list_of_lvl='';
			output+='<tr><td><p>'+word+'</p></td><td>';
			for(translation in row2obj[word])
				{
				list_of_int+='<p>'+translation+'</p>';
				for(i=1;i<row2obj[word][translation].length;i++)
					{
					list_of_int+='<p>&nbsp;</p>';
					}
				list_of_lvl+='<p class="text-muted"><nobr>'+row2obj[word][translation].join('</nobr></p><p class="text-muted"><nobr>')+'</nobr></p>';
				}
			output+=list_of_int+'</td><td>'+list_of_lvl+'</td></tr>';
			}
		output+='</tbody></table>';
		}
	else
		{
		output='';
		}
	return output;
	}

$(function()
	{
	$inputword=$('#inputword');
	$inputword.typeahead({
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
						function (answer)
							{
							if(typeof answer.data==='object')
								{
								if(answer.type!== undefined && answer.type==='levinstein')
									{
									setTimeout(function()
										{
										$typeahead=$('.typeahead');
										difference=new diff_match_patch;
										for(i=0;i<$typeahead.children().length;i++)
											{
											var markstring='';
											difference.diff_main($inputword.val(),$(".typeahead li:eq("+i+") a").text()).forEach(function(element)
												{
												var rawstring=element.toString().split(',');
												switch(rawstring[0])
													{
													case '0':
														markstring+=rawstring[1];
														break;
													case '1':
														markstring+='<span class="text-danger">'+rawstring[1]+'</span>';
														break;
													default:
														break;
													}
												$(".typeahead li:eq("+i+") a").html(markstring);
												});
											};
										$typeahead.prepend('<div id="ops"><p class="text-center text-danger">Ops! Did you mean:</p></div>');
										},1);
									}
								return process(answer.data);
								}
							},
						'json'
						);
			},
		matcher: function(){return true},
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
					function(answer)
						{
						$('#answer').html(format(answer,language));
						$('#title').css('display','block').html('<h4 class="text-center">'+item+'</h4>');
						},
					'json'
					)
			return item;
			}
		});

	$('#level a').bind('click',function()
		{
		$('#level').parent().removeClass('open');
		var level=$(this).text();
		$.post( 'ajax.php',
				{'level':level},
				function(answer)
					{
					$('#answer').html(format(answer));
					$('#title').css('display','block').html('<h4 class="text-center">Level '+level+'</h4>');
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
			$('#level'+i).hide();
			}
		});

	$('#lesson div:first-child a').bind('click',function()
		{
		$('#lesson div:first-child').css('display','none');
		for(var i=1;i<=$("#lesson div:first-child ul > li").length;i++)
			{
			$('#level'+i).hide();
			}
		$('#level'+$(this).text()).show();
		return false;
		});

	$('#level1 a,#level2 a,#level3 a,#level4 a,#level5 a,#level6 a').bind('click',function()
		{
		$('#lesson').parent().removeClass('open');
		if(!$(this).hasClass('disabled'))
			{
			var lesson=$(this).text();
			$.post( 'ajax.php',
					{'lesson':lesson},
					function(answer)
						{
						$('#answer').html(format(answer));
						$('#title').css('display','block').html('<h4 class="text-center">Lesson '+lesson+'</h4>');
						},
					'json'
					)
			}
		return false;
		});

	$('#englishalphabet a').bind('click',function()
		{
		$('#englishalphabet').parent().removeClass('open');
		var letter=$(this).text();
		$.post( 'ajax.php',
				{'letter':letter,'language':'en'},
				function(answer)
					{
					$('#answer').html(format(answer));
					$('#title').css('display','block').html('<h4 class="text-center">Letter '+letter+'</h4>');
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
			var letter=$(this).text();
			$.post( 'ajax.php',
					{'letter':letter,'language':'ru'},
					function(answer)
						{
						$('#answer').html(format(answer,'ru'));
						$('#title').css('display','block').html('<h4 class="text-center">Буква '+letter+'</h4>');
						},
					'json'
					);
			}
		return false;
		});
	})