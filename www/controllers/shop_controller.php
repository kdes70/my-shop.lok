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
	$shop = new Shop_Model('table_products', $GET['num']);
	//Взависимости от значения куки меняем вид
	if(isset($_COOKIE['display'])){

		$_COOKIE['display'] == "grid" ? $skin = 'shop/row-grid' : $skin = 'shop/row-list';
	}
	else{
		$skin = 'shop/row-grid';
	}




switch ($GET['mod']) {

	case 'price-desc':

		 //Выводим шаблон вида Grig
		$shop->setSort('price', 'DESC');
		$shop->createAllTovars(4, true);
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "От дорогих к дешовым";
		$page_menu = $shop->menu;

		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		case 'price-asc':

		 //Выводим шаблон вида Grig
		$shop->setSort('price', 'ASC');
		$shop->createAllTovars(4, true);
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "От дешовых к дорогим";
		$page_menu = $shop->menu;

	    include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		case 'popular':

		 //Выводим шаблон вида Grig
		$shop->setSort('count', 'DESC');
		$shop->createAllTovars(4, true);
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "Популярное";
		$page_menu = $shop->menu;

		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		 case 'news':


		$shop->setSort('datetime', 'DESC');
		$shop->createAllTovars(4, true);
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "Новинки";
		$page_menu = $shop->menu;

		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		case 'brend':


		$shop->setSort('brand');
		$shop->createAllTovars(4, true);
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "От А до Я";
		$page_menu = $shop->menu;


		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		 case 'filter':

		$start_price = $_GET['price-start'];
		$end_price = $_GET['end-price'];

		$brand = array();

		if(isset($_GET['brand'])){

		foreach ($_GET['brand'] as $value) {

			$value = (int)$value;
			$brand[$value] = $value;

			}
		}
			if(!empty($brand)){

			$cat_brend = implode(',', $brand);

			}




		$sort_name = "";

		$rows = $start_price;
		$rows2 = $end_price;
		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		case 'new':

		 //Выводим шаблон вида Grig

		$shop->setCondition('`new` = 1');
		$shop->eyesTopper();
		$page_title ='Новинки';
		$rows = $shop->createRows($skin, 'full', 'купить');
		$page_menu = $shop->menu;

		include IRB_ROOT . TEMPLATE .'/tpl/shop/stoper.tpl';
		break;

		case 'hits':

		 //Выводим шаблон вида Grig

		$shop->setCondition('`hits` = 1');
		$shop->eyesTopper();
		$page_title = 'Лидеры продаж';

		$rows = $shop->createRows($skin, 'full', 'купить');
		$page_menu = $shop->menu;

		include IRB_ROOT . TEMPLATE .'/tpl/shop/stoper.tpl';
		break;

		case 'sale':

		 //Выводим шаблон вида Grig

		$shop->setCondition('`sale` = 1');
		$shop->eyesTopper();
		$page_title = 'Распродажа';
		$rows = $shop->createRows($skin, 'full', 'купить');
		$page_menu = $shop->menu;

		include IRB_ROOT . TEMPLATE .'/tpl/shop/stoper.tpl';
		break;

		case 'cat':

		//Выводим шаблон вида Grig
		//$shop->setCondition('`public` = 1');
		$shop->createCatTovars(abs((int)$GET['parent']));
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "Без сортировки";
		$page_menu = $shop->menu;


		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

		case 'full':

		//Выводим шаблон вида Grig
		$shop->createFull($GET['parent']);
		$rows = $shop->createRows('shop/full', 'full', 'купить');
		$sort_name = "Без сортировки";
		$page_menu = $shop->menu;


		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;

	default:




		//Выводим шаблон вида Grig
		$shop->createAllTovars(4);
		$rows = $shop->createRows($skin, 'full', 'купить');
		$sort_name = "Без сортировки";
		$page_menu = $shop->menu;


		include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
		break;
}




	$page_menu = $shop->menu;








