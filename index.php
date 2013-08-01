<!DOCTYPE html>
<html lang="ru">

	<head>
		<meta charset="utf-8">
		<!--<link rel="shortcut icon" href="" />-->
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" href="css/aec.css" />
		<title>American English Center cheat sheet</title>
	</head>

	<body>
		<section id="main">
			<div class="hero-unit">
				<h1>Hello, world!</h1>
				<p>This website is dedicated english-russian translator, based on AEC programm. It`s included full vocabulary.</p>
			</div>
			<div class="container">

				<div class="row">
					<div class="span3" id="panel">
						<div class="control-group" id="searchword">
							<h4 class="visible-desktop">I`m looking for the word</h4>
							<h4 class="hidden-desktop">I`m looking for...<br>Just the word</h4>
							<input autofocus="autofocus" autocomplete="off" tabindex="1" id="inputword" placeholder="Start typing a word" type="text" >
						</div>

						<div id="loc">
							<h4>In course or lesson</h4>
							<div class="btn-group">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#courses">
								Course <span class="visible-desktop caret"></span>
								</a>
								<div class="dropdown-menu" id="course">
									<ul>
										<?php for($i=1;$i<=6;$i++):?>
											<li><a class="btn btn-primary btn-mini" href="#<?=$i?>"><?=$i?></a></li>
										<?php endfor;?>
									</ul>
								</div>
							</div>
							<div class="btn-group">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#lessons">
								Lesson <span class="caret visible-desktop"></span>
								</a>
								<div class="dropdown-menu" id="lesson">
									<div>
										<p class="text-center">Choose the course first</p>
										<ul>
											<?php for($i=1;$i<=6;$i++):?>
												<li><a class="btn btn-primary btn-mini" href="#<?=$i?>"><?=$i?></a></li>
											<?php endfor;?>
										</ul>
									</div>
									<?php for($j=1;$j<=6;$j++):?>
										<div id="course<?=$j?>">
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

						<div id="alphabet">
							<h4>In alphabet</h4>
							<div class="btn-group">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#english">
								English <span class="visible-desktop caret"></span>
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
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#russian">
								Russian <span class="visible-desktop caret"></span>
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
					</div>
					<div class="span9" id="content">
						<div id="answer"></div>
					</div>
				</div>
			</div>	
			<script src="js/aec.js"></script>
			<div id="distance"></div>
		</section>
			
		<footer class="footer">
			<div id="footer">
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
			</div>
		</footer>	
	</body>
</html>