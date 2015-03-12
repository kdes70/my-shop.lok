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

    unset($_SESSION['userdata']);
    unset($_SESSION['cart']);
    unset($_SESSION['total_price']);
    unset($_SESSION['total_quantity']);   
    setcookie('hash', '', time() - 3600, "/"); 
    
    reDirect('page=shop');


    
    
    
    
    
    