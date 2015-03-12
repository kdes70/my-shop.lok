<div id="blok-content"><!-- blok content start -->
	<div id="block-step">
		<div id="name-step">
			<ul>
				<li><a <?php $GET['mod'] == "oneclick" ? printf("class=\"active\"") : "" ?>  href="#">1. Корзина товаров</a></li>
				<li><span>&rarr;</span></li>
				<li><a <?php $GET['mod'] == "confirm" ? printf("class=\"active\"") : "" ?> href="">2. Контактная информация</a></li>
				<li><span>&rarr;</span></li>
				<li><a <?php $GET['mod'] == "completion" ? printf("class=\"active\"") : "" ?> href="">2. Завершение</a></li>
			</ul>
		</div>
		<p>шаг 1 из 3</p>
		<a href="<?php echo href('page=cart', 'mod=clear'); ?>">Очистить</a>
	</div>
		
	
	
<?php if(!empty($rows)) : ?>
	<div id="header-list-cart">
		<div id="header1">Изображение</div>
		<div id="header2">Наименование товара</div>
		<div id="header3">Кол-во</div>
		<div id="header4">Цена</div>
	</div>
<?php echo $rows; ?>

<h2 class="itog-price" align="right">Итого: <strong><?php echo $all_price; ?></strong> руб</h2>
<p align="right" class="button-next"><a href="<?php echo href('page=cart', 'mod=confirm'); ?>">Дальше</a></p>
<?php else :?>
	<h3 id="clear-cart" align="center">Корзина пуста!</h3>
<?php endif; ?>

	
		
<div class="clear"></div>

		
		

	</div><!-- blok content end -->