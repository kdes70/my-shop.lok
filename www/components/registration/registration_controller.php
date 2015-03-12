<?php


/**
* Кнтроллер
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
* Регистрация нового пользователя
*/

 if($ok)
    {

        if(empty($POST['value1']))
        {

          echo  $info[] = IRB_LANG_EMPTY_LOGIN;

        }

        elseif(mb_strlen($POST['value1'], 'utf-8') < 3 || mb_strlen($POST['value1'], 'utf-8') > 15)
        { //Проверяем на длину логина
          echo  $info[] = IRB_LANG_INVALID_LOGIN;

        }
            //проверяем длину пароля
        if(empty($POST['value2']))
        {
          echo  $info[] = IRB_LANG_EMPTY_PASSWORD;

        }

         elseif(mb_strlen($POST['value2'], 'utf-8') < 6)
         {
          echo  $info[] = IRB_LANG_SHORT_PASSWORD;

         }

        //Проверяем ФИО
        if(empty($POST['value3']))
        {
          echo  $info[] = IRB_LANG_EMPTY_INPUT;
        }

        if(empty($POST['value4']))
        {
          echo  $info[] = IRB_LANG_EMPTY_INPUT;
        }

        if(empty($POST['value5']))
        {
           echo $info[] = IRB_LANG_EMPTY_INPUT;

        }

            //Валидация E-maila
        if(empty($POST['value6']))
        {
          echo  $info[] = IRB_LANG_EMPTY_EMAIL;
        }

        elseif(!checkEmail($POST['value6']))
        {
          echo  $info[] = IRB_LANG_INVALID_EMAIL;

        }


        //Проверка телефона
        if(empty($POST['value7']))
        {
           echo  $info[] = IRB_LANG_EMPTY_PHONE;
        }

        if (preg_match('/^\([0-9]{3}\)[0-9]{3}-[0-9]{2}\-[0-9]{2}/', $POST['value7']))
        {
           echo  $info[] = 'не коректный номер телефона';


        }



        //проверяем адрес
        if(empty($POST['value8']))
        {
         echo $info[] = IRB_LANG_EMPTY_ADDRESS;

        }

        //Проверим капчу
 if($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha']))
 {
    echo $info[] = 'Не верное значение капчи!';
        unset($_SESSION['img_captcha']);

 }


        //Если все хорошо записываем в БД
        if(empty($info))
        {
            $activate = (IRB_REGISTRATION_ACTIVATE === 'off') ? ",\n `activate` = 1 " : '';

            mysqlQuery("INSERT IGNORE INTO `". IRB_DBPREFIX ."users`
                        SET
                        `date_registration` = NOW(),
                        `login`             = '". escapeString($POST['value1']) ."',
                        `password`          = '". criptPass($POST['value2']) ."',
                        `email`             = '". escapeString($POST['value6']) ."',
                        `surname`           = '".escapeString($POST['value3'])."',
                        `name`              = '".escapeString($POST['value4'])."',
                        `patronymic`        = '".escapeString($POST['value5'])."',
                        `phone`             = '".$POST['value7']."',
                        `address`           = '".escapeString($POST['value8'])."'

                        ". $activate

                        );

            if(($id = mysqli_insert_id(DB::$link)) > 0)
            {
                look::setlogin($id);
            // Если активация включена - отпрвляем на подтверждение. Если нет - сразу в кабинет
                if(IRB_REGISTRATION_ACTIVATE === 'on')
                {// В сессии определим флаг, дабы уберечься от F5
                    $_SESSION['activate'] = true;
                 // Поехали на страницу активации
                    reDirect('mod=activate', 'parent=id', 'id='. $id);
                }
                else{
                    echo 'true';

                     $_SESSION['userdata']['id'] = $id;
                     $_SESSION['userdata']['login'] = htmlChars($POST['value1']);
                     $_SESSION['userdata']['name'] = htmlChars($POST['value4']);
                     $_SESSION['userdata']['password'] = criptPass($POST['value2']);
                     $_SESSION['userdata']['email'] = htmlChars($POST['value6']);
                     $_SESSION['userdata']['surname'] = htmlChars($POST['value3']);
                     $_SESSION['userdata']['patronymic'] = htmlChars($POST['value5']);
                     $_SESSION['userdata']['phone'] = htmlChars($POST['value7']);
                     $_SESSION['userdata']['address'] = htmlChars($POST['value8']);

                    exit;
                }


            }
            else
              echo  $info[] = IRB_LANG_NO_UNIQUE_LOGIN;
             exit;
        }
    }

include IRB_ROOT . TEMPLATE .'/tpl/registration/form_registration.tpl';




