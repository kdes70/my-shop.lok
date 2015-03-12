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


    switch ($GET['mod']) {
        
        case 'price-desc':

             //Выводим шаблон вида Grig
            $shop->setSort('price', 'DESC');
            $shop->createAllTovars(4, true);
            $rows = $shop->createRows('shop/row-grid', 'full', 'купить');
            $sort_name = "От дорогих к дешовым";
            //Выводим шаблон вида List
            $shop->createAllTovars(4, true);
            $rows2 = $shop->createRows('shop/row-list', 'full', 'купить');
            # code...
            break;

            case 'price-asc':

             //Выводим шаблон вида Grig
            $shop->setSort('price', 'ASC');
            $shop->createAllTovars(4, true);
            $rows = $shop->createRows('shop/row-grid', 'full', 'купить');
            $sort_name = "От дешовых к дорогим";
            //Выводим шаблон вида List

            $shop->createAllTovars(4, true);
           $rows2 = $shop->createRows('shop/row-list', 'full', 'купить');
            # code...
            break;

            case 'popular':

             //Выводим шаблон вида Grig
            $shop->setSort('count', 'DESC');
            $shop->createAllTovars(4, true);
            $rows = $shop->createRows('shop/row-grid', 'full', 'купить');
            $sort_name = "Популярное";
            //Выводим шаблон вида List
            $shop->createAllTovars(4, true);
           $rows2 = $shop->createRows('shop/row-list', 'full', 'купить');
            # code...
            break;

             case 'news':

             //Выводим шаблон вида Grig
            $shop->setSort('datetime', 'DESC');
            $shop->createAllTovars(4, true);
            $rows = $shop->createRows('shop/row-grid', 'full', 'купить');
            $sort_name = "Новинки";
            //Выводим шаблон вида List
            $shop->createAllTovars(4, true);
            $rows2 = $shop->createRows('shop/row-list', 'full', 'купить');
            # code...
            break;

            case 'brend':

             //Выводим шаблон вида Grig
            $shop->setSort('brand');
            $shop->createAllTovars(4, true);
            $rows = $shop->createRows('shop/row-grid', 'full', 'купить');
            $sort_name = "От А до Я";
            //Выводим шаблон вида List
            $shop->createAllTovars(4, true);
            $rows2 = $shop->createRows('shop/row-list', 'full', 'купить');
            # code...
            break;
        
        default:

            //Выводим шаблон вида Grig
            $shop->createAllTovars(4);
            $rows = $shop->createRows('shop/row-grid', 'full', 'купить');
            $sort_name = "Без сортировки";
             //Выводим шаблон вида List
            $shop->createAllTovars(4);
            $rows2 = $shop->createRows('shop/row-list', 'full', 'купить');
            # code...
            break;
    }


    
    
    $page_menu = $shop->menu;

   //  include IRB_ROOT . TEMPLATE . 'tpl/option/show.tpl';
      include IRB_ROOT . TEMPLATE .'/tpl/shop/show.tpl';
 ?>