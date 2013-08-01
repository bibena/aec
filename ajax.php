<?php
class Ajax
	{
	function __construct()
		{
		try
			{
			include_once('setting');
			if($_SERVER["HTTP_REFERER"]===$config['url'])
				{
				try
					{
					$this->dbh = new PDO('mysql:host='.$config['dbhost'].';dbname='.$config['dbname'],$config['dbuser'],$config['dbpass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					}
				catch (PDOException $e)
					{
					die("Error!: ".$e->getMessage());
					}
				}
			else
				{
				throw new Exception("Error!: You try to load information from the other site");
				}
			}
		catch (Exception $e)
			{
			die($e->getMessage());
			}
		}
	function Execute()
		{
		try
			{
			if(isset($_POST['language']) && is_string($_POST['language']) && in_array($_POST['language'],array('en','ru')))
				{
				if(isset($_POST['word']) && is_string($_POST['word']) && strlen($_POST['word'])>=2)
					{
					$return=$this->Word($_POST['word'],$_POST['language']);
					}
				elseif(isset($_POST['translation']) && is_string($_POST['translation']) && strlen($_POST['translation'])>=2)
					{
					$return=$this->Translation($_POST['translation'],$_POST['language']);
					}
				elseif(isset($_POST['letter']) && is_string($_POST['letter']) && (($_POST['language']==='ru' && strlen($_POST['letter'])===2) || ($_POST['language']==='en' && strlen($_POST['letter'])===1)))
					{
					$return=$this->Letter($_POST['letter'],$_POST['language']);
					}
				else
					{
					throw new Exception("Error!: You didn`t send any request or sent it wrong");
					}
				}
			elseif(isset($_POST['course']) && is_numeric($_POST['course']))
				{
				$return=$this->Course($_POST['course']);
				}
			elseif(isset($_POST['lesson']) && is_numeric($_POST['lesson']))
				{
				$return=$this->Lesson($_POST['lesson']);
				}
			else
				{
				throw new Exception("Error!: You didn`t send any request or sent it wrong way");
				}
			}
		catch (Exception $e)
			{
			die($e->getMessage());
			}
		return $return;
		}
	function Word($word,$language)
		{
		try
			{
			$word=str_replace(' ','0',$word);
			$sql="SELECT DISTINCT SQL_CALC_FOUND_ROWS `converted` FROM `$language` WHERE MATCH(`converted`) AGAINST(:word IN BOOLEAN MODE) ORDER BY `converted` LIMIT 10;";
			$prepare=$this->dbh->prepare($sql);
			$prepare->execute(array(':word'=>$word.'*'));
			$result=$prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		catch (PDOException $e)
			{
			die("Error!: ".$e->getMessage());
			}
		$return=array();
		if(is_array($result) && count($result)>0)
			{
			foreach($result as $row)
				{
				$return[]=str_replace('0',' ',$row['converted']);
				}
			}
		return json_encode($return);
		}
	function Translation($translation,$language)
		{
		try
			{
			$translation=str_replace(' ','0',$translation);
			$sql="SELECT `en`.`original` AS `en`,`ru`.`original` AS `ru`,`en_ru`.`course`,`en_ru`.`lesson` from `en_ru`,`ru`,`en` where `en_ru`.`en`=`en`.`id` and `en_ru`.`ru`=`ru`.`id` and `$language`.`converted`=:translation ORDER BY `$language`.`converted`;";
			$prepare=$this->dbh->prepare($sql);
			$prepare->execute(array(':translation'=>$translation));
			$result=$prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		catch (PDOException $e)
			{
			die("Error!: ".$e->getMessage());
			}
		$output='';
		if(is_array($result) && count($result)>0)
			{
			$tlanguage=($language==='en') ? 'ru' : 'en';
			$output.='<table class="table table-striped table-hover"><caption><h4>'.$translation.'</h4></caption><thead><tr><th>Word</th><th>Translation</th><th>Mention</th></tr></thead><tbody>';
			if(count($result)==1)
				{
				$output.='<tr><td>'.$result[0][$language].'</td><td>'.$result[0][$tlanguage].'</td><td><span class="muted">level '.$result[0]['course'].', lesson '.$result[0]['lesson'].'</span></td></tr>';
				}
			else
				{
				foreach($result as $row)
					{
					$rere[$row[$language]][$row[$tlanguage]][]='level '.$row['course'].', lesson '.$row['lesson'];
					}
				foreach($rere as $lang=>$item_lang)
					{
					$list_of_int=$list_of_lvl='';
					$output.='<tr><td>'.$lang.'</td><td>';
					foreach($item_lang as $tlang=>$item_tlang)
						{
						$list_of_int.='<p>'.$tlang.'</p>';
						for($i=1;$i<count($item_tlang);$i++)
							{
							$list_of_int.='<p>&nbsp;</p>';
							}
						$list_of_lvl.='<p class="muted">'.implode('</p><p class="muted">',$item_tlang).'</p>';
						}
					$output.=$list_of_int.'</td><td>'.$list_of_lvl.'</td></tr>';
					}
				}
			$output.='</tbody></table>';
			}
		return $output;
		}
	function Letter($letter,$language)
		{
		try
			{
			$sql="SELECT `en`.`original` AS `en`,`ru`.`original` AS `ru`,`en_ru`.`course`,`en_ru`.`lesson` from `en_ru`,`ru`,`en` where `en_ru`.`en`=`en`.`id` and `en_ru`.`ru`=`ru`.`id` and `$language`.`first_letter`=:letter ORDER BY `$language`.`converted`;";
			$prepare=$this->dbh->prepare($sql);
			$prepare->execute(array(':letter'=>$letter));
			$result=$prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		catch (PDOException $e)
			{
			die("Error!: ".$e->getMessage());
			}
		if(is_array($result) && count($result)>0)
			{
			$tlanguage=($language==='en') ? 'ru' : 'en';
			$output='<table class="table table-striped table-hover"><caption><h4>Letter '.$letter.'</h4></caption><thead><tr><th>Word</th><th>Translation</th><th>Mention</th></tr></thead><tbody>';
			foreach($result as $row)
				{
				$rere[$row[$language]][$row[$tlanguage]][]='level '.$row['course'].', lesson '.$row['lesson'];
				}
			foreach($rere as $lang=>$item_lang)
				{
				$list_of_int=$list_of_lvl='';
				$output.='<tr><td>'.$lang.'</td><td>';
				foreach($item_lang as $tlang=>$item_tlang)
					{
					$list_of_int.='<p>'.$tlang.'</p>';
					for($i=1;$i<count($item_tlang);$i++)
						{
						$list_of_int.='<p>&nbsp;</p>';
						}
					$list_of_lvl.='<p class="muted"><nobr>'.implode('</nobr></p><p class="muted"><nobr>',$item_tlang).'</nobr></p>';
					}
				$output.=$list_of_int.'</td><td>'.$list_of_lvl.'</td></tr>';
				}
			$output.='</tbody></table>';
			}
		return $output;
		}
	function Course($course)
		{
		try
			{
			$sql="SELECT `en`.`original` AS `en`,`ru`.`original` AS `ru`,`en_ru`.`course`,`en_ru`.`lesson` from `en_ru`,`ru`,`en` where `en_ru`.`en`=`en`.`id` and `en_ru`.`ru`=`ru`.`id` and `en_ru`.`course`=:course ORDER BY `en`.`converted`;";
			$prepare=$this->dbh->prepare($sql);
			$prepare->execute(array(':course'=>$course));
			$result=$prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		catch (PDOException $e)
			{
			die("Error!: ".$e->getMessage());
			}
		if(is_array($result) && count($result)>0)
			{
			$output='<table class="table table-striped table-hover"><caption><h4>Level '.$course.'</h4></caption><thead><tr><th>Word</th><th>Translation</th><th>Mention</th></tr></thead><tbody>';
			foreach($result as $row)
				{
				$rere[$row['en']][$row['ru']][]='level '.$row['course'].', lesson '.$row['lesson'];
				}
			foreach($rere as $lang=>$item_lang)
				{
				$list_of_int=$list_of_lvl='';
				$output.='<tr><td>'.$lang.'</td><td>';
				foreach($item_lang as $tlang=>$item_tlang)
					{
					$list_of_int.='<p>'.$tlang.'</p>';
					for($i=1;$i<count($item_tlang);$i++)
						{
						$list_of_int.='<p>&nbsp;</p>';
						}
					$list_of_lvl.='<p class="muted"><nobr>'.implode('</nobr></p><p class="muted"><nobr>',$item_tlang).'</nobr></p>';
					}
				$output.=$list_of_int.'</td><td>'.$list_of_lvl.'</td></tr>';
				}
			$output.='</tbody></table>';
			}
		return $output;
		}
	function Lesson($lesson)
		{
		try
			{
			$sql="SELECT `en`.`original` AS `en`,`ru`.`original` AS `ru`,`en_ru`.`course`,`en_ru`.`lesson` from `en_ru`,`ru`,`en` where `en_ru`.`en`=`en`.`id` and `en_ru`.`ru`=`ru`.`id` and `en_ru`.`lesson`=:lesson ORDER BY `en`.`converted`;";
			$prepare=$this->dbh->prepare($sql);
			$prepare->execute(array(':lesson'=>$lesson));
			$result=$prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		catch (PDOException $e)
			{
			die("Error!: ".$e->getMessage());
			}
		if(is_array($result) && count($result)>0)
			{
			$output='<table class="table table-striped table-hover"><caption><h4>Lesson '.$lesson.'</h4></caption><thead><tr><th>Word</th><th>Translation</th><th>Mention</th></tr></thead><tbody>';
			foreach($result as $row)
				{
				$rere[$row['en']][$row['ru']][]='level '.$row['course'].', lesson '.$row['lesson'];
				}
			foreach($rere as $lang=>$item_lang)
				{
				$list_of_int=$list_of_lvl='';
				$output.='<tr><td>'.$lang.'</td><td>';
				foreach($item_lang as $tlang=>$item_tlang)
					{
					$list_of_int.='<p>'.$tlang.'</p>';
					for($i=1;$i<count($item_tlang);$i++)
						{
						$list_of_int.='<p>&nbsp;</p>';
						}
					$list_of_lvl.='<p class="muted"><nobr>'.implode('</nobr></p><p class="muted"><nobr>',$item_tlang).'</nobr></p>';
					}
				$output.=$list_of_int.'</td><td>'.$list_of_lvl.'</td></tr>';
				}
			$output.='</tbody></table>';
			}
		return $output;
		}
	}
$ajax=new Ajax;
echo $ajax->Execute();
?>