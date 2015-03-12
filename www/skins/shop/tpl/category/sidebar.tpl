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
		<?php print_r($category);?>
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