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

    $cat = new Category_Model('category', $GET['parent']);

    $category = $cat->creatCatArrey();

  

    include IRB_ROOT . TEMPLATE . 'tpl/category/show.tpl';

 