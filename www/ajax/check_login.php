<?php

/**
* Устанавливаем ключ-константу
*/
    define('IRB_KEY', true);

	include '../config.php';

    include IRB_ROOT .'/libs/mysql.php';
    include IRB_ROOT .'/libs/default.php';
    include IRB_ROOT .'/variables.php';

 /**
   * Проверка логина на дубликат
   */




if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $res = mysqlQuery("SELECT `login` FROM `". IRB_DBPREFIX ."users` WHERE `login` = '".escapeString($POST['value1'])."'");

        if(mysqli_num_rows($res) > 0)
        {
            echo 'false';
        }
        else
        {
            echo 'true';
        }
}






 ?>
