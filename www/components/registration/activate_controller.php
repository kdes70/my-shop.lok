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

// Блок подтверждения
    if($ok && !empty($POST['value1']))
    {
        if($userdata = look::autologin($POST['value1'], true))
        {
            $_SESSION['userdata'] = $userdata;

            mysqlQuery("UPDATE `". IRB_DBPREFIX ."users`
                        SET  `activate` = 1
                        WHERE `id` = '". $userdata['id'] ."'
                       ") ;
// Удаляем устаревшие записи
           $res = mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."users`
                               WHERE `activate` != 1
                               AND `date` < NOW() - INTERVAL 10 DAY
                              ");

            redirect('mod=office');
        }
        else
            $info[] = IRB_LANG_INVALID_CODE;
    }
// Блок отправки письма
    if(isset($_SESSION['activate']))
    {
        unset($_SESSION['activate']);
        $res = mysqlQuery("SELECT `email`, `hash`
                           FROM `". IRB_DBPREFIX ."users`
                           WHERE `id` = ".(int)$GET['id']
                         );

        if(mysqli_num_rows($res) > 0)
        {
            $row = mysqli_fetch_assoc($res);
            $subject = IRB_LANG_ACTIVATION;
            $message = IRB_LANG_ACTIVATION_FOR
                     . "<a href=\"". href('mod=activate', 'parent=code', 'id='. $row['hash']) ."\" >"
                     . IRB_LANG_REST_LINK ."</a><br />"
                     . IRB_LANG_REST_ACTIVATE_END . $row['hash'] ."</b><br>\n";

            $mail = new IRB_Mailer($message);

            $mail -> createTo($row['email']);
            $mail -> createSubject($subject);
            $mail -> createFrom(IRB_SUPPORT_EMAIL, IRB_SUPPORT_EMAIL);
            $mail -> setHtml();
            $error = $mail -> sendMail();

            if(!empty($error))
                $info[] = IRB_SISTEM_ERROR;
        }
    }

    $label = IRB_LANG_MAIL_INFO;

    $value1  = !empty($GET['id']) ? htmlChars($GET['id']) : htmlChars($POST['value1']);

    include IRB_ROOT .'/skins/tpl/registration/form_activate.tpl';







