<div id="blok-right"><!-- blok right start -->
	<div id="block-category"><!-- blok-category start -->
			<p class="title-header">Категория товаров</p>
			<ul>

				<?php foreach ($category as $key => $value) : ?>
					<?php if(count($value) > 2) : //Если это радительская категория?>
						<li>
						<a  id="<?php echo $key; ?>">
							<?php if(!empty($value['icon'])) :?>
								<img src="<?=TEMPLATE;?>images/<?php echo $value['icon']; ?>" class="cat-img" alt="">
							<?php endif; ?>

							<?php echo $value[0]; ?>
							<img src="<?=TEMPLATE;?>images/img-next.png" class="cat-arr" alt="">
						</a>
						<?php if(isset($value['sub'])) : ?>
							<ul class="category-section">
								<li><a href="<?php echo href('page=shop','mod=cat', 'parent='.$key); ?>"><strong>Все модели</strong></a></li>

								<?php foreach ($value['sub'] as $key => $sub):?>
									<li><a href=" <?php echo href('page=shop','mod=cat', 'parent='.$key); ?>"><?php echo $sub; ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						</li>
					<?php elseif (isset($value[0])) :?>
						<li><a href="<?php echo href('page=shop','mod=cat', 'parent='.$key); ?>">
							<?php if(!empty($value['icon'])) :?>
								<img src="<?=TEMPLATE;?>images/<?php echo $value['icon']; ?>" class="cat-img" alt="">
							<?php endif; ?>
							<?php echo $value[0]; ?>
						</a>
						
				</li>
					<?php endif; ?>
					
				<?php endforeach; ?>
				
			</ul>
		</div><!-- blok category end -->
		<script type="text/javascript">
		/*======================Блок трек бара=======================*/
			$(document).ready(function() {

			    $('#blok-treckbar').trackbar({
			onMove : function() {
		    document.getElementById("price-start").value = this.leftValue;
			document.getElementById("end-price").value = this.rightValue;	
			},
			width : 160,
			leftLimit : 1000,
			leftValue : <?php 
							if(!empty($_GET['price-start']) >=1000 AND (int)$_GET['price-start'] <= 50000)
							{ echo (int)$_GET['price-start']; }
							else{ echo "1000"; } 
						?>,
			rightLimit : 50000,
			rightValue : <?php 
							if(!empty($_GET['end-price']) >=1000 AND (int)$_GET['end-price'] <= 50000)
							{ echo (int)$_GET['end-price']; }
							else{ echo "30000"; }
						?>,
			roundUp : 1000
		});
		});
		/*======================Блок трек бара=======================*/
		</script>
		<div id="blok-parmetr"><!-- blok parametr start -->
			<p class="title-header">Поиск по параметру</p>
			<p class="title-filter">Стоимость</p>
				<form method="GET" action="<?php echo IRB_HOST; ?>">
				<input type="hidden" name="mod" value="filter">
					<div id="bloc-input-price">
						<ul>
							<li><p>от</p></li>
							<li><input type="text" id="price-start" name="price-start" value="1000" onkeyup="this.value = this.value.replace (/\D/, '')"></li>
							<li>до</li>
							<li><input type="text" id="end-price" name="end-price" value="30000" onkeyup="this.value = this.value.replace (/\D/, '')"></li>
							<li>руб.</li>
						</ul>
					</div>
					<div class="clear"></div>
					<div id="blok-treckbar"></div>
					<p class="title-filter">Производитель</p>	
					
					<ul class="checkbox-brend">
					<?php foreach ($category as $key => $item) :?>
						<?php if(isset($item[0])) : ?>
						<li>
							<input type="checkbox" name="brand[]" value="<?php echo $key; ?>" id="checkbrend-<?php echo $key; ?>" 
							<?php if(isset($_GET['brand'])) echo returnCheck($key, $_GET['brand']);?> /><!-- проверяем выбраные чекбоксы -->
							<label for="checkbrend-<?php echo $key; ?>"><?php echo $item[0]; ?></label>
						</li>
						<?php endif; ?>
					<?php endforeach; ?>
						<?php // echo $rows; ?>
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