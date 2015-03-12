<?php
/**
* Контроллер
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
       exit(file_get_contents('../404.html'));
    }
/////////////////////////////////////////////////////////////

    $meta = getMeta();
/*
* Блок формирования нового элемента
*/
    if($ok)
    {
        if(empty($POST['value1']))
            $info[] = IRB_LANG_NO_TEXT;
        elseif(!preg_match('#^[a-z0-9]+$#', $POST['value1']))
            $info[] = IRB_LANG_INVALID_LINK;
        else
        {
            $meta[$POST['value1']] = array( 'title'       => IRB_LANG_NO_TITLE,
                                            'keywords'    => IRB_LANG_NO_KEYWORDS,
                                            'description' => IRB_LANG_NO_DESCRIPTION
                                            );
            
            file_put_contents(IRB_ROOT .'/setup/meta.txt', serialize($meta)); 
            reDirect();         
        }   
    }
/*
* Блок удаления
*/
    if($delete)
    {
        foreach($POST['array1'] as $link)
            unset($meta[$link]);
            
        file_put_contents(IRB_ROOT .'/setup/meta.txt', serialize($meta));        
        reDirect();     
    }
/*
* Блок редактирования
*/      
    if($edit)
    {
        $meta[$GET['mod']] = array( 'title'       => $POST['value2'],
                                    'keywords'    => $POST['value3'],
                                    'description' => $POST['value4']
                                    );
            
        file_put_contents(IRB_ROOT .'/setup/meta.txt', serialize($meta));        
        reDirect();     
    }    

/*
* Блок формирования ссылок с чекбоксами
*/    
    $menu  = "<ul  class=\"pages_menu\">\n";    

    foreach($meta as $link => $name)       
        $menu .= '<li><input name="form[array1][]" type="checkbox" value="'. $link .'" />   
           <a href="'. href('mod='. $link) .'" >'. $name['title'] ."</a>  
            </li>\n";          
    
    $menu .= "</ul>\n";  

/*
* Блок чтения
*/     
    
    $modul = !empty($meta[$GET['mod']]) ? $meta[$GET['mod']]['title'] : IRB_LANG_NO_SELECT;
    
    $POST['value2'] = !empty($meta[$GET['mod']]['title']) 
                    ? $meta[$GET['mod']]['title'] : IRB_LANG_NO_TITLE;
                    
    $POST['value3'] = !empty($meta[$GET['mod']]['keywords']) 
                    ?    $meta[$GET['mod']]['keywords'] : IRB_LANG_NO_KEYWORDS;
                    
    $POST['value4'] = !empty($meta[$GET['mod']]['description']) 
                    ? $meta[$GET['mod']]['description'] : IRB_LANG_NO_DESCRIPTION;

    include IRB_ROOT .'/skins/tpl/admin/meta.tpl';    
    
   
    
    
  