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

    $comm = new Admin_Comment_Model('blog_comments', 0);

// Блок удаления информации  
    if($delete)  
    { 
        $id_array = array_map('intval', $POST['array1']);
        
        if($comm -> deleteComments($id_array))
            reDirect();  
     
    }     
   
// Блок отображения
    $rows      = $comm -> getComments('admin/comments/rows', $GET['num'], IRB_CONFIG_NUM_ROWS);  
    $page_menu = $comm -> menu;    
 
    $POST = htmlChars($POST);
    include IRB_ROOT .'/skins/tpl/admin/comments/show.tpl'; 
    

    
    
    
    
    
    
    
    
    
    
    