<?php

/**
* The main router
* Главный маршрутизатор (роутер)
* @author IT studio IRBIS-team
* @copyright © 2011 IRBIS-team
*/
/////////////////////////////////////////////////////////

/**
* Устанавливаем кодировку и уровень ошибок
*/
	header("Content-Type: text/html; charset=utf-8");
	error_reporting(E_ALL);
	session_start();
	ob_start();
	$start = microtime(true);
/**
* Debug
* Дебаггер
* @TODO To clean in release
*/
	define('IRB_TRACE', true);
	include './debug.php';

/**
* Устанавливаем ключ-константу
*/
	define('IRB_KEY', true);

/**
* Подключаем файлы ядра
*/
	include './config.php';
	include IRB_ROOT .'/variables.php';
	include IRB_ROOT .'/language/ru.php';
	include IRB_ROOT .'/libs/mysql.php';
	include IRB_ROOT .'/libs/default.php';
	include IRB_ROOT .'/libs/view.php';

// Автолгин
	if(!empty($_COOKIE['hash']) && empty($_SESSION['userdata']))
	{
		if(($userdata = look::autologin($_COOKIE['hash'])) !== false)
			$_SESSION['userdata'] = $userdata;
	}
   
//Авторизация
	if($auth)
	{
		include IRB_ROOT .'/components/registration/router.php';
		if(isset($_SESSION['userdata']['id'])){
				//Если авторизация прошла успешно
				exit;
			}else{
				//Или если не удачно
				exit;
			}
	}
	if ($remind) {
		include IRB_ROOT .'/components/registration/router.php';
		if(isset($POST['value4'])){
			exit;
		}
		else{
			exit;
		}
	}

//unset($_SESSION);


/**
* Переключатель страниц
*/
	switch($GET['page'])
	{
		case 'shop' :
			include IRB_ROOT .'/controllers/category_controller.php';
			//include IRB_ROOT .'/controllers/option_controller.php';
			include IRB_ROOT .'/controllers/shop_controller.php';



		break;

		case 'category' :
		   // include IRB_ROOT .'/controllers/category_controller.php';
		break;
		case 'cart' :
			include IRB_ROOT .'/controllers/category_controller.php';
		    include IRB_ROOT .'/controllers/cart_controller.php';

		break;
		//Поиск по фильтру
		case 'filter' :
			include IRB_ROOT .'/controllers/category_controller.php';
		   // include IRB_ROOT .'/components/filter/filter_controller.php';
		    include IRB_ROOT .'/controllers/shop_controller.php';
		break;

		case 'search' :
			include IRB_ROOT .'/controllers/category_controller.php';
			include IRB_ROOT .'/controllers/search_controller.php';
		break;

		case 'blog' :
		   // include IRB_ROOT .'/controllers/blog_controller.php';
		break;

		case 'registration' :

			include IRB_ROOT .'/components/registration/router.php';
			if($ok )
			{
				//reDirect('page=show');
				exit;
			}
			//include IRB_ROOT .'/controllers/category_controller.php';
		break;

		case 'ban' :
			include IRB_ROOT .'/skins/tpl/ban.tpl';
		break;

		default :
			//include IRB_ROOT .'/controllers/option_controller.php';
			include IRB_ROOT .'/controllers/category_controller.php';
			include IRB_ROOT .'/controllers/shop_controller.php';


			//include IRB_ROOT .'/controllers/blog_controller.php';
		break;
	}

	$title       = getMeta('title', $GET['page']);
	$keywords    = getMeta('keywords', $GET['page']);
	$description = getMeta('description', $GET['page']);

	$content = ob_get_clean();
/**
* Подключаем главный шаблон
*/
	include IRB_ROOT . TEMPLATE . 'tpl/index.tpl';


echo '<br /><br /><br />';
echo 'Время генерации страницы: '. sprintf("%01.4f", microtime(true) - $start) .'<br />';
echo 'Количество подключённых файлов: '. count(get_included_files()) .'<br />';
echo 'Количество запросов: '. DB::$count .'<br />';







