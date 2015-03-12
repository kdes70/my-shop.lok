<?php

/** 
 * IRB_Cloud - class create tag cloud 
 * NOTE: Requires PHP version 5 or later  
 * Info: http://irbis-team.ru   
 * @author IT studio IRBIS-team 
 * @copyright © 2012 IRBIS-team 
 * @version 0.1 
 * @license http://www.opensource.org/licenses/rpl1.5.txt 
 */   

class IRB_Cloud
{
    public $max_size = 33;
    public $step     = 12;
    public $colors   = array('#FF0000', '#006F00', '#0000FF');
    public $tags     = array();    
    public $parents  = array();
    
    public function __construct()
    {
        $this->_queryTags();
    }

/** 
* Метод добавления тегов     
* @param int $id 
* @param string $tags
* @return void
*/        
    static function addTags($id, $tags) 
    {
        $res = mysqlQuery("SELECT `parent`
                            FROM `". IRB_DBPREFIX ."cloud_linkage`
                            WHERE `id` = ".(int)$id
                            );
     
        while($row = mysqli_fetch_assoc($res))
            $parents[] = $row['parent'];
     
        if(!empty($parents))
        {    
            mysqlQuery("UPDATE `". IRB_DBPREFIX ."cloud_tags`
                         SET   `count` = `count` - 1
                         WHERE `id` IN (". implode(',', $parents) .")"
                         );
         
            mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."cloud_tags`
                          WHERE `count` <= 0 "
                          );
            
            mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."cloud_linkage`
                          WHERE `id` = ".(int)$id
                          );
        }
        
        if(!empty($tags))
        {
            $arr = explode(',', $tags);
            $arr = array_map('trim', $arr);
            $arr = array_unique($arr);
            $arr = array_filter($arr, 'emptyfilter');  
            
            foreach($arr as $tag)
            {
                mysqlQuery("INSERT IGNORE INTO `". IRB_DBPREFIX ."cloud_tags`
                             SET `tag`     = '".escapeString($tag) ."',
                                 `count`   = 1"
                             );
             
                $id_tag = mysqli_insert_id(DB::$link);
                
                if(empty($id_tag))
                {
                    $res = mysqlQuery("SELECT `id`
                                        FROM `". IRB_DBPREFIX ."cloud_tags`
                                        WHERE `tag` = '".escapeString($tag) ."'"
                                        );
                 
                    $row    = mysqli_fetch_assoc($res);
                    $id_tag = $row['id'];
                    
                    mysqlQuery("UPDATE `". IRB_DBPREFIX ."cloud_tags`
                                 SET   `count` = `count` + 1
                                 WHERE `id`    = ".(int)$id_tag
                                 );
                 
                }
             
                $values[] = "(".(int)$id .", ".(int)$id_tag .")";
            }
            
            if(!empty($values))
            {
                mysqlQuery("INSERT IGNORE INTO `". IRB_DBPREFIX ."cloud_linkage`
                            (`id`, `parent`)
                            VALUES
                            ". implode(',', $values)
                             );
            }
        }
    }      

/** 
* Метод генерации списка ссылок       
* @param int $id
* @return string
*/        
    static function getTags($id) 
    {
        $ids = $tags = array();
     
        $res = mysqlQuery("SELECT `parent`
                            FROM `". IRB_DBPREFIX ."cloud_linkage`
                            WHERE `id` = ".(int)$id
                            );
     
        while($row = mysqli_fetch_assoc($res))
            $parents[] = $row['parent'];
       
        if(!empty($parents))
        {
            $res = mysqlQuery("SELECT `id`, `tag`
                                FROM `". IRB_DBPREFIX ."cloud_tags`
                                WHERE `id` IN (". implode(',', $parents) .")"
                                );
        }
        
        while($row = mysqli_fetch_assoc($res))
            $tags[$row['id']] = self::_htmlLinks($row['id'], $row['tag']);
        
        return $tags;
    }        
    
/** 
* Метод выбора тегов статьи   
* @param int $parent
* @return array
*/        
    public function getSelect($parent) 
    {
        $ids = array();
     
        $res = mysqlQuery("SELECT `id`
                            FROM `". IRB_DBPREFIX ."cloud_linkage`
                            WHERE `parent` = ".(int)$parent
                            );
     
        while($row = mysqli_fetch_assoc($res))
            $ids[] = $row['id'];
        
        return $ids;
    }    

/** 
* Метод генерации списка ссылок
* @param string $type
* @param bool $color
* @return string
*/        
    public function createList($type, $color = false, $links = true) 
    {   
        $min_size = min($this->tags);
        $range    = max($this->tags) - $min_size;
        $range    = ($range < 1) ? 1 : $range; 
        
        foreach ($this->tags as $tag => $count) 
        { 
            $size    = round(($count - $min_size) / $range * $this->max_size + $this->step);
            $method  = '_'. $type . 'Links';
            $list[] = $this->$method($this->parents[$tag], $tag, $links, $size, $color); 
        } 
        
        return implode(' ', $list); 
    } 

/** 
* Метод запроса для выборки тегов       
* @return void
*/        
    private function _queryTags() 
    { 
        $res = mysqlQuery("SELECT *
                            FROM `". IRB_DBPREFIX ."cloud_tags`"
                            );
      
        while($row = mysqli_fetch_assoc($res))
        {
            $this->tags[$row['tag']]     = $row['count'];
            $this->parents[$row['tag']]  = $row['id'];
        } 
    }    
    
/** 
* Метод формирования ссылок для флэш      
* @param string $tag
* @param int $size
* @param bool $color
* @return string
*/      
    private function _flashLinks($parent, $tag, $links = true, $size, $color = false) 
    {   
        return '<a href="'. href('page=main', 'mod=tags', 'parent='. $parent, 'id='. translateWord($tag)) 
              . '" style="font-size:'. $size .'px"'
              . ($color ? ' color="'. $this->_randColor(true) .'"' : '') .'>'
              . htmlChars($tag) .'</a>'; 
    } 
    
/** 
* Метод формирования ссылок для HTML      
* @param string $tag
* @param int $size
* @param bool $color
* @return string
*/      
    private function _htmlLinks($parent, $tag, $links = true, $size = 0, $color = false) 
    {
        $style  = !empty($size) ? 'font-size:'. $size .'px;' : '';
        $style .= $color  ? ' color:'. $this->_randColor() : '';
        
        return ($links) ? '<a href="'. href('page=main', 'mod=tags', 'parent='. $parent, 'id='. translateWord($tag))  
                              . '" style="'. $style .'">'. htmlChars($tag) .'</a>'
                              : '<span style="'. $style .'">'. htmlChars($tag) .'</span>'; 
    } 
    
/** 
* Метод  установки случайного цвета ссылок      
* @param bool $flash
* @return string
*/  
    private function _randColor($flash = false) 
    { 
        $color = $this->colors[array_rand($this->colors)];
     
        if($flash)
            return str_replace('#', '0x', $color);
        else
            return $color;
    }  
} 



























