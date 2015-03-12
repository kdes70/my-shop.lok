<?php
/** 
* Заголовок определяет тип контента. Картинка формата GIF 
*/
    header('Content-type: image/gif'); 
/** 
* Устанавливаем ключ-константу 
*/    
    define('IRB_KEY', true);
    
/** 
* Подключаем файлы ядра 
*/     
    include '../config.php';
    include IRB_ROOT .'/libs/mysql.php';    
    include IRB_ROOT .'/libs/default.php';
 
    // Определм таблицу, для которой будем считать рейтинг    
    IRB_Rating::$table = IRB_DBPREFIX .'blog'; 
    // В это свойство нужно прописать путь до шаблона индикатора
    IRB_Rating::$tpl   = IRB_ROOT .'/skins/images/rating.gif';    
    // Считаем рейтинг для записи с ID, полученным из $_GET
    IRB_Rating::getRating($_GET['id']);  
    // Рисуем картинку индикатора
    IRB_Rating::createIndicator();

   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    