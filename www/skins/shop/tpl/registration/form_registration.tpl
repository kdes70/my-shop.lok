<script type="text/javascript">
$(document).ready(function() {
      $('#form_reg').validate(
				{
					// правила для проверки
					rules:{
						"form[value1]":{
							required:true,
							minlength:3,
                            maxlength:15,
                            remote: {
                            type: "post",
		                    url: "../ajax/check_login.php"
		                            }
						},
						"form[value2]":{
							required:true,
							minlength:7,
                            maxlength:15
						},
						"form[value3]":{
							required:true,
                            minlength:3,
                            maxlength:15
						},
						"form[value4]":{
							required:true,
                            minlength:3,
                            maxlength:15
						},
						"form[value5]":{
							required:true,
                            minlength:3,
                            maxlength:25
						},
						"form[value6]":{
						    required:true,
							email:true
						},
						"form[value7]":{
							required:true
                           // phoneUS:true
						},
						"form[value8]":{
							required:true
						},
						"reg_captcha":{
							required:true,
                            remote: {
                            type: "post",
		                    url: "../ajax/check_captcha.php"

		                            }

						}
					},

					// выводимые сообщения при нарушении соответствующих правил
					messages:{
						"form[value1]":{
							required:"Укажите Логин!",
                            minlength:"От 3 до 15 символов!",
                            maxlength:"От 3 до 15 символов!",
                            remote: "Логин занят!"
						},
						"form[value2]":{
							required:"Укажите Пароль!",
                            minlength:"От 7 до 15 символов!",
                            maxlength:"От 7 до 15 символов!"
						},
						"form[value3]":{
							required:"Укажите вашу Фамилию!",
                            minlength:"От 3 до 20 символов!",
                            maxlength:"От 3 до 20 символов!"
						},
						"form[value4]":{
							required:"Укажите ваше Имя!",
                            minlength:"От 3 до 15 символов!",
                            maxlength:"От 3 до 15 символов!"
						},
						"form[value5]":{
							required:"Укажите ваше Отчество!",
                            minlength:"От 3 до 25 символов!",
                            maxlength:"От 3 до 25 символов!"
						},
						"form[value6]":{
						    required:"Укажите свой E-mail",
							email:"Не корректный E-mail"
						},
						"form[value7]":{
							required:"Укажите номер телефона!"
						},
						"form[value8]":{
							required:"Необходимо указать адрес доставки!"
						},
						"reg_captcha":{
							required:"Введите код с картинки!",
                            remote: "Не верный код проверки!"
						}
					},

	submitHandler: function(form){
	$(form).ajaxSubmit({
	success: function(res) {

			console.log(res);

        if (res == 'true')
    {
    $("#block-form-registration").fadeOut(300,function() {
    $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");
    $("#form_submit").hide();
        setTimeout(function(){
            window.location.replace('http://my-shop.lok/');
        },1000);
       });

    }
    else
    {
       $("#reg_message").addClass("reg_message_error").fadeIn(400).html(res);
    }
		}
			});
			}
			});
    	});
</script>


<p id="reg_message" ><?php echo getInfo($info); ?></p>


<div id="block-form-registration">
<form method="post" id="form_reg">
<ul id="form-regist">

<li>
<label>Логин</label>
<span class="star" >*</span>
<input type="text" name="form[value1]" id="form[value1]"   />
</li>

<li>
<label>Пароль</label>
<span class="star" >*</span>
<input type="text" name="form[value2]" id="form[value2]" value="<?php echo $POST['value2']; ?>"  />
</li>

<li>
<label>Фамилия</label>
<span class="star" >*</span>
<input type="text" name="form[value3]" id="form[value3]" value="<?php echo $POST['value3']; ?>"  />
</li>

<li>
<label>Имя</label>
<span class="star" >*</span>
<input type="text" name="form[value4]" id="form[value4]" value="<?php echo $POST['value4']; ?>"  />
</li>

<li>
<label>Отчество</label>
<span class="star" >*</span>
<input type="text" name="form[value5]" id="form[value5]" value="<?php echo $POST['value5']; ?>"  />
</li>

<li>
<label>E-mail</label>
<span class="star" >*</span>
<input type="email" name="form[value6]" id="form[value6]" value="<?php echo $POST['value6']; ?>"  />
</li>

<li>
<label>Мобильный телефон</label>
<span class="star" >*</span>
<input type="tel" name="form[value7]" id="form[value7]" onkeyup="this.value = this.value.replace (/\D/, '')" value="<?php echo $POST['value7']; ?> "  pattern"^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" />
</li>

<li>
<label>Адрес доставки</label>
<span class="star" >*</span>
<input type="text" name="form[value8]" id="form[value8]" value="<?php echo $POST['value8']; ?>"  />
</li>

<li>
<div id="block-captcha">

<img src="<?php echo IRB_HOST; ?>components/captcha/reg_captcha.php" />
<input type="text" name="reg_captcha" id="reg-captcha"  />

<p id="reloadcaptcha">Обновить</p>
</div>
</li> 

<li><p align="right"><input type="submit" name="ok" id="form_submit" value="Регистрация" /></p></li>

</form>

</ul>

</div>





