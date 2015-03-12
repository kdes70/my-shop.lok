<div id="blok-content"><!-- blok content start -->
	<div id="block-step">
		<div id="name-step">
			<ul>
				<li><a <?php $GET['mod'] == "oneclick" ? printf("class=\"active\"") : "" ?>  href="<?php echo href('page=cart', 'mod=oneclick'); ?>">1. Корзина товаров</a></li>
				<li><span>&rarr;</span></li>
				<li><a <?php $GET['mod'] == "confirm" ? printf("class=\"active\"") : "" ?> href="<?php echo href('page=cart', 'mod=confirm'); ?>">2. Контактная информация</a></li>
				<li><span>&rarr;</span></li>

			</ul>
		</div>
		<p>шаг 2 из 3</p>

	</div>

	<h3 class="title-h3">Способы доставки:</h3>

<form action="" method="POST">

<?php if(isset($_SESSION['order']['dostavka']) == "По почте") $check1 = "checked";?>
<?php if(isset($_SESSION['order']['dostavka']) == "Курьером") $check2 = "checked";?>
<?php if(isset($_SESSION['order']['dostavka']) == "Самовывоз") $check3 = "checked";?>
	<ul>
		<li>
			<input type="radio" name="form[value1]" class="order_delivery" id="order_delivery1" value="По почте" <?php $check1; ?> />
			<label class="label_delivery" for="order_delivery1">По почте</label>
		</li>
		<li>
			<input type="radio" name="form[value1]" class="order_delivery" id="order_delivery2" value="Курьером" <?php $check2; ?>/>
			<label class="label_delivery" for="order_delivery2">Курьером</label>
		</li>
		<li>
			<input type="radio" name="form[value1]" class="order_delivery" id="order_delivery3" value="Самовывоз" <?php $check3; ?>/>
			<label class="label_delivery" for="order_delivery3">Самовывоз</label>
		</li>
	</ul>

	<h3 class="title-h3">Информация для доставки:</h3>

<p id="message" ><?php echo getInfo($info); ?></p>

<ul id="info-order">
<?php if(!isset($_SESSION['userdata'])): ?>
	<li><label for="order_fio"><span>*</span>ФИО</label>
		<input type="text" name="form[value2]" id="order_fio" value="<?php echo !empty($_SESSION["order"]['fio']); ?>" />
		<span class="order_span_style" >Пример: Иванов Иван Иванович</span>
	</li>
	<li><label for="order_email"><span>*</span>E-mail</label>
		<input type="email" name="form[value3]" id="order_email" value="<?php echo isset($_SESSION["order"]['email']); ?>" />
		<span class="order_span_style" >Пример: ivanov@mail.ru</span>
	</li>
	<li><label for="order_phone"><span>*</span>Телефон</label>
		<input type="tell" name="form[value4]" id="order_phone" value="<?php echo isset($_SESSION["order"]['phone']); ?>" />
		<span class="order_span_style" >Пример: 8 950 100 12 34</span>
	</li>
	<li><label class="order-label-style" for="order_address"><span>*</span>Адрес<br /> доставки</label>
		<input type="text" name="form[value5]" id="order_address" value="<?php echo isset($_SESSION["order"]['address']); ?>" />
		<span>Пример: г. Москва,<br /> ул Интузиастов д 18, кв 58</span>
	</li>
<?php endif; ?>
	<li><label class="order-label-style" for="order_note">Примечание</label>
		<textarea name="form[value6]" ></textarea>
		<span>Уточните информацию о заказе.<br />  Например, удобное время для звонка<br />  нашего менеджера</span>
	</li>


</ul>
	<p align="right" ><input type="submit" name="ok" id="confirm-button-next" value="Далее" /></p>
</form>

<div class="clear"></div>




	</div><!-- blok content end -->
