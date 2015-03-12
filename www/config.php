<?php

/**
* Configuration file
* Конфигурационный файл
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
	   exit(file_get_contents('./404.html'));
	}

///////////////////////////////////////////////////////////////
//                THE GENERAL OPTIONS
//                  ОбЩИЕ НАСТРОЙКИ
///////////////////////////////////////////////////////////////


	$admins = array(
					  'root'   => 'root', // Изменить в релизе
					  'admin'  => '12345',
					);

/**
* E-mail техподдержки
*/
	define('IRB_SUPPORT_EMAIL', 'no-replay@irbis-team.com');
/**
* Включает модуль перенаправления
*/
	define('IRB_REWRITE', 'on');
/**
* Активация аккаунта по письму
*/
   define('IRB_REGISTRATION_ACTIVATE', 'off');

/**
* Количество рядов в постраничном режиме
*/
	define('IRB_CONFIG_NUM_ROWS', 10);
/**
* Количество слов в анонсе
*/
	define('IRB_CONFIG_NUM_WORDS', 100);


/**
* Количество символов в пароле
*/
	define('LENGTH_PASS', 8);

///////////////////////////////////////////////////////////////
//                OPTIONS OF CONNECTION WITH A DB
//                  НАСТРОЙКИ СОЕДИНЕНИЯ С БД
///////////////////////////////////////////////////////////////

/**
* Префикс таблиц БД.
* Сервер БД.
* Пользователь БД
* Пароль БД
* Название базы
*/
	define('IRB_DBPREFIX', 'irbis_');
	define('IRB_DBSERVER', 'localhost');
	define('IRB_DBUSER', 'root');
	define('IRB_DBPASSWORD', '');
	define('IRB_DATABASE', 'shop_db');


///////////////////////////////////////////////////////////////
//                  СИСТЕМНЫЕ НАСТРОЙКИ
///////////////////////////////////////////////////////////////
/**
* Устанавливает физический путь до корневой директории скрипта
*/
	define('IRB_ROOT', str_replace('\\', '/', dirname(__FILE__)));

/**
* Устанавливает путь до корневой директории скрипта
* по протоколу HTTP
*/
	define('IRB_HOST', 'http://'. $_SERVER['HTTP_HOST'] .'/');

 /**
 * Устанавливаем путь к виду
 */
 	define('VIEW', '/skins/');

/**
* Устанавлаваем активный шаблон
*/
	define('TEMPLATE', VIEW . 'shop/');

/**
* Путь для автолоада моделей
*/
	$INCLUDE_PATCH = array(
							'libs',
							'models',
							'components/registration'
						  );

 /**
* Соль пароля
*/
   define('IRB_CONFIG_SALT', 'bou5s@l#mea2d');














