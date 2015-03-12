<div id="blok-content"><!-- blok content start -->
<div id="blok-sorting">
			<p id="nav-breadcrumbs"><a href="#">Главная страница</a> \ <span>Все товары</span></p>
				
				<ul id="option-list">
					<li>Вид:</li>
					<li><img id="style-grid" src="<?=TEMPLATE;?>images/icon-grid.png" alt=""></li>
					<li><img id="style-list" src="<?=TEMPLATE;?>images/icon-list.png" alt=""></li>
					
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