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
// Ставим на страничку кабинета замок
    look::check();

    //$email = htmlChars($_SESSION['userdata']['email']);


// Блок редактирования учетных данных
    if($edit)
    {


      if($_SESSION['userdata']['password'] != criptPass($POST['value1']))
      {
           $info[] = IRB_LANG_INVALID_PASSWORD;
      }
      else
      {
          if($POST['value2'] != "")
          {
               if(mb_strlen($POST['value2'], 'utf-8') < 6 || mb_strlen($POST['value2'], 'utf-8') > 15)
               $info[] = IRB_LANG_SHORT_PASSWORD. "gghjhjhj";
          }
          if(mb_strlen($POST['value3'], 'utf-8') < 3 || mb_strlen($POST['value3'], 'utf-8') > 30)
          {
              $info[] = IRB_LANG_SURNAME_WRONG;
          }
          if(mb_strlen($POST['value4'], 'utf-8') < 3 || mb_strlen($POST['value4'], 'utf-8') > 30)
          {
              $info[] = IRB_LANG_NAME_WRONG;
          }
          if(mb_strlen($POST['value5'], 'utf-8') < 3 || mb_strlen($POST['value5'], 'utf-8') > 30)
          {
              $info[] = IRB_LANG_PATRONYMIC_WRONG;
          }
          if(!checkEmail($POST['value6']))
          {
              $info[] = IRB_LANG_INVALID_EMAIL;
          }
          if (preg_match('/^\([0-9]{3}\)[0-9]{3}-[0-9]{2}\-[0-9]{2}/', $POST['value7']))
          {
              $info[] = 'не коректный номер телефона';
          }
           if(strlen($POST['value8']) == "")
          {
            $info[] = 'Укажите адрес доставки!';
          }

      }
      if(count($info))
      {
        $_SESSION['msg'] = "<p align='left' id='form-error' class='reg_message_error'>".implode('<br />',$info)."</p>";
      }
      else{
          $_SESSION['msg'] = "<p align='left' id='form-success' class='reg_message_good'>Данные успешно сохранены!</p>";

            // если поле нового пароля не заполнено то заменяем на старый
          empty($POST['value2'])? $POST['value2'] = $POST['value1']: $POST['value2'] = $POST['value2'];

          mysqlQuery("INSERT INTO `". IRB_DBPREFIX ."users`
                              SET
                                 `id`         = ". (int)$_SESSION['userdata']['id'] .",
                                 `password`   = '". criptPass($POST['value2']) ."',
                                 `email`      = '". escapeString($POST['value6']) ."',
                                 `surname`    = '".escapeString($POST['value3'])."',
                                 `name`       = '".escapeString($POST['value4'])."',
                                 `patronymic` = '".escapeString($POST['value5'])."',
                                 `phone`      = '".$POST['value7']."',
                                 `address`    = '".escapeString($POST['value8'])."'
                              ON DUPLICATE KEY UPDATE
                                 `password`   = '". criptPass($POST['value2']) ."',
                                 `email`      = '". escapeString($POST['value6']) ."',
                                 `surname`    = '".escapeString($POST['value3'])."',
                                 `name`       = '".escapeString($POST['value4'])."',
                                 `patronymic` = '".escapeString($POST['value5'])."',
                                 `phone`      = '".$POST['value7']."',
                                 `address`    = '".escapeString($POST['value8'])."'"
                              );
          reDirect();

      }
    }

    $res = mysqlQuery("SELECT `id`, `login`, `password`, `name`, `email`, `surname`, `phone`,
                          `patronymic`, `patronymic`, `address`, `ban`
                     FROM `". IRB_DBPREFIX ."users`
                     WHERE `id` = ".(int)$_SESSION['userdata']['id']."

                    ");
    if(mysqli_num_rows($res) > 0)
        {
           $_SESSION['userdata'] = htmlChars(mysqli_fetch_assoc($res));
        }






    include IRB_ROOT . TEMPLATE .'/tpl/registration/form_profile.tpl';



