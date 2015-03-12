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

    $cloud = new IRB_Cloud(false);
    $cloud->max_size = 33; 
    $cloud->step     = 12;    
    $flash_list = $cloud -> createList('flash', true); 
    $html_list  = $cloud -> createList('html');

    $blog = new Blog_Model('blog', $GET['num']);
   
    IRB_Rating::$table     = IRB_DBPREFIX .'blog'; 
    IRB_Rating::$indicator = IRB_HOST . 'ajax/blog_rating.php';
   
    if(!empty($POST['array2']) && look::check(false))
    {
        $parent = array_keys($POST['array2']);
        $mark   = array_keys($POST['array2'][$parent[0]]);
        IRB_Rating::addRating($parent[0], $_SESSION['userdata']['id'], $mark[0]);
        reDirect();
    }
    
    if($GET['mod'] === 'full')
    {    
        $comm = new Comment_Model('blog_comments', $GET['parent']);    
        
        if(look::check(false))
        { 
            if(!empty($POST['array1']))
            { 
                $keys = array_keys($POST['array1']);
                $blog->id_parent = $keys[0];
            }
            else 
                $blog->id_parent = 0;
            
            if($ok && $comm -> addComment($POST['value1'],
                                          $POST['value2'],
                                          $_SESSION['userdata']['id'],
                                          $_SESSION['userdata']['login']
                                          ))
            { 
                reDirect();
            }
            elseif($ok)
                $info[] = IRB_LANG_ERROR_USERDATA .'<br>'; 
         
        }
     
        $comments = $comm -> createComment('blog/comment');
     
        $blog->comments = $comments;
        
        $blog -> createFull($GET['parent']);
        $rows = $blog -> createRows('blog/full', 'all', IRB_LANG_BACK);                 
        createDinamicMeta($blog->title, $blog->keywords, $blog->description);        
        $page_menu = '';
    }
    else
    {
        // Если пришли по ссылке с облака тегов или метки
        if($GET['mod'] === 'tags')
        {   // Получаем список ID статей с этими метками
            $ids = $cloud -> getSelect($GET['parent']);
            // и устанавливаем условие на выборку
            if(!empty($ids))
                $blog->setCondition("`id` IN (". implode(',', $ids) .")");
        }
     
        $blog->id_parent = 0;
        $blog->comments  = '';
        $blog->clear = true;
        $blog -> createPreview(IRB_CONFIG_NUM_ROWS, IRB_CONFIG_NUM_WORDS);       
        $rows  = $blog -> createRows('blog/rows', 'full', IRB_LANG_FULL);
        $page_menu = $blog->menu;
    }
    
    
    include IRB_ROOT .'/skins/tpl/blog/show.tpl';
    
    
    
    
    
    