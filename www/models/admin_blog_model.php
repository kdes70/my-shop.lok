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
    
class Admin_Blog_Model extends Blog_Model
{

/**
* Метод записи.
* @param string $title
* @param string $text
* @param string $m_title
* @param string $m_keywords
* @param string $m_description
* @return mixed 
*/                                               //  Еще один параметр для тегов ($tags)
    public function addLine($title, $text, $m_title, $m_keywords, $m_description, $tags)
    {
        if(empty($title))
            return IRB_LANG_NO_HEADER;
        
        if(empty($text))
            return IRB_LANG_NO_TEXT;
        
        mysqlQuery("INSERT INTO `". IRB_DBPREFIX . $this->table ."`
                     SET `date`   = NOW(),
                         `m_title`       = '". escapeString($m_title) ."',                     
                         `m_keywords`    = '". escapeString($m_keywords) ."',
                         `m_description` = '". escapeString($m_description) ."',
                         `title`         = '". escapeString($title) ."',
                         `text`          = '". escapeString($text) ."',
                         `public`        = 0 "
                     );
     
        if(mysqli_affected_rows(DB::$link) > 0)
        {
            $this->id = mysqli_insert_id(DB::$link);
            // Отправим теги в класс облака, там они обработаются и пропишутся куда надо
            IRB_Cloud::addTags($this->id, $tags);
            
            return NULL;    
        }
        else
            return IRB_LANG_FATAL_ERROR;  
     
    }    
    
/**
* Метод представления для редактирования.
* @param int $id
* @return array 
*/      
    public function createEdit($id)
    {
        $this->createFull($id, false);
        $row = mysqli_fetch_assoc($this->res);
        // Чтобы вернуть метки в поле при редактировании
        $tags = IRB_Cloud::getTags($id);// получим список тегов
        $row['tags'] = implode(', ', $tags);  // и выведем их через запятую 
        $row['tags'] = strip_tags($row['tags']); // почистив от тегов
        return htmlChars($row);   
    }
 
/**
* Метод редактирования.
* @param string $title
* @param string $text
* @param string $m_title
* @param string $m_keywords
* @param string $m_description
* @return mixed 
*/                                                //  Еще один параметр для тегов ($tags)   
    public function editLine($title, $text, $m_title, $m_keywords, $m_description, $tags)
    {
        if(empty($title))
            return IRB_LANG_NO_HEADER;
        
        if(empty($text))
            return IRB_LANG_NO_TEXT;
     
        $res = mysqlQuery("UPDATE `". IRB_DBPREFIX . $this->table ."`
                             SET `date`   = NOW(),
                                 `m_title`       = '". escapeString($m_title) ."',                     
                                 `m_keywords`    = '". escapeString($m_keywords) ."',
                                 `m_description` = '". escapeString($m_description) ."',
                                 `title`         = '". escapeString($title) ."',
                                 `text`          = '". escapeString($text) ."' 
                            WHERE `id` = ". (int)$this->id
                             ); 
     
        if($res)
        {// В методе редактирования тоже не помешает обновить метки
            IRB_Cloud::addTags($this->id, $tags);
            return NULL;
        }
        else
            return IRB_LANG_FATAL_ERROR;    
     
    } 
    
/**
* Метод публикации.
* @return mixed 
*/      
    public function publicLine()
    {
     
        mysqlQuery("UPDATE `". IRB_DBPREFIX . $this->table ."`
                     SET  `public` = 1 
                    WHERE `id` = ". (int)$this->id
                     ); 
     
        if(mysqli_affected_rows(DB::$link) > 0)
            return NULL;
        else
            return IRB_LANG_FATAL_ERROR;   
     
    }     

/**
* Метод удаления.
* @return mixed 
*/      
    public function deleteLine()
    {
     
        mysqlQuery("DELETE FROM `". IRB_DBPREFIX . $this->table ."`
                    WHERE `id` = ". (int)$this->id
                     ); 
     
        if(mysql_affected_rows(DB::$link) > 0)
            return NULL;
        else
            return IRB_LANG_FATAL_ERROR;   
     
    }       
}    
    
    
    
    
    
    
    
    
    
    
