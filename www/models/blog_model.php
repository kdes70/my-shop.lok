<?php

/**
* Модель
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
/////////////////////////////////////////////////////////
 
    
class Blog_Model extends Line_Model
{
    public $comments, $id_parent, $indicator;  

/**
* Метод представления.
* @param string $template
* @param string $mod
* @param string $link
* @return string 
*/      
    public function createRows($template, $mod, $link)
    {
        global $GET, $POST;
        $rows  = '';    
        $tpl   = getTpl($template);    
        $bb = new IRB_BBdecoder();
       
        while($row = mysqli_fetch_assoc($this->res))
        {
            $this->title       = !empty($row['m_title']) ? htmlChars($row['m_title']) : '';
            $this->keywords    = !empty($row['m_keywords']) ? htmlChars($row['m_keywords']) : '';
            $this->description = !empty($row['m_description']) ? htmlChars($row['m_description']) : '';
         
            $row['title'] = htmlChars($row['title']);
            
            if($this->clear)
                $row['text'] = $bb -> stripBBtags($row['text']);
            else
                $row['text'] = $bb -> createBBtags($row['text']);
                
            $row['link']      = $link;
            $row['ready']     = !empty($POST['array1']);
            $row['comments']  = $this->comments;           
            $row['id_parent'] = $this->id_parent;
            $row['no_public'] = empty($row['public']) ? '<img src="/skins/images/no_public.png" border="0" />' : '';

            if(look::check(false) && !defined('IRB_ADMIN'))
                $row['indicator'] = IRB_Rating::createRating($row['id'], $_SESSION['userdata']['id']);
            else
                $row['indicator'] = IRB_Rating::createRating($row['id']);
            // Получаем список ссылок (тегов) для статьи
            $tags = IRB_Cloud::getTags($row['id']);
            $row['tags'] = '';
            // Формируем строчку через разделителm, попутно выделяя текущий тег
            foreach($tags as $id => $tag)
            {
                if($GET['parent'] == $id)
                    $row['tags'] .= '| <strong>'. $tag .'</strong> '; 
                else
                    $row['tags'] .= '| '. $tag .' ';
            }
            // Убираем крайние разделители и присваиваем список элементу массива, который пойдет в шаблон.
            $row['tags'] = trim($row['tags'], '|');
            
            $num          = ($this->num > 1)  ? $this->num : 0;
            $link_name    = ($mod === 'full') ? translateWord($row['title']) : 0;
            
            $row['url']   = href('mod='. $mod, 'parent='. $row['id'], 'id='. $link_name, 'num='. $num);           
            $rows .= parseTpl($tpl, $row);   
        }
        
        return $rows;    
    } 
}     
    

  
   
    
    
    
    
    
    
    
    
    
    
