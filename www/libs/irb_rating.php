<?php

/** 
 * IRB_Rating - класс подсчета рейтингов
 * NOTE: Requires PHP version 5 or later  
 * Info: http://irbis-team.ru   
 * @author IT studio IRBIS-team 
 * @copyright © 2012 IRBIS-team 
 * @version 0.1 
 * @license http://www.opensource.org/licenses/rpl1.5.txt 
 */  
 
class IRB_Rating
{ 
    // Шаблон (фон) индикатора
    static $tpl;
    // Картинки кнопок
    static $up       = '/skins/images/up.png';    
    static $down     = '/skins/images/down.png';
    static $up_res   = '/skins/images/up_res.png';
    static $up_dis   = '/skins/images/up_dis.png';    
    static $down_res = '/skins/images/down_res.png';
    static $down_dis = '/skins/images/down_dis.png';  
    //  Цвета
    static $letter = '#000000'; // Надписей
    static $left   = '#f74646'; // Левой полоски
    static $right  = '#5cf747'; // Правой полоски    
    // Таблица рейтингов
    static $table;
    // Путь до обработчика
    static $indicator;    
    // Внутренние переменные
    static $sign, $row;    
       
/**
* Метод плучения оценки
* @param int $id_user
* @param int $id_topic
* @return int
*/
    static function getSign($id_topic, $id_user)
    {
        $res = mysqlQuery("SELECT `rating`
                            FROM `". self::$table ."_rating`
                            WHERE `id_user`  = ".(int)$id_user ."
                            AND   `id_topic` = ".(int)$id_topic
                            );
     
        $row = mysqli_fetch_assoc($res);
     
        return (int)$row['rating'];
     
    }      

/**
* Метод добавления оценки
* @param int $id_user
* @param int $id_topic
* @param int $mark
* @return bool
*/
    static function addRating($id_topic, $id_user, $mark)
    {
     
        mysqlquery("INSERT IGNORE INTO `". self::$table ."_rating`
                        SET `id_user`  = ".(int)$id_user .",
                            `id_topic` = ".(int)$id_topic .",
                            `rating`   = ".(int)$mark
                  ); 
     
        if(mysqli_affected_rows(DB::$link) > 0)
        {
            $sign = ($mark > 0) ? 'up' : 'down';
         
            mysqlQuery("UPDATE `". self::$table ."`
                         SET   `rating_". $sign ."` = `rating_". $sign ."` + 1
                         WHERE `id` = ".(int)$id_topic
                         );
            
            return true;
        }
        else
            return false;
     
    }     

/**
* Метод вывода индикатора
* @param int $id_user
* @param int $id_topic
* @return string
*/    
    static function createRating($id_topic, $id_user = 0)
    {
        if(!empty($id_user))
        {
            $sign = empty(self::$sign) ? self::getSign($id_topic, $id_user) : self::$sign;
         
            if($sign > 0)
            {
                $buttons  = '<img src="'. self::$down_dis .'" border="0" />'
                          . '<img src="'. self::$indicator .'?id='.  $id_topic.'" border="0" />'
                          . '<img src="'. self::$up_res .'" border="0" />';
            }
            elseif($sign < 0)
            {
                $buttons  = '<img src="'. self::$down_res .'" border="0" />'
                          . '<img src="'. self::$indicator .'?id='.  $id_topic.'" border="0" />'
                          . '<img src="'. self::$up_dis .'" border="0" />';
            }
            else
            {
                $buttons  = '<input name="form[array2]['. $id_topic .'][-1]" type="image" '
                          . 'src="'. self::$down .'"  alt="down" title="down"  />'
                          . '<img src="'. self::$indicator .'?id='.  $id_topic.'" border="0" />'
                          . '<input name="form[array2]['. $id_topic .'][1]" type="image" '
                          . 'src="'. self::$up .'"  alt="up" title="up"  />';
            }
        }
        else
        {
            $buttons  = '<img src="'. self::$down_dis .'" border="0" />'
                      . '<img src="'. self::$indicator .'?id='.  $id_topic.'" border="0" />'
                      . '<img src="'. self::$up_dis .'" border="0" />';
        }
        
        return $buttons;
    }

/**
* Метод получения рейтинга
* @param int $id_topic
* @return array
*/
    static function getRating($id_topic)
    {
        $res = mysqlQuery("SELECT `rating_up`, `rating_down`
                            FROM `". self::$table ."`
                            WHERE `id` = ".(int)$id_topic
                            );
     
        self::$row = mysqli_fetch_assoc($res);
        
        return !empty(self::$row) ? self::$row : array('rating_up' => 0, 'rating_down' => 0);        
    }     

/**
* Метод подсчета ратио
* @return int
*/
    static function calculateRatio()
    {
        if(self::$row['rating_up'] > 0 || self::$row['rating_down'] > 0)
            $ratio = round((self::$row['rating_up'] - self::$row['rating_down']) 
                   / (self::$row['rating_up'] + self::$row['rating_down']), 2);
                   
        return     isset($ratio) ? $ratio : 0;
    } 
    
/**
* Метод перевода HEX в RGB
* @param $color
* @return array
*/
    static function hexRgb($color)
    {
        $hex      = str_replace('#', '', $color);
        $rgb['r'] = hexdec(substr($hex, 0, 2));
        $rgb['g'] = hexdec(substr($hex, 2, 2));
        $rgb['b'] = hexdec(substr($hex, 4, 2)); 
     
        return $rgb; 
    }    
    
/**
* Метод создания графического индикатора
* @return void
*/
    static function createIndicator()
    {   
        $ratio  = self::calculateRatio();
     
        $img    = imagecreatefromgif(self::$tpl); 
     
        $width  = imagesx($img);
        $height = imagesy($img);
        $center = $width / 2;
     
        $rgb_letter = self::hexRgb(self::$letter);
        $rgb_left   = self::hexRgb(self::$left);
        $rgb_right  = self::hexRgb(self::$right);
        
        $lett  = imagecolorallocate($img, $rgb_letter['r'], $rgb_letter['g'], $rgb_letter['b']);
        $left  = imagecolorallocate($img, $rgb_left['r'], $rgb_left['g'], $rgb_left['b']);
        $right = imagecolorallocate($img, $rgb_right['r'], $rgb_right['g'], $rgb_right['b']);
     
        $palette = imagecolorstotal($img);   
        imagetruecolortopalette($img, true, $palette);
        
        if($ratio < 0)
        {    
            $size = $center - round($center * abs($ratio));
            imagefilledrectangle($img, $size, 3, $center, $height - 4, $left);
        }
        elseif($ratio > 0)
        {    
            $size = $center + round($center * abs($ratio));
            imagefilledrectangle($img, $center, 3, $size, $height - 4, $right);
        }
        
        $shift = $width - 4 - strlen(self::$row['rating_up']) * 6;    
       
        imagestring($img, 2, 6, 2, self::$row['rating_down'], $lett);
        imagestring($img, 2, $shift, 2, self::$row['rating_up'], $lett); 
     
        imagegif($img);
        imagedestroy($img);
    }      
    
}     
    

  
   
    
    
    
    
    
    
    
    
    
    
