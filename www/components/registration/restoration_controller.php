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


    if($GET['parent'] === 'code')
    {
        if($ok && !empty($POST['value1']))
        {
            if($userdata = look::autologin($POST['value1']))
            {
                $_SESSION['userdata'] = $userdata;
                redirect('mod=office');
            }
            else
                $info[] = IRB_LANG_INVALID_CODE;
        }
        elseif(empty($GET['id']))
            $info[] = IRB_LANG_MAIL_INFO;
            //если пуст
        $label = IRB_LANG_EMPTY_CODE;
    }
    else
    {
        if($ok)
        {    // Если есть уточнение, то дополняем зарос еще одним условием.
            $and = !empty($POST['value2']) ? " AND `login` = '". escapeString($POST['value2']) ."'" : '';

            $res = mysqlQuery("SELECT `email`, `id`
                               FROM `". IRB_DBPREFIX ."users`
                               WHERE `email` = '". escapeString($POST['value1']) ."'
                              " . $and
                              );
            // Если строчка одна - отправляем письмо
            if(mysqli_num_rows($res) == 1)
            {
                $row = mysqli_fetch_assoc($res);

                $hash = look::setlogin($row['id'], false);

                $subject = IRB_LANG_REST_RESTORATION;
                $message = IRB_LANG_REST_RESTORAT_FOR
                         . "<a href=\"". href('mod=restoration', 'parent=code', 'id='. $hash) ."\" >"
                         . IRB_LANG_REST_LINK ."</a><br />"
                         . IRB_LANG_REST_ACTIVATE_END . $hash ."</b><br>\n";

                $mail = new IRB_Mailer($message);

                $mail -> createTo($row['email']);
                $mail -> createSubject($subject);
                $mail -> createFrom(IRB_SUPPORT_EMAIL, IRB_SUPPORT_EMAIL);
                $mail -> setHtml();
                $error = $mail -> sendMail();

                if(!$error)
                    redirect('parent=code');
                else
                    $info[] = IRB_SISTEM_ERROR;

            }// Если строк больше одной, поставим флаг. А в шаблоне выдадим поле логина.
            elseif(mysqli_num_rows($res) > 1)
                $loginfield = true;
            else
                $info[] = IRB_LANG_NO_EMAIL;
        }

        $label = IRB_LANG_EMPTY_EMAIL;
    }

    $value1  = !empty($GET['id']) ? htmlChars($GET['id']) : htmlChars($POST['value1']);

    include IRB_ROOT .'/skins/tpl/registration/form_activate.tpl';







