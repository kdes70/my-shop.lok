
	<div id="blok-content"><!-- blok content start -->
	<?php if($GET['mod'] === 'full' || $GET['mod'] === 'cat'): ?>
	<div id="blok-sorting">
			<p id="nav-breadcrumbs"><a href="#">Главная страница</a> \ <span>Все товары</span></p>
		</div>
	<?php else: ?>
		<div id="blok-sorting">
			<p id="nav-breadcrumbs"><a href="#">Главная страница</a> \ <span>Все товары</span></p>

				<ul id="option-list">
					<li>Вид:</li>
					<li><a href="#" id="grid" class="grid-list"><img id="style-grid" src="<?=TEMPLATE;?>images/icon-grid.png" alt=""></a></li>
					<li><a href="#" id="list" class="grid-list"><img id="style-list" src="<?=TEMPLATE;?>images/icon-list.png" alt=""></a></li>

					<li>Сортировать:</li>
					<li><a id="select-sort"><?php echo $sort_name; ?></a>
						<ul id="sorting-list">
							<li><a href="<?php echo href('mod=price-asc'); ?>">От дешовых к дорогим</a></li>
							<li><a href="<?php echo href('mod=price-desc'); ?>">От дорогих к дешовым</a></li>
							<li><a href="<?php echo href('mod=popular'); ?>">Популярное</a></li>
							<li><a href="<?php echo href('mod=news'); ?>">Новинки</a></li>
							<li><a href="<?php echo href('mod=brend'); ?>">От А до Я</a></li>
						</ul>
					</li>

				</ul>

		</div>

	<?php endif; ?>



<?php if(!isset($_COOKIE['display']) OR $_COOKIE['display'] == "grid") : ?>
		<ul id="blok-tovar-grid">
		 <?php if($rows) :?>
			<?php echo $rows; ?>
		<?php else : ?>
		<p>Здесь товаров пока нет!</p>
	<?php endif; ?>
<li><?php  echo $page_menu; ?></li>
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
