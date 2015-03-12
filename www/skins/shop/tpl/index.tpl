<!Doctype html>
<!--[if IE 7 ]><html class="ie7"> <![endif]-->
<!--[if IE 8 ]><html class="ie8"> <![endif]-->
<!--[if IE 9 ]><html class="ie9"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html> <!--<![endif]-->
<head>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

	<link type="text/css" rel="stylesheet" href="<?=TEMPLATE;?>css/style.css" media="all" />

	<link type="text/css" rel="stylesheet" href="<?=TEMPLATE;?>trackbar/trackbar.css" media="all" />

	 <script type="text/javascript" src="<?=TEMPLATE;?>js/jquery-1.11.0.min.js"></script>
	 <!-- <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
	<script type="text/javascript" src="<?=TEMPLATE;?>js/jcarousellite_1.0.1.js"></script>
	<script type="text/javascript" src="<?=TEMPLATE;?>js/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="<?=TEMPLATE;?>trackbar/jquery.trackbar.js"></script>
	<script type="text/javascript" src="<?=TEMPLATE;?>trackbar/TextChange.js"></script>



	<script type="text/javascript" src="<?=TEMPLATE;?>js/jquery.form.js"></script>
	<script type="text/javascript" src="<?=TEMPLATE;?>js/jquery.validate.js"></script>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	 <script type="text/javascript" src="<?=TEMPLATE;?>js/shop-script.js"></script>

	<title>Мой Магазин</title>

</head>

<body>
<div id="blok-body">
	<div id="blok-header"><!-- blok header start -->
		<div id="header-top-blok">
			<ul id="header-top-menu">
				<li>Ваш город - <span>Томск</span></li>
				<li><a href="#">О нас</a></li>
				<li><a href="#">Магазины</a></li>
				<li><a href="#">Контакты</a></li>
			</ul>
	<!-- блок панели входа -->
	<p id="reg-autch-blok" align="right">
	<?php if(isset($_SESSION['userdata']['id'])) :?>
		<!-- если пользователь авторизован -->

		<p id="auth-user-info" align="right"><img src="<?=TEMPLATE;?>images/user.png" alt="">Добро пожаловать: <?php echo $_SESSION['userdata']['name']; ?></p>
	<?php else: ?>
		<!-- если пользователь не авторизован -->
		<a class="autch-top" >Вход</a>
		<a href="<?php echo href('page=registration', 'mod=registration');?>">Регистрация</a>
	<?php endif; ?>
	</p><!-- блок панели входа -->
<!-- форма входа -->
<div id="block-top-auth">
<div class="corner"></div>
<form  method="POST" id="auth_form" action="">
	<ul id="input-auth">
	<h3>Вход</h3>

	<!-- Неверный логин и (или) Пароль -->

		<p id="message-auth"></p>

		<li><center><input name="form[value1]" id="auth_login" type="text" placeholder="Логин или Email" autofocus></center></li>
		<li><center><input name="form[value2]" type="password" id="auth_pass" placeholder="Пароль" /><span id="button-pass-show-hide" class="pass-show"></span></center></li>
		<ul id="list-auth">
			<li>
				<input type="checkbox" name="form[value3]" id="rememberme" >
				<label for="rememberme">Запомнить меня</label>
			</li>

			<li><a href="#" id="remid-pass">Забыли пароль?</a></li>

			<!-- <p align="right" name="ok" id="button-auth"><a>Вход</a></p> -->
			<p align="right" name="ok" id="button-auth"><input type="submit" name="auth" id="auth" value="Войти" /></p>
			<!-- <p align="right" id="button-auth"><input type="submit" name="ok" id="button-auth" value="Вход" /></p> -->


			<p align="right" class="auth-loading"><img src="<?=TEMPLATE;?>images/loading.gif" alt=""></p>
			<div class="clear"></div>
		</ul>
	</ul>
</form>
	<!-- блок востоновления пароля -->
	<div id="block-remind">
		<h3>Восстановление<br /> пароля</h3>
		<p id="message-remind" class="message-remind-success" ></p>
		<center><p><input type="email" id="remind-email" placeholder="Ваш E-mail" autofocus /></p></center>
		<center><p><input type="text" id="remind-login" placeholder="Ваш Login"/></p></center>
		<p align="right"><input type="submit" name="remind" id="remind" value="Войти" /></p>
		<p align="right" class="auth-loading" ><img src="<?=TEMPLATE;?>images/loading.gif" /></p>
		<p id="prev-auth">Назад</p>
	</div>
</div>
</div>

	<!-- line -->
		<div id="top-line"></div>

<div id="block-user" >
<div class="corner2"></div>
<ul>
<li><img src="<?=TEMPLATE;?>images/user_info.png" /><a href="<?php echo href('page=registration', 'mod=profile'); ?>">Профиль</a></li>
<li><img src="<?=TEMPLATE;?>images/logout.png" /><a id="logout" href="<?php echo href('page=registration', 'mod=exit'); ?>" >Выход</a></li>
</ul>
</div>



        <img id="img-logo" src="<?=TEMPLATE;?>images/logo.png" alt="Логотип Моего магаза" />
       <!--  blok info -->
        <div id="header-info">
        	<p align="right">Звонок бесплатный</p>
        	<h3 align="right">8 (800) 200 60 30</h3>
        	<img src="<?=TEMPLATE;?>images/phone-icon.png" alt="phone-icon" />

        	<p align="right">Режим работы:</p>
        	<p align="right">Буднии дни: с 9:00 до 18:00</p>
        	<p align="right">Суббота, Воскресение - выходные</p>
            <img src="<?=TEMPLATE;?>images/time-icon.png" alt="time-icon" />
        </div>
		<div id="search-blok">
			<form action="<?php echo IRB_HOST; ?>" method="GET" >
				<span></span>
				<input type="hidden" name="page" value="search">
				<input type="search" name="id" id="input-search" placeholder="Поиск по сайту" >
				<input type="submit" id="button-search" value="Поиск">


			</form>
			<ul id="result-search">


			</ul>
		</div>
	</div><!-- blok header end -->
	<div id="top-menu-blok">
		<ul>
			<li><img src="<?=TEMPLATE;?>images/shop.png" alt=""><a href="<?php echo href('host'); ?>">Главная</a></li>
			<li><img src="<?=TEMPLATE;?>images/new-32.png" alt=""><a href="<?php echo href('page=shop', 'mod=new'); ?>">Новинки</a></li>
			<li><img src="<?=TEMPLATE;?>images/bestprice-32.png" alt=""><a href="<?php echo href('page=shop', 'mod=hits'); ?>">Лидеры продаж</a></li>
			<li><img src="<?=TEMPLATE;?>images/sale-32.png" alt=""><a href="<?php echo href('page=shop', 'mod=sale'); ?>">Распродажа</a></li>
		</ul>

		<p align="right" id="blok-basket"><img src="<?=TEMPLATE;?>images/cart-icon.png" alt="">
			<?php if(isset($_SESSION['total_quantity'])): ?>
				<a href="<?php echo href('page=cart', 'mod=oneclick'); ?>">Товаров в корзине: 
				<span><?php echo $_SESSION['total_quantity']; ?></span><br/>
				на сумму : <span><?php echo $_SESSION['total_price']; ?></span></a>
			<?php else: ?>
				<a>Корзина пуста</a>

			<?php endif; ?>
			
		</p>
	<!-- line -->
		<div id="top-line" style="margin-top: 10px"></div>
	</div>

 
 

	<?php echo $content; ?>


	<div class="clear"></div>

	<div id="top-line"></div>
	<div id="blok-footer">

		<div id="footer-phone">
			<h4>Служба поддержки</h4>
			<h3>8 (800) 100-10-20</h3>
			<p>Режим работы:<br/>
			Буднии дни: с 9:00 до 18:00<br/>
			Суббота, Воскресение - выходной
			</p>
		</div>
		<div class="footer-list">
			<p>Сервис и Помошь</p>
			<ul>
				<li><a href="">Как сделать заказ</a></li>
				<li><a href="">Способы оплаты</a></li>
				<li><a href="">Возврат</a></li>
				<li><a href="">Публичная оферта</a></li>
			</ul>

		</div>
		<div class="footer-list">
			<p>О компании:</p>
			<ul>
				<li><a href="">О нас</a></li>
				<li><a href="">Вакансии</a></li>
				<li><a href="">Партнерам</a></li>
				<li><a href="">Контакты</a></li>
			</ul>

		</div>
		<div class="footer-list">
			<p>Навигация</p>
			<ul>
				<li><a href="">Главная страница</a></li>
				<li><a href="">Обратная связь</a></li>
			</ul>
			<p>Раскозать о себе</p>
<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,nocounter,theme=08" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,bookmark,print"></div>
		</div>
	</div>
</div>


</body>
</html>
