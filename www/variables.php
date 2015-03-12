<?php

/**
* Блок инициализации и обработки входящих переменных
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
       exit(file_get_contents('./404.html'));
    }

/**
* Убиваем магические кавычки
*/
    function stripslashesDeep($data)
    {
        if(is_array($data))
            $data = array_map("stripslashesDeep", $data);
        else
            $data = stripslashes($data);
        return $data;
    }

    if(get_magic_quotes_gpc())
    {
        $_GET = stripslashesDeep($_GET);
        $_POST = stripslashesDeep($_POST);
        $_COOKIE = stripslashesDeep($_COOKIE);
    }

/**
* Инициализация массива $GET
*/
    $GET = array(
                  'page'   => '',
                  'mod'    => 'read',
                  'parent' => 0,
                  'id'     => 0,
                  'num'    => 1,
                );

/**
* Инициализация переменных из GET-параметров
*/

    if(IRB_REWRITE === 'on' && !empty($_GET['route']))
    {
        $param = explode('/', trim($_GET['route'], '/'));
        $i = 0;

        foreach($GET as $var => $val)
        {
            if(!empty($param[$i]))
               $GET[$var] = $param[$i];

            $i++;
        }
    }
    elseif(!empty($_GET))
    {
        foreach($GET as $var => $val)
            if(!empty($_GET[$var]))
               $GET[$var] = $_GET[$var];
    }

/**
* Кнопки
*/
    $ok     = !empty($_POST['ok']);
    $auth   = !empty($_POST['auth']);
    $edit   = !empty($_POST['edit']);
    $delete = !empty($_POST['delete']);
    $remind = !empty($_POST['remind']);
/**
* Инициализация переменных POST
*/
    $POST = array(
                    'value1'  =>  '',
                    'value2'  =>  '',
                    'value3'  =>  '',
                    'value4'  =>  '',
                    'value5'  =>  '',
                    'value6'  =>  '',
                    'value7'  =>  '',
                    'value8'  =>  '',
                    'value9'  =>  '',
                    'value10' =>  '',
                    'array1'  => array(),
                    'array2'  => array(),
                  );

    if(!empty($_POST['form']))
        $POST = array_merge($POST, $_POST['form']);

/**
* Другие переменные
*/
   $info  = array();
   $META  = '';









