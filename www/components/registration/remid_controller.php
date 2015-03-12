<?php
/**
* Кнтроллер
* @author Webdim-Sudio
* @copyright © 2014 Webdim-Sudio
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



if($_SERVER['REQUEST_METHOD'] == "POST")
{
     $email = $POST['value4'];

    if ($email != "")
    {   //если поле не пустое идем дальше



        if(!checkEmail($email))
        {   // если Email не валиден выводим ошибку
            echo IRB_LANG_INVALID_EMAIL;
           // exit;
        }
        else
        {


           // если все хорошо проверяем в бд
             // Если есть уточнение, то дополняем зарос еще одним условием.
            $and = !empty($POST['value5']) ? " AND `login` = '". escapeString($POST['value5']) ."'" : '';

            $res = mysqlQuery("SELECT `email`, `login`
                                FROM `". IRB_DBPREFIX ."users`
                                WHERE `email` = '".escapeString($email)."'". $and);
            // Если строчка одна - отправляем письмо
            if(mysqli_num_rows($res) == 1)
            {
                 $row = mysqli_fetch_assoc($res);
                //генерируем новый пароль
               $newpass = get_pass();
               $pass = criptPass($newpass);
               // обновляем в базе
               mysqlQuery("UPDATE `". IRB_DBPREFIX ."users`
                            SET `password` = '".$pass."'
                            WHERE `email`= '".$row['email']."'");

              //  echo $pass;


                $subject = IRB_LANG_REST_RESTORATION;
                $message = IRB_LANG_REST_RESTORAT_FOR
                         . IRB_LANG_REST_ACTIVATE_END . $newpass ."<br>Ваш логин:".$row['login']."<br><br><br>\n"
                         .IRB_LANG_REST_LINK;

                $mail = new IRB_Mailer($message);

                $mail -> createTo($row['email']);
                $mail -> createSubject($subject);
                $mail -> createFrom(IRB_SUPPORT_EMAIL, IRB_SUPPORT_EMAIL);
                $mail -> setHtml();
                $error = $mail -> sendMail();

                if(!$error){
                   echo 'yes';
                }
                else{
                   echo 'Произошла ошибка отправки письма';
                }

            }
            // Если строк больше одной, поставим флаг. А в шаблоне выдадим поле логина.
            elseif(mysqli_num_rows($res) > 1)
            {   // $loginfield = true;
                echo 'to_login';
            }
            else

                echo 'Данный E-mail не найден!';


         }



    }
    else
        echo 'Укажите ваш Email';
        exit;


}
