<?php 

/** 
* Устанавливаем ключ-константу 
*/    
    define('IRB_KEY', true);

	include '../config.php';

    include IRB_ROOT .'/libs/mysql.php';    
    include IRB_ROOT .'/libs/default.php';
    
function criptPass($pass)
    {
        return md5(md5($pass) . IRB_CONFIG_SALT);
    } 


 /**
   * Проверка логина на дубликат
   */
   if($_SERVER['REQUEST_METHOD'] == "POST")
   {  
    
     

        $res = mysqlQuery("SELECT `id`, `login`, `email`, `ban`   
                           FROM `". IRB_DBPREFIX ."users`   
                           WHERE `login`   = '". escapeString($_POST['login']) ."'
                           AND   `password` = '". criptPass($_POST['pass']) ."'  
                          "); 
                          
        if(mysqli_num_rows($res) > 0)
        {   
            

            $_SESSION['userdata'] = mysqli_fetch_assoc($res);

            echo 'yes_auth';
          //  include IRB_ROOT .'/skins/tpl/registration/yes_auth.tpl';
            // Если стоит галочка, значит элемент value3 не пустой. 
            // Вторым аргументом передаем true - устанавливаем куку.
            $auto = !empty($POST['value3']);
            look::setlogin($_SESSION['userdata']['id'], $auto);
            
            
           // reDirect('mod=office');
        }
        else
            $info[] = IRB_LANG_ERROR_USERDATA;

   }


 ?>