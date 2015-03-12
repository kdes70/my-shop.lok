<?php

/**
* Класс проверки аутентификации
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
///////////////////////////////////////////////////////

class look
{

/**
* метод проверки аутентификации
* @param bool $redirect
* @return mixed
*/
    public static function check($redirect = true)
    {
        if(!isset($_SESSION['userdata']) && $redirect)
            reDirect('page=shop');
    // Проверка на бан
        elseif($redirect && isset($_SESSION['userdata']) && self::checkban($_SESSION['userdata']['id']))
            reDirect('page=ban');
        else
            return isset($_SESSION['userdata']);

    }

/**
* Метод установки данных пользователя
* @param $id integr
* @param $auto bool
* return string
*/
    public static function setlogin($id, $auto = false)
    {
        $hash = md5(randStr() . $id);

        if($auto)
            setcookie('hash', $hash, time() + 2592000, '/');

        if(($ip = @$_SERVER['REMOTE_ADDR']) === null)
            $ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];

        mysqlQuery("UPDATE `". IRB_DBPREFIX ."users`
                    SET  `hash`      = '". $hash ."',
                         `last_ip`   = `ip`,
                         `ip`        = '". sprintf("%u", ip2long($ip)) ."',
                         `last_date` = `date`,
                         `date`      = NOW()
                    WHERE `id`  = ". (int)$id
                 );

        return $hash;
    }

/**
* Поиск учетной записи по контрольному хэшу
* @param $hash string
* @param $check bool
* return mixed
*/
    public static function autologin($hash, $check = false)
    {
        if(IRB_REGISTRATION_ACTIVATE === 'on' && !$check)
            $activate = "\n AND `activate` = 1 ";
        else
            $activate = '';

        $res = mysqlQuery("SELECT `id`, `login`, `email`, `ban`
                            FROM `". IRB_DBPREFIX ."users`
                            WHERE `hash` = '". escapeString($hash) ."'
                            ". $activate
                            );

        if(mysqli_num_rows($res) > 0)
        {
            $userdata = mysqli_fetch_assoc($res);
            self::setlogin($userdata['id']);

            return $userdata;
        }
        else
            return false;
    }

/**
* Метод проверки блокировки аккаунта
* @param $id int
* return bool
*/
     public static function checkban($id)
     {
        $res = mysqlQuery("SELECT  `ban`
                            FROM `". IRB_DBPREFIX ."users`
                            WHERE `id` = ".(int)$id
                            );

        $row = mysqli_fetch_assoc($res);
        return ($row['ban'] > date('Y-m-d'));

    }
}






























