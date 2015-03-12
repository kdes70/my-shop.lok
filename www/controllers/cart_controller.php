<?php

/**
* Контроллер
* @author IT studio IRBIS-team
* @copyright © 2012 IRBIS-team
*/
/////////////////////////////////////////////////////////

/**
* Генерация страницы ошибки при доступе вне системы
*/
	if(!defined('IRB_KEY'))
	{
	   header("HTTP/1.1 404 Not Found");
	   exit(file_get_contents('../404.html'));
	}
////////////////////////////////////////////////////////
	$cart = new Cart_Model('table_products', 'cart');

switch ($GET['mod']) {

		case 'addtocart':
		
		// Добавления товара в корзину
		 $goods_id = (int)$GET['parent'];

		$cart->addTocart($goods_id);
		
		$_SESSION['total_price'] = $cart->totalPrice($_SESSION['cart']);


		$_SESSION['total_quantity'] = 0;
		foreach ($_SESSION['cart'] as $key => $value) {
			if (isset($value['price'])) {
				$_SESSION['total_quantity'] += $value['qty'];
				
			} else {
				unset($_SESSION['cart'][$key]);
			}
			
		}


		reDirect();

	
	 exit();
		break;

		case 'oneclick':
		/*Добавление товара в корзину*/

		

		/*$cart->createTovarTocart();
		$rows = $cart->createRows( "cart/row", "");
		$all_price = $cart->all_price;*/
		include IRB_ROOT . TEMPLATE .'/tpl/cart/one.tpl';
		break;

		case 'confirm':
		/*Добавление заказа*/
		if($ok)
		{

			// Общие данные
			$_SESSION['order']['dostavka'] = $dostavka = $POST['value1']; // Способ доставки
			$_SESSION["order"]['prim']     = $prim     = htmlChars($POST['value6']); // Примечание к доставки

			if(isset($_SESSION['userdata'])) $user_id  = $_SESSION['userdata']['id'];

			if(!isset($_SESSION['userdata']))
			{	
				$error = ''; //Флаг проверки пустых полей
				
				$_SESSION["order"]['fio'] 		= $fio = $POST['value2'];
				$_SESSION["order"]['email'] 	= $email = $POST['value3'];
				$_SESSION["order"]['phone']		= $phone =  $POST['value4'];
				$_SESSION["order"]['address']   = $addres =  $POST['value5'];
								

			if(empty($fio)) $error     .= "Не указано ФИО <br>";
			if(empty($email)) $error   .= "Не указан Email <br>";
			if(empty($phone)) $error   .= "Не указан телефон <br>";
			if(empty($addres)) $error  .= "Не указан адрес <br>";

		if(empty($error))
		{
			//Добавления гостя в заказчики (без данных авторизации)

			$user_id = $cart->addClient($fio, $email, $phone, $addres);

			if(!$user_id){

				$info[]  = "Произошла ошибка оформления заказа: <br>";
				exit();
			/*if(!empty($error)) $info[]  = "Произошла ошибка оформления заказа: <br>". $error;
				$_SESSION['order']['dostavka']  = $POST['value1'];
				$_SESSION["order"]['fio'] 		= $POST['value2'];
				$_SESSION["order"]['email'] 	= $POST['value3'];
				$_SESSION["order"]['phone'] 	= $POST['value4'];
				$_SESSION["order"]['address']   = $POST['value5'];*/

			}
			else{
				$info[] = "данные получины". $user_id;	
				//reDirect("mod=completion");	
			}
		}else{

			if(!empty($error)) 

				$info[]  = "Не заполнены обязательные поля: <br>". $error;
				
				$_SESSION['order']['dostavka']  = $POST['value1'];
				$_SESSION["order"]['fio'] 		= $POST['value2'];
				$_SESSION["order"]['email'] 	= $POST['value3'];
				$_SESSION["order"]['phone'] 	= $POST['value4'];
				$_SESSION["order"]['address']   = $POST['value5'];


			
		}

	}
			
		$info[]  =	$cart->saveOrders($user_id, $dostavka, $prim);
			reDirect("mod=completion");
			
		}


		include IRB_ROOT . TEMPLATE .'/tpl/cart/form.tpl';
		break;

		case 'completion':

		if(isset($_SESSION['userdata']))
		{
			$name   = $_SESSION['userdata']['name'];
			$email  = $_SESSION['userdata']['email'];
			$phone  = $_SESSION['userdata']['phone'];
			$addres = $_SESSION['userdata']['address'];

		}
		else{

			$name   = $_SESSION["order"]['fio']; 	
			$email  = $_SESSION["order"]['email'];
			$phone  = $_SESSION["order"]['phone'];
			$addres = $_SESSION["order"]['address'];
		}

		

		include IRB_ROOT . TEMPLATE .'/tpl/cart/complet.tpl';
		# code...
		break;

		//Удаление товара из корзины
		case 'delete':
			$cart->deleteTovarTocart((int)$GET['parent']);
			reDirect("mod=oneclick");
		break;
		//Всю корзину
		case 'clear':
			// $cart->clearTocart();
			unset($_SESSION['cart']);
			unset($_SESSION['total_price']);
			unset($_SESSION['total_quantity']);
			unset($_SESSION['order']);
			reDirect("mod=oneclick");
		break;

	default:
		$cart->createTovarTocart();
		$rows = $cart->createRows( "cart/row", "");
		$all_price = $cart->all_price;
		include IRB_ROOT . TEMPLATE .'/tpl/cart/one.tpl';
		break;
}
