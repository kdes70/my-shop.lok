

<div id="blok-content"><!-- blok content start -->
	<div id="block-step">
		<div id="name-step">
			<ul>
				<li><a <?php $GET['mod'] == "oneclick" ? printf("class=\"active\"") : "" ?>  href="#">1. Корзина товаров</a></li>
				<li><span>&rarr;</span></li>
				
			</ul>
		</div>
		<p>шаг 1 из 3</p>
		<a href="<?php echo href('page=cart', 'mod=clear'); ?>">Очистить</a>
	</div>
		
<?php echo print_arr($_SESSION);?>	
<?php  //if(!empty($rows)) : ?>
<?php if(!empty($_SESSION['cart'])): ?>
	<div id="header-list-cart">
		<div id="header1">Изображение</div>
		<div id="header2">Наименование товара</div>
		<div id="header3">Кол-во</div>
		<div id="header4">Цена</div>
	</div>


<?php foreach ($_SESSION['cart'] as $key => $value):  ?>

<div class="block-list-cart">
		<div class="img-cart">
			<img src="/photo/<?php echo $value['image']; ?>" alt="">
		</div>
		<div class="title-cart">
			<p><a href=""><?php echo $value['name']; ?></a></p>
			<p class="cart-mini-features">
				<?php echo $value['descript']; ?>
			</p>
		</div>
		<div class="count-cart">
			<ul class="input-count-style">
				<li><p align="center" class="count-minus">-</p></li>
				<li>
					<p align="center">
						<input type="text" class="count-input" value="<?php echo $value['qty']; ?>" maxlength="3" onkeyup="this.value = this.value.replace (/\D/, '')">
					</p>
				</li>
				<li><p align="center" class="count-plus">+</p></li>
			</ul>
		</div>
		<div class="price-product-cart">
			<h5><span class="span-count"><?php echo $value['qty']; ?></span> x <span><?php echo $value['price']; ?></span></h5>
			<p><?php echo $value['sum']; ?></p>
		</div>
		<div class="delete-cart"><a  href="<?php echo href('page=cart', 'mod=delete', 'parent='.$tpl_cart_id); ?>" ><img src="<?=TEMPLATE;?>images/bsk_item_del.png" /></a></div>
		<div id="bottom-cart-line"></div>
	</div>

<?php endforeach; ?>

<h2 class="itog-price" align="right">Итого: <strong><?php echo $_SESSION['total_price']; ?></strong> руб</h2>
<p align="right" class="button-next"><a href="<?php echo href('page=cart', 'mod=confirm'); ?>">Дальше</a></p>
<?php  else :?>
	<h3 id="clear-cart" align="center">Корзина пуста!</h3>
<?php  endif; ?>

	
		
<div class="clear"></div>

		
		

	</div><!-- blok content end -->