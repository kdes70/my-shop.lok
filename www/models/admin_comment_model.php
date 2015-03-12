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

class Admin_Comment_Model extends Comment_Model
{

    public $menu;
/** 
* Метод  отображения
* access public
* @param string $tpl
* @param int $num
* @param int $num_rows
* @return
*/
    public function getComments($tpl, $num, $num_rows)
    {
        $rows      = $autors = $avatars = array();    
        $comments  = ''; 
        $paginator = new IRB_Paginator($num, $num_rows);   
        // Запрос с постраничкой
        $res = $paginator -> countQuery("SELECT DATE_FORMAT(`date`,'%d-%m-%Y') AS `date`,
                                           `id_autor`, `autor`, `text`, `id`
                                           FROM `". IRB_DBPREFIX . $this->table ."`  
                                           ORDER BY `id` ASC"
                                           ); 
        if(mysqli_num_rows($res) > 0)
        {
            // Создаем массив актуальных авторов        
            while($row = mysqli_fetch_assoc($res))
                $this->autors[] = $row['id_autor'];                              
            // Получаем массив актуальных аватарок
            $avatars = $this->_getAvatars();        
            // Формируем меню постранички
            $this->menu = $paginator -> createMenu();     
         
            // Возвращаемся к началу массива первого запроса
            mysqli_data_seek($res, 0); 
            
            // Формируем вывод        
            $cont = getTpl($tpl);  
            $bb   = new IRB_BBdecoder();
         
            while($row = mysqli_fetch_assoc($res))  
            {             
                $row['avatar'] = createAvatar($row['id_autor'], $avatars);
                $row['autor']  = htmlChars($row['autor']);
                $row['text']   = $bb -> createBBtags($row['text']);  
                $comments .= parseTpl($cont, $row);  
            }  
        }
        
        return $comments;
    } 

/** 
* Метод удаления информации
* access public
* @param array $comments
* @return boll
*/
    public function deleteComments($comments)
    {
        $id_array = array_map('intval', $comments);
        $topics   = array();
        // Подсчитываем количество выбранных комментариев
        $res = mysqlQuery("SELECT `id_topic`
                            FROM `". IRB_DBPREFIX . $this->table ."` 
                            WHERE `id` IN (". implode(', ', $id_array) .")"
                            );        
        
        while($row = mysqli_fetch_assoc($res))      
            @$topics[$row['id_topic']]++;
        // Корректируем счетчик комментариев
        foreach($topics as $id_topic => $cnt)
        {
            mysqlQuery("UPDATE `". IRB_DBPREFIX . $this->parent_table ."`
                         SET `cnt_comment` = `cnt_comment` - ". $cnt ."
                         WHERE `id` = ". (int)$id_topic
                         ); 
        }
        // Удаляем выбранные комменты
        mysqlQuery("DELETE FROM `". IRB_DBPREFIX . $this->table ."`  
                     WHERE `id` IN (". implode(', ', $id_array) .")"  
                     );
     
        return (mysqli_affected_rows(DB::$link) > 0); 
     
    }     
   
}
   
    
    
    
    
    
    
    
    
    
    
    
    