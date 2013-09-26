<?php
$is_mobile=false;
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4)))
	{
	$is_mobile=true;
	}
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
		<link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
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
				<p class="text-center">This website is dedicated english-russian translator, based on AEC program</p>
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
			<p>Created by <a href="mailto:admin@bibena.com">Bibena</a>.</p>
			<p>Code licensed under 
				<noindex><a rel="nofollow" target="_blank" href="http://apache.org/licenses/LICENSE-2.0">Apache License v2.0</a></noindex>.
			</p>
			<p>In development were used: 
				<noindex><a rel="nofollow" target="_blank" href="http://php.net">PHP</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://jquery.com">jQuery</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://www.w3.org/TR/html51">HTML</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" target="_blank" href="http://getbootstrap.com">Bootstrap</a></noindex>.
			</p>
			<p>Host and software provided by: 
				<noindex><a rel="nofollow" target="_blank" href="http://zyxel.ru/keenetic-giga">Zyxel Keenetic Giga</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://forum.zyxmon.org/forum6-marshrutizatory-zyxel-keenetic.html">Zyxmon forum</a></noindex>, 
				<noindex><a rel="nofollow" target="_blank" href="http://noip.com">No-IP</a></noindex>.
			</p>
		</footer>	
	</body>
</html>