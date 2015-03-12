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
///////////////////////////////////////////////////////////////

    if($ok && isset($admins[$POST['value1']]) && $admins[$POST['value1']] === $POST['value2'])
    {
        $_SESSION['admin'] = true;    
        reDirect('page=main');
    }    
    
    include IRB_ROOT .'/skins/tpl/admin/admin.tpl';   
    
    
    
    
    
    
    
    
    
    
    
    