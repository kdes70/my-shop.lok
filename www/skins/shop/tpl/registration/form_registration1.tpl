<div id="blok-content"><!-- blok content start -->
	<script type="text/javascript">
$(document).ready(function() {	
      $('#form-reg').validate(
				{	
					// правила для проверки
					rules:{
						"form[value1]":{
							required:false,
							minlength:5,
                            maxlength:15,
                            remote: {
                            type: "post",    
		                    url: "/reg/check_login.php"
		                            }
						},
						"reg_pass":{
							required:true,
							minlength:7,
                            maxlength:15
						},
						"reg_surname":{
							required:true,
                            minlength:3,
                            maxlength:15
						},
						"reg_name":{
							required:true,
                            minlength:3,
                            maxlength:15
						},
						"reg_patronymic":{
							required:true,
                            minlength:3,
                            maxlength:25
						},
						"reg_email":{
						    required:true,
							email:true
						},
						"reg_phone":{
							required:true
						},
						"reg_address":{
							required:true
						},
						"reg_captcha":{
							required: false //true,
                            remote: {
                            type: "post",    
		                    url: "/reg/check_captcha.php"
		                    
		                            }
                            
						}
					},

					// выводимые сообщения при нарушении соответствующих правил
					messages:{
						"form[value1]":{
							required:"Укажите Логин!",
                            minlength:"От 5 до 15 символов!",
                            maxlength:"От 5 до 15 символов!",
                            remote: "Логин занят!"
						},
						"reg_pass":{
							required:"Укажите Пароль!",
                            minlength:"От 7 до 15 символов!",
                            maxlength:"От 7 до 15 символов!"
						},
						"reg_surname":{
							required:"Укажите вашу Фамилию!",
                            minlength:"От 3 до 20 символов!",
                            maxlength:"От 3 до 20 символов!"                            
						},
						"reg_name":{
							required:"Укажите ваше Имя!",
                            minlength:"От 3 до 15 символов!",
                            maxlength:"От 3 до 15 символов!"                               
						},
						"reg_patronymic":{
							required:"Укажите ваше Отчество!",
                            minlength:"От 3 до 25 символов!",
                            maxlength:"От 3 до 25 символов!"  
						},
						"reg_email":{
						    required:"Укажите свой E-mail",
							email:"Не корректный E-mail"
						},
						"reg_phone":{
							required:"Укажите номер телефона!"
						},
						"reg_address":{
							required:"Необходимо указать адрес доставки!"
						},
						"reg_captcha":{
							required:"Введите код с картинки!",
                            remote: "Не верный код проверки!"
						}
					},
					
	submitHandler: function(form){
	$(form).ajaxSubmit({
	success: function(data) { 
								 
        if (data == 'true')
    {
       $("#block-form-regist").fadeOut(300,function() {
        
        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");
        $("#reg-button").hide();
        
       });
         
    }
    else
    {
       $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data); 
    }
		} 
			}); 
			}
			});
    	});
     
</script>
<form action="" id="form-reg" method="POST">
<h2 class="h2-title">Форма регистрации</h2>
<strong id="reg_message" style="color:red"><?php echo getInfo($info); ?></strong> 
<div id="block-form-regist">
<ul id="form-regist">
 	<li><label for="">Логин:</label>
	 	<span>*</span>
	 	<input type="text" width="50" name="form[value1]" id="reg-login">
 	</li>
 	<li><label for="">Пароль:</label>
	 	<span>*</span>
	 	<input type="text" name="form[value2]" id="reg-pass">
 	</li>
 	<!-- <li><label for="">Повтарите пароль:</label>
	 	<span>*</span>
	 	<input type="text" name="form[value3]" id="reg-wpass">
 	</li> -->
 	<li><label for="">Фамилия:</label>
	 	<span>*</span>
	 	<input type="text" id="reg_surname" name="form[value4]">
	 	<span class="reg_span_style" >Пример: Иванов</span>
 	</li>
<!-- Имя --> 	
	<li><label for="">Имя:</label>
	 	<span>*</span>
	 	<input type="text" id="reg_name" name="form[value3]">
	 	<span class="reg_span_style" >Пример: Иван</span>
 	</li>
 	
 	<li><label for="">Отчество:</label>
	 	<span>*</span>
	 	<input type="text" id="reg_patronymic" name="form[value5]">
	 	<span class="reg_span_style" >Пример: Иванович</span>
 	</li>
 	<li><label for="">E-mail:</label>
	 	<span>*</span>
	 	<input type="text" id="reg_email" name="form[value6]">
	 	<span class="reg_span_style" >Пример: ivanov@mail.ru</span>
 	</li>
 	<li><label for="">Телефон:</label>
	 	<span>*</span>
	 	<input type="text" id="reg_phone" name="form[value7]">
	 	<span class="reg_span_style" >Пример: 8 950 100 12 34</span>
 	</li>
 	<li><label for="">Адрес доставки:</label>
	 	<span>*</span>
	 	<input type="text" id="reg_address" name="form[value8]">
	 	<span class="reg_span_style">Пример: г. Москва,<br /> ул Интузиастов д 18, кв 58</span>
 	</li>
 	<li>
	 	<div id="block-captcha">
	 		<img src="reg/reg-captcha" alt="">
	 		<input type="text" name="reg-captcha" id="reg-captcha">
	 		<p id="reloadcaptcha">Обновить</p>
	 	</div>
 	</li>
 		<p align="right" class="button-next"><input id="reg-button" type="submit" name="" value="Регистрация"></p>
 		<?php echo dbg($_POST); ?>
 		<div class="clear"></div>
 	</form>


 <div class="clear"></div>
 </ul> 
 </div>
</div><!-- blok content end -->
 