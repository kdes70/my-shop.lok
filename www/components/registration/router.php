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
       exit(file_get_contents('../../404.html'));
    }
//////////////////////////////

    $modul = basename(dirname(__FILE__));
 
// Подключаем файл с функциями     
    include IRB_ROOT .'/components/'. $modul .'/functions.php';
    
/** 
* Переключатель контроллеров 
*/ 
    if(file_exists(IRB_ROOT .'/components/'. $modul .'/'. translateWord($GET['mod']) .'_controller.php'))
        include IRB_ROOT .'/components/'. $modul .'/'. translateWord($GET['mod']) .'_controller.php';     
    else
    {
       header("HTTP/1.1 404 Not Found");     
       exit(file_get_contents('./404.html'));
    }


    

    
    
    
    
    
    