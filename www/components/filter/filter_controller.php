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

    $start_price = $_GET['price-start'];
    $end_price = $_GET['end-price'];

    $brand = array();
    if($_GET['brand']){

    	foreach ($_GET['brand'] as $value) {
    		
    		$value = (int)$value;
    		$brand[$value] = $value;

    	}
    }
    if($brand){

    	$cat_brend = implode(',', $brand);
    }

    
    

    $sort_name = "";

    $rows = $start_price;
    $rows2 = $end_price;

 include IRB_ROOT . TEMPLATE . 'tpl/filter/show.tpl';