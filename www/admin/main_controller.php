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
///////////////////////////////////////////////////////////////
    // Облако тегов
    $cloud = new IRB_Cloud(); 
    $html_list  = $cloud -> createList('html', false, false);

    $blog = new Admin_Blog_Model('blog', $GET['num'], false);
    
    IRB_Rating::$table     = IRB_DBPREFIX .'blog'; 
    IRB_Rating::$indicator = IRB_HOST .'ajax/blog_rating.php';
    
    if($GET['mod'] === 'add')
    {
    // Блок добавления
        if($ok)
        {
            $img = ''; 
                
            if($_FILES['file']['error'] === 0)
            {
                $upload = new IRB_Upload_Img($lang_file_error);
                
                if($error = $upload -> uploadFile('file'))
                   $info[] = $error;
             
                $img = '[img]'. $upload -> new_name .'[/img]';        
            }        
         
            if(empty($info))
                $info[] = $blog -> addLine($POST['value1'], 
                                           $POST['value2'] . $img,
                                           $POST['value3'],
                                           $POST['value4'],
                                           $POST['value5'],
                                           $POST['value6']
                                         );
          
            if(empty($info[0]))
                reDirect('mod=edit', 'parent='. $blog->id);
        }    
     
        $tags = $m_title = $m_keywords = $m_description = $rows = $text = $title = '';
        include IRB_ROOT .'/skins/tpl/admin/blog/form.tpl';
    }    
    elseif($GET['mod'] === 'edit')
    {
    // Блок редактирования
        if($edit)
        {
            $img = '';
                
            if($_FILES['file']['error'] === 0)
            {
                $upload = new IRB_Upload_Img($lang_file_error);
                
                if($error = $upload -> uploadFile('file'))
                   $info[] = $error;
             
                $img = '[img]'. $upload -> new_name .'[/img]';        
            }
            
            if(empty($info))
            {        
                $blog->id = $GET['parent'];
                $info[] = $blog -> editLine($POST['value1'], 
                                            $POST['value2'] . $img,
                                            $POST['value3'],
                                            $POST['value4'],
                                            $POST['value5'],
                                            $POST['value6']
                                           );
            }
            
            if(empty($info[0]))
                reDirect();
        }
        // Блок публикации
        if($ok)
        { 
            $blog->id = $GET['parent'];
            $info[] = $blog -> publicLine();
            
            if(empty($info[0]))
                reDirect('mod=all');
        }
        // Блок удаления     
        if($delete)
        { 
            $blog->id = $GET['parent'];
            $info[] = $blog -> deleteLine();
            
            if(empty($info[0]))
                reDirect('mod=all');
        } 
        
        // Блок отображения 
        $blog -> createFull($GET['parent'], true);
        $rows  = $blog -> createRows('blog/rows', 'all', IRB_LANG_BACK);
        $edit  = $blog -> createEdit($GET['parent']);
        extract($edit); // $tags, $m_title, $m_keywords, $m_description, $text, $title
        include IRB_ROOT .'/skins/tpl/admin/blog/form.tpl';    
    }
    else
    {  // Блок ленты анонсов
        if($GET['mod'] === 'tags')
        {   
            $ids = $cloud -> getSelect($GET['parent']);
         
            if(!empty($ids))
                $blog->setCondition("`id` IN (". implode(',', $ids) .")");
        }
        
        $blog->clear = true;
        $blog -> createPreview(IRB_CONFIG_NUM_ROWS, IRB_CONFIG_NUM_WORDS);       
        $rows = $blog -> createRows('blog/rows', 'edit', IRB_LANG_EDIT);
        $page_menu = $blog->menu;
        include IRB_ROOT .'/skins/tpl/blog/show.tpl';        
    }

    
    
    
    
    
    
    
    
    
    
    
    
    