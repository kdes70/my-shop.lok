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

		if($_SERVER['REQUEST_METHOD'] == "POST")

		{


			if(empty($POST['value1'])  OR empty($POST['value2']))
			{
				// если пусты поля логин/пароль
        	//	echo IRB_LANG_ERROR_LOGIN_PASS;
				echo 'Поля логин/пароль должны быть заполнены!';

			}else{



				$res = mysqlQuery("SELECT `id`, `login`, `name`, `email`, `surname`, `phone`,
											`patronymic`, `patronymic`, `address`, `ban`
								 FROM `". IRB_DBPREFIX ."users`
								 WHERE (login = '".escapeString($POST['value1'])."' OR email = '".escapeString($POST['value1'])."')
								 AND   `password` = '". criptPass($POST['value2']) ."'
								");

				if(mysqli_num_rows($res) > 0)
				{


						$_SESSION['userdata'] = htmlChars(mysqli_fetch_assoc($res));
						$_SESSION['userdata']['password'] = criptPass($POST['value2']) ;
						//$_SESSION['userdata']['error'] = "yes_auth";
					echo "Добро пожаловать!";
						// Если стоит галочка, значит элемент value3 не пустой.
						// Вторым аргументом передаем true - устанавливаем куку.
						$auto = !empty($POST['value3']);
					//!empty($_POST['rememberme']) == 'yes' ? $auto = 'yes': "";

						look::setlogin($_SESSION['userdata']['id'], $auto);

				}
				else {echo  IRB_LANG_ERROR_USERDATA;}

			}
		}
		else{
			reDirect('page=shop');
		}









	//	include IRB_ROOT .'/skins/tpl/registration/form_autorize.tpl';







