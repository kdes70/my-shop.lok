
	<div id="blok-content"><!-- blok content start -->
	<div id="blok-sorting">
			<p id="nav-breadcrumbs"><a href="#">Главная страница</a> \ <span>Все товары</span></p>
				
				<center><h1><?php echo $page_title; ?></h1></center>
		</div>

	<?php if(!isset($_COOKIE['display']) OR $_COOKIE['display'] == "grid") : ?>
		<ul id="blok-tovar-grid">
		 <?php if($rows) :?>
			<?php echo $rows; ?>
		<?php else : ?>
		<p>Здесь товаров пока нет!</p>
	<?php endif; ?>
			<div class="clear"></div>
<?php  echo $page_menu; ?>
		</ul>
<?php else : ?>
	<ul id="blok-tovar-list">
			 <?php if($rows) :?>
				<?php echo $rows; ?>
			<?php else : ?>
			<p>Здесь товаров пока нет!</p>
		<?php endif; ?>
				<div class="clear"></div>
	<?php  echo $page_menu; ?>
	</ul>
<?php endif; ?>
		
<div class="clear"></div>

	</div><!-- blok content end -->