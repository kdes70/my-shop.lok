<?php
 /**
* Кнтроллер
* @author IT studio IRBIS-team
* @copyright © 2011 IRBIS-team
*/
/////////////////////////////////////////////////////////

/**
* Генерация страницы ошибки при доступе вне системы
*/
		if(!defined('IRB_KEY'))
		{
			 header("HTTP/1.1 404 Not Found");
			 exit(file_get_contents('../../404.html'));
		}
//////////////////////////////

	$search = escapeString($GET['id']);
	$search_res = array();
	$info[] = "";


	if(mb_strlen($search, "UTF-8") < 4)
	{
		$info[] = IRB_LANG_SHORT_PHRASE;
	}
	else
	{
		$res = mysqlQuery(" SELECT `id`, `title`, `price`, `image`, `mini_features`, `mini_description`, `new`, `hits`, `sale`
							FROM `". IRB_DBPREFIX ."table_products`
							WHERE MATCH(`title`) AGAINST('".$search."*' IN BOOLEAN MODE) AND `public` = 1
							");
		if(mysqli_num_rows($res) > 0)
		{
			while ($row = mysqli_fetch_assoc($res)) {

				$search_res[] = $row;
				# code...
			}
		}
		else
		{
			$info[] = IRB_LANG_NO_SEARCH;
		}
	}



 include IRB_ROOT . TEMPLATE .'/tpl/search.tpl';
