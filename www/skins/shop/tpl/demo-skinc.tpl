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

	<script type="text/javascript" src="<?=TEMPLATE;?>js/jquery-2.min.js"></script>
	<script type="text/javascript" src="<?=TEMPLATE;?>js/jcarousellite_1.0.1.js"></script>
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
			<p id="reg-autch-blok" align="right"><a class="autch-top">Вход</a><a href="#">Регистрация</a></p>
		</div>
		<!-- line -->
		<div id="top-line"></div>
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
			<form action="" method="GET">
				<span></span>
				<input type="text" id="input-search" placeholder="Поиск по сайту" >
				<input type="submit" id="button-search" value="Поиск">
			</form>
		</div>
	</div><!-- blok header end -->
	<div id="top-menu-blok">
		<ul>
			<li><img src="<?=TEMPLATE;?>images/shop.png" alt=""><a href="#">Главная</a></li>
			<li><img src="<?=TEMPLATE;?>images/new-32.png" alt=""><a href="#">Новинки</a></li>
			<li><img src="<?=TEMPLATE;?>images/bestprice-32.png" alt=""><a href="#">Лидеры продаж</a></li>
			<li><img src="<?=TEMPLATE;?>images/sale-32.png" alt=""><a href="#">Распродажа</a></li>
		</ul>
		<p align="right" id="blok-basket"><img src="<?=TEMPLATE;?>images/cart-icon.png" alt=""><a href="#">Корзина пуста</a></p>
	<!-- line -->
		<div id="top-line" style="margin-top: 10px"></div>
	</div>
	
	<div id="blok-right"><!-- blok right start -->
		<div id="blok-category"><!-- blok-category start -->
			<p class="title-header">Категория товаров</p>
			<ul>
				<li><a href=""><img src="<?=TEMPLATE;?>images/mobile-icon.gif" class="cat-img" alt="">Мобильные телефоны</a>
						<ul class="category-section">
							<li><a href=""><strong>Все модели</strong></a></li>
							<li><a href="">werwerwerwerwer</a></li>
							<li><a href="">ewrwere ewrwerwerwe</a></li>
							<li><a href="">werewrwerw</a></li>
						</ul>
					</li>
				<li><a href=""><img src="<?=TEMPLATE;?>images/table-icon.gif" class="cat-img" alt="">Планшеты</a>
						
					</li>
				<li><a href=""><img src="<?=TEMPLATE;?>images/book-icon.gif" class="cat-img" alt="">Ноутбуки</a>
						
					</li>
			</ul>
		</div><!-- blok category end -->
		<div id="blok-parmetr"><!-- blok parametr start -->
			<p class="title-header">Поиск по параметру</p>
			<p class="title-filter">Стоимость</p>
				<form action="" method="GET">
					<div id="bloc-input-price">
						<ul>
							<li><p>от</p></li>
							<li><input type="text" id="price-start" name="price-start" value="1000"></li>
							<li>до</li>
							<li><input type="text" id="end-price" name="end-price" value="30000"></li>
							<li>руб.</li>
						</ul>
					</div>
					<div class="clear"></div>
					<div id="blok-treckbar"></div>
					<p class="title-filter">Производитель</p>	
					
					<ul class="checkbox-brend">
						<li><input type="checkbox" id="checkbrend-1" /><label for="checkbrend-1">Бренд1</label></li>
						<li><input type="checkbox" id="checkbrend-2" /><label for="checkbrend-2">Бренд1</label></li>
						<li><input type="checkbox" id="checkbrend-3" /><label for="checkbrend-3">Бренд1</label></li>
						<li><input type="checkbox" id="checkbrend-4" /><label for="checkbrend-4">Бренд1</label></li>
						<li><input type="checkbox" id="checkbrend-5" /><label for="checkbrend-5">Бренд1</label></li>
					</ul>
					<center><input type="submit" id="button-param-search" value=""></center>
				</form>
		</div><!-- blok parametr end -->
		<div id="blok-roll-news"><!-- blok-roll-news start -->
		<center><img id="img-prev" src="<?=TEMPLATE;?>images/img-prev.png" alt=""></center>
		
			<div id="newsticker">
				<ul>
					<li>
						<span>12.17.1987</span>
						<a href="#">10+ тонкостей HTML верстки</a>
						<p>
						О HTML верстке существует непомерное количество талмудов, учебников, уроков и статей. 
						Конкретно моя статья посвящена некоторым тонкостям, 
						с которыми приходится сталкиваться во время верстки новых проектов. 
						</p>
					</li>
					<li>
						<span>12.17.1987</span>
						<a href="#">10+ тонкостей HTML верстки</a>
						<p>
						О HTML верстке существует непомерное количество талмудов, учебников, уроков и статей. 
						Конкретно моя статья посвящена некоторым тонкостям, 
						с которыми приходится сталкиваться во время верстки новых проектов. 
						</p>
					</li>
					<li>
						<span>12.17.1987</span>
						<a href="#">10+ тонкостей HTML верстки</a>
						<p>
						О HTML верстке существует непомерное количество талмудов, учебников, уроков и статей. 
						Конкретно моя статья посвящена некоторым тонкостям, 
						с которыми приходится сталкиваться во время верстки новых проектов. 
						</p>
					</li>

				</ul>
			</div>
			<center><img id="img-next" src="<?=TEMPLATE;?>images/img-next.png" alt=""></center>
			
		</div><!-- blok-roll-news end -->
	</div><!-- blok right end -->
	<div id="blok-content"><!-- blok content start -->
		<div id="blok-sorting">
			<p id="nav-breadcrumbs"><a href="#">Главная страница</a> \ <span>Все товары</span></p>
				
				<ul id="option-list">
					<li>Вид:</li>
					<li><img id="style-grid" src="<?=TEMPLATE;?>images/icon-grid.png" alt=""></li>
					<li><img id="style-list" src="<?=TEMPLATE;?>simages/icon-list.png" alt=""></li>
					
					<li>Сортировать:</li>
					<li><a id="select-sort" href="">Без сортировки</a>
						<ul id="sorting-list">
							<li><a href="">От дешовых к дорогим</a></li>
							<li><a href="">От дорогих к дешовым</a></li>
							<li><a href="">Популярное</a></li>
							<li><a href="">Новинки</a></li>
							<li><a href="">От А до Я</a></li>
							
						</ul>

					</li>

				</ul>

		</div>

		<ul id="blok-tovar-grid">
			<li>
				<div id="blok-img-grid"><img src="<?=IRB_HOST;?>photo/img1.jpg" alt=""></div>
				<p class="style-title-grid"><a href="">Нназвание товара из моего магозина</a></p>
				<ul class="tovar-info-grid">
					<li><img src="<?=TEMPLATE;?>images/eye-icon.png" alt=""></li>
					<li><img src="<?=TEMPLATE;?>images/comment-icon.png" alt=""></li>
					<a href="" class="add-cart-style-grid"></a>
					<p class="style-price-grid"><strong>19000</strong>руб.</p>
					<div class="mini-features">qwwqeqweqwrwerwerwwrewrwerwerwerwerwerwerwerwerwer</div>
				</ul>
			</li>
		</ul>


	</div><!-- blok content end -->
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