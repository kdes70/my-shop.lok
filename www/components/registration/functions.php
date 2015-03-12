<?php

/**
* Библиотека функций для системы регистрации
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

/**
* Функция хэширования пароля.
* @param $pass string
* @return string
*/

    function criptPass($pass)
    {
        return md5(md5($pass) . IRB_CONFIG_SALT);
    }

/**
* Функция установки автологина
* @param integr
* return void
*/
    function setLogin($id, $auto = true)
    {
        $hash = md5(randStr() . $id);

        if(($ip = @$_SERVER['HTTP_X_FORWARDED_FOR']) === null)
            $ip =  $_SERVER['REMOTE_ADDR'];

        if($auto)
            setcookie('hash', $hash, time() + 2592000, '/');

        mysqlQuery("UPDATE `". IRB_DBPREFIX ."users`
                    SET  `hash`      = '". $hash ."',
                     `last_ip`   = `ip`,
                     `ip`        = '". $ip ."',
                     `last_date` = `date`,
                     `date`      = NOW(),
                    WHERE `id`  = ". (int)$id
                   );

    }

/**
* Проверка корректности электронного адреса
* @param string  $email
* @access private
* @return string or boolean
*/
   function checkEmail($email)
   {
       if (function_exists('filter_var'))
           return filter_var($email, FILTER_VALIDATE_EMAIL);
       else
           return preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $email);
   }


    // функция генерации пароля

   function generationPass()
   {
      $str = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";

        $str_lenght = strlen($str) - 1;

        $str_gen = '';

        for($i = 0; $i < LENGTH_PASS; $i++) {

          $x = mt_rand(0,$str_lenght);

          if($i != 0 ) {
            if($str_gen[strlen($str_gen) - 1] == $str[$x]) {
              $i--;
              continue;
            }
          }
          $str_gen .= $str[$x];
        }

        return $str_gen;
   }

   // еще одна функция генерации пароля

   function get_pass() {

    $gl = array('y','Y','e','E','u','U','i','I','o','O','a','A');

    $so = array('w','W','r','R','t','T','p','P','s','S','d','D','f','F',
   'g','G','h','H','j','J','k','K','l','L','z','Z','x','X','c','C',
   'v','V','b','B','n','N','m','M');

    $result = '';

    $v = mt_rand(1,20);
    if($v > 9) {
      ///gl-so
      for($i = 0; $i < LENGTH_PASS; $i+=2 ) {
        $in = mt_rand(0,count($gl)-1);
        $result .= $gl[$in];

        $in = mt_rand(0,count($so)-1);
        $result .= $so[$in];
      }
    }
    else {
      //so-gl
      for($j = 0; $j < LENGTH_PASS; $j+=2 ) {

        $in = mt_rand(0,count($so)-1);
        $result .= $so[$in];

        $in = mt_rand(0,count($gl)-1);
        $result .= $gl[$in];

      }
    }

    return $result;
   }














