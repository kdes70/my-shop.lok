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
       exit(file_get_contents('../../404.html'));
    }
       
//////////////////////////////

// Блок бана
    if(!empty($POST['array1']))
    { 
        $id = array_keys($POST['array1']);
        $id = $id[0];    
    // Забанить 
        if($ok)
        {
            mysqlQuery("UPDATE `". IRB_DBPREFIX ."users`
                         SET   `ban` = NOW() + INTERVAL ".(int)$POST['value1'] ." DAY
                         WHERE `id` = ".(int)$id
                         );
         
            reDirect();
        }
    // Разбанить
        if($delete)
        {
            mysqlQuery("UPDATE `". IRB_DBPREFIX ."users`
                         SET   `ban` = '0000-00-00 00:00:00'
                         WHERE `id` = ".(int)$id
                         );
         
            reDirect();
        }
    // Достанем логин для уверенности
        $res = mysqlQuery("SELECT `login`
                             FROM `". IRB_DBPREFIX ."users`
                             WHERE `id` = ".(int)$id
                            );
        
        $row   = mysqli_fetch_assoc($res);    
        $login = $row['login'];    
        
        include IRB_ROOT .'/skins/tpl/admin/users/ban.tpl';    
    }
    else
    {
    // Блок удаления учетной записи
        if(!empty($POST['array2']))
        {
            $id = array_keys($POST['array2']);
         
            mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."users`
                         WHERE `id` = ".(int)$id[0]
                         );
         
            mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."users_setting`
                         WHERE `id_parent` = ".(int)$id[0]
                         );
            
            reDirect();
        }
     
    // Блок чтения информации  
     
        if($ok)
        {
            $where = !empty($POST['value1']) ? "WHERE `login` LIKE '%". escapeString($POST['value1']) ."%'"
                                              . " OR  `email` LIKE '%". escapeString($POST['value1']) ."%'"
                                              . " OR  `id` = ".(int)$POST['value1'] : '';
        }
        else
            $where = '';
     
        $pag = new IRB_Paginator($GET['num'], IRB_CONFIG_NUM_ROWS);
        
        $res = $pag -> countQuery("SELECT `id`, `login`, `email`, `date_registration`,
                                          INET_NTOA(`ip`) AS `ip`, 
                                          INET_NTOA(`last_ip`) AS `last_ip`, 
                                          `date`, `last_date`, `activate`, `ban` 
                                     FROM `". IRB_DBPREFIX ."users`
                                     ". $where ."
                                     ORDER BY `date_registration` DESC"
                                    ); 
        
        $count_user = $pag -> TableCount;
        $page_menu  = $pag -> createMenu();
        
        $tpl   = getTpl('admin/users/row');
        $users = '';
        $num   = ($GET['num'] > 1) ? $GET['num'] * IRB_CONFIG_NUM_ROWS - IRB_CONFIG_NUM_ROWS - 1 : 1;
        while($row = htmlChars(mysqli_fetch_assoc($res)))
        {
            $row['num'] = $num++;
            $users .= parseTpl($tpl, $row);
        }
     
        include IRB_ROOT .'/skins/tpl/admin/users/show.tpl';
    }
    
    
 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    