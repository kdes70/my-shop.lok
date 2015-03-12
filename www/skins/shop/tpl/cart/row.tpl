<div class="block-list-cart">
		<div class="img-cart">
			<img src="/photo/<?php echo $tpl_image; ?>" alt="">
		</div>
		<div class="title-cart">
			<p><a href=""><?php echo $tpl_title; ?></a></p>
			<p class="cart-mini-features">
				<?php echo $tpl_mini_features; ?>
			</p>
		</div>
		<div class="count-cart">
			<ul class="input-count-style">
				<li><p align="center" class="count-minus">-</p></li>
				<li>
					<p align="center">
						<input type="text" class="count-input" value="<?php echo $tpl_cart_count; ?>" maxlength="3" onkeyup="this.value = this.value.replace (/\D/, '')">
					</p>
				</li>
				<li><p align="center" class="count-plus">+</p></li>
			</ul>
		</div>
		<div class="price-product-cart">
			<h5><span class="span-count"><?php echo $tpl_cart_count; ?></span> x <span><?php echo $tpl_cart_price; ?></span></h5>
			<p><?php echo $tpl_int; ?></p>
		</div>
		<div class="delete-cart"><a  href="<?php echo href('page=cart', 'mod=delete', 'parent='.$tpl_cart_id); ?>" ><img src="<?=TEMPLATE;?>images/bsk_item_del.png" /></a></div>
		<div id="bottom-cart-line"></div>
	</div>