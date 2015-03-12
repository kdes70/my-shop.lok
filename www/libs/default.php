<?php

/**
* Библиотека общих функций
* @author IT studio IRBIS-team
* @copyright © 2011 IRBIS-team
*/
/////////////////////////////////////////////////////////

/**
* Generation of page of an error at access out of system
* Генерация страницы ошибки при доступе вне системы
*/
    if(!defined('IRB_KEY'))
    {
       header("HTTP/1.1 404 Not Found");
       exit(file_get_contents('../404.html'));
    }

/**
* Функция формирования GET-параметров
*/
    function href()
    {
        global $GET;
        $tmp = $GET;
        $href = '';
        $host = IRB_HOST;

        $arg = func_get_args();

        if(defined('IRB_ADMIN'))
            $host .= 'admin/';

        if($arg[0] == 'host')
            return IRB_HOST;

        if(is_array($arg[0]))
            $arg = $arg[0];

        foreach($arg as $var)
        {
            $param = explode('=', $var);

            if(array_key_exists($param[0], $tmp))
                $tmp[$param[0]] = $param[1];
            else
                die('The variable <b>'. $param[0] .'</b> is not defined');
        }

        $cnt = array_flip(array_keys($tmp));
        $tmp = array_slice($tmp, 0, $cnt[$param[0]] + 1);

        foreach($tmp as $var => $val)
            if(IRB_REWRITE === 'on')
                $href .= '/'. $val;
            elseif(!empty($val))
                $href .= '&'. $var .'='. $val;

        if(IRB_REWRITE === 'on')
            return $host . hrefTrim($href);
        else
            return $host .'?'. trim($href, '&');
    }

/**
* Адаптированная обертка функции trim()
*/
    function hrefTrim($link)
    {
        return preg_replace('#(/0)+$#', '', ltrim($link, '/'));
    }
/**
* Автозагрузка классов
*/
    function __autoload($classname)
    {
        global $INCLUDE_PATCH;

        foreach ($INCLUDE_PATCH as $include_path)
        {
            $class = IRB_ROOT .'/'. $include_path .'/'. strtolower($classname) .'.php';

            if(file_exists($class))
            {
                include_once $class;
                break;
            }
        }
    }

/**
* Функция перенаправления
*/
    function reDirect()
    {
        $arguments = func_get_args();

        if(count($arguments))
            header('location: '. href($arguments));
        else
            header('location: '. str_replace("/index.php", "", $_SERVER['HTTP_REFERER']));

        exit();

    }

/**
* Вывод информации
*/
    function getInfo($info)
    {
        if(count($info))
            return '<br>' . implode('<br>', $info);
        else
            return '&nbsp;';
    }


/**
* Возврат чекбоксов
* @param $id integr
* @param $return integr
* @return string
*/
    function returnCheck($id, $return)
    {
        if(is_array($return))
        {
         return in_array($id, $return) ? 'checked="checked"' : NULL;
        }
        else
        {
            return ($id == $return) ? 'checked="checked"' : NULL;
        }

    }

/**
* Возврат селектов
* @param $id integr
* @param $return integr
* @return string
*/
    function returnSelect($id, $return)
    {
       return ($id == $return) ? 'selected="selected"' : NULL;
    }


 /**
* Функция генерации случайной строки
* @param $len integr
* return string
*/
    function randStr($len = 10)
    {
        $arr = array_merge(range('#', '&'), range(0, 9), range('a', 'z'));
        shuffle($arr);
        return implode('', array_slice($arr, 0, $len));
    }

/**
* Функция беззнакового представления числа
* @param $number integr
* return integr
*/
    function unsignet($number)
    {
        return ($number > 0) ? $number : 0;
    }

/**
* Функция очистки массивов от пустых значений
* @param $number integr
* return bool
*/
    function emptyfilter($val)
    {
        return (bool)$val;
    }

