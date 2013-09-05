<?php
include_once('detectmobilebrowser.php');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/typeahead.min.js"></script>
		<script src="js/diff_match_patch.js"></script>
		<script src="js/aec.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="shortcut icon" href="/aec/favicon.ico" type="image/vnd.microsoft.icon">
		<?php if($is_mobile):?>
		<link rel="stylesheet" href="css/aec-mobile.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>AEC cheat sheet</title>
		<?php else:?>
		<script src="js/aec-laptop.js"></script>
		<link id="css-type" rel="stylesheet" href="css/aec.css" />
		<title>American English Center cheat sheet</title>
		<?php endif;?>
	</head>

	<body>
		<header>
			<div class="hero-unit">
				<h1 class="text-center">AEC vocabulary</h1>
				<p class="text-center">This website is dedicated english-russian translator, based on AEC programm and included full vocabulary.</p>
			</div>		
		</header>
		<section id="main" class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
					<div id="panel"<?php if($is_mobile):?> class="row"<?php endif;?>>
						<div id="searchword"<?php if($is_mobile):?> class="col-xs-4 col-sm-4"<?php endif;?>>
							<h4 class="hidden-xs">I`m looking for the word</h4>
							<h4 class="visible-xs">I wanna find the word</h4>
							<input autofocus="autofocus" autocomplete="off" tabindex="1" class="inputword form-control" id="inputword" placeholder="Start typing a word" type="text">
						</div>
						<div id="lol"<?php if($is_mobile):?> class="col-xs-4 col-sm-4"<?php endif;?>>
							<h4>In level or lesson</h4>
							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#levels">
								Level <span class="caret"></span>
								</a>
								<div class="dropdown-menu" id="level">
									<ul>
										<?php for($i=1;$i<=6;$i++):?>
											<li><a class="btn btn-primary btn-mini" href="#<?=$i?>"><?=$i?></a></li>
										<?php endfor;?>
									</ul>
								</div>
							</div>
							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#lessons">
								Lesson <span class="caret"></span>
								</a>
								<div class="dropdown-menu" id="lesson">
									<div>
										<p class="text-center">Choose the level first</p>
										<ul>
											<?php for($i=1;$i<=6;$i++):?>
												<li><a class="btn btn-primary btn-mini" href="#<?=$i?>"><?=$i?></a></li>
											<?php endfor;?>
										</ul>
									</div>
									<?php for($j=1;$j<=6;$j++):?>
										<div id="level<?=$j?>">
											<p class="text-center">Choose the lesson</p>
											<ul>
												<?php for($i=(($j-1)*14+1);$i<=($j*14);$i++):?>
													<?php if($i%14==0 || (in_array($j,array(3,4,5)) && $i%7==0)):?>
														<li><a class="btn btn-primary btn-mini disabled"><?=$i?></a></li>
													<?php continue; endif;?>
													<li><a class="btn btn-primary btn-mini" href="#<?=$i?>"><?=$i?></a></li>
												<?php endfor;?>
											</ul>
										</div>
									<?php endfor;?>
								</div>
							</div>
						</div>

						<div id="alphabet"<?php if($is_mobile):?> class="col-xs-4 col-sm-4"<?php endif;?>>
							<h4>In alphabet</h4>
							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#english">
								English <span class="caret"></span>
								</a>
								<div class="dropdown-menu" id="englishalphabet">
									<ul>
										<?php for($i=97;$i<=122;$i++):?>
											<li><a class="btn btn-primary btn-mini" href="#<?=chr($i)?>"><?=chr($i)?></a></li>
										<?php endfor;?>
									</ul>
								</div>
							</div>
							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#russian">
								Russian <span class="caret"></span>
								</a>
								<div class="dropdown-menu" id="russianalphabet">
									<ul>
										<?php for($i=208;$i<=239;$i++):?>
											<li><a class="btn btn-primary btn-mini" href="#<?=iconv('ISO-8859-5', 'UTF-8', chr($i))?>"><?=iconv('ISO-8859-5', 'UTF-8', chr($i))?></a></li>
											<?php if($i===213):?>
												<li><a class="btn btn-primary btn-mini disabled"><?=iconv('ISO-8859-5', 'UTF-8', chr(241))?></a></li>
											<?php endif;?>
										<?php endfor;?>
									</ul>
								</div>
							</div>
						</div>
						<div id="title"></div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="content">
					<div id="answer">
						<div id="description">
							<p><h3>How to use:</h3></p>
							<p>To translate some word start typing this word in the text field.</p>
							<p>To display all words from some level or lesson press the corresponding button.</p>
							<p>To display all words wich start with some letter choose the language and the letter.</p>
							<p>Good luck!</p>
						</div>
					</div>
				</div>
			</div>
			<div id="distance"></div>
		</section>

		<footer class="footer">
			<p>Created by <a href="mailto:admin@bibena.myftp.org">Bibena</a>.</p>
			<p>Code licensed under 
				<noindex><a rel="nofollow" target="_blank" href="http://apache.org/licenses/LICENSE-2.0">Apache License v2.0</a></noindex>.
			</p>
			<p>In development were used: 
				<noindex><a rel="nofollow" target="_blank" href="http://php.net">PHP</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://jquery.com">jQuery</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://www.w3.org/TR/html51">HTML</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" target="_blank" href="http://twitter.github.io/bootstrap">Bootstrap</a></noindex>.
			</p>
			<p>Host and software provided by: 
				<noindex><a rel="nofollow" target="_blank" href="http://zyxel.ru/keenetic-giga">Zyxel Keenetic Giga</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://forum.zyxmon.org/forum6-marshrutizatory-zyxel-keenetic.html">Zyxmon forum</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://noip.com/">No-IP</a></noindex>.
			</p>
		</footer>	
	</body>
</html>