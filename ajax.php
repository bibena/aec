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
				throw new Exception("Error!: You didn`t send any request or sent it wrong");
				}
			}
		catch (Exception $e)
			{
			die($e->getMessage());
			}
		return json_encode($return);
		}
	function Format($title,$result,$language='en')
		{
		try
			{
			if(is_array($result) && count($result)>0)
				{
				$tlanguage=($language==='en') ? 'ru' : 'en';
				$output='<table class="table table-striped table-hover"><!--<caption><h4>'.$title. '</h4></caption><thead><tr><th><p>Word</p></th><th><p>Translation</p></th><th><p>Mention</p></th></tr></thead>--><tbody>';
				foreach($result as $row)
					{
					$rere[$row[$language]][$row[$tlanguage]][]='level '.$row['course'].', lesson '.$row['lesson'];
					}
				foreach($rere as $lang=>$item_lang)
					{
					$list_of_int=$list_of_lvl='';
					$output.='<tr><td><p>'.$lang.'</p></td><td>';
					foreach($item_lang as $tlang=>$item_tlang)
						{
						$list_of_int.='<p>'.$tlang.'</p>';
						for($i=1;$i<count($item_tlang);$i++)
							{
							$list_of_int.='<p>&nbsp;</p>';
							}
						$list_of_lvl.='<p class="text-muted"><nobr>'.implode('</nobr></p><p class="text-muted"><nobr>',$item_tlang).'</nobr></p>';
						}
					$output.=$list_of_int.'</td><td>'.$list_of_lvl.'</td></tr>';
					}
				$output.='</tbody></table>';
				}
			else
				{
				$output=$title='';
				}
			}
		catch (Exception $e)
			{
			die("Happen something terrible! But we already solving this issue");
			}
		return array('table'=>$output,'title'=>'<h4 class="text-center">'.$title.'</h4>');
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
			die("Error!: Wrong part of word requested");
			}
		if(is_array($result) && count($result)>0)
			{
			foreach($result as $row)
				{
				$return[]=str_replace('0',' ',$row['converted']);
				}
			}
		else
			{
			$return=array();
			}
		return $return;
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
			die("Error!: Wrong word requested");
			}
		$translation=str_replace('0',' ',$translation);
		return $this->Format($translation,$result,$language);
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
			die("Error!: Wrong letter requested");
			}
		return $this->Format('Letter '.$letter,$result,$language);
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
			die("Error!: Wrong level requested");
			}
		return $this->Format('Level '.$course,$result);
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
			die("Error!: Wrong lesson requested");
			}
		return $this->Format('Lesson '.$lesson,$result);
		}
	}
$ajax=new Ajax;
echo $ajax->Execute();
?>