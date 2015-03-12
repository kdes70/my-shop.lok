<li>
	<div class="blok-img-list"><img src="<?=IRB_HOST;?>photo/<?php echo $tpl_image; ?>" alt=""></div>
	<p class="style-title"><a href="<?php echo $tpl_url; ?>"><?php echo $tpl_title; ?></a></p>
		<ul class="tovar-info-list">



			<li><img src="<?=TEMPLATE;?>images/eye-icon.png" alt=""><p>0</p></li>
			<li><img src="<?=TEMPLATE;?>images/comment-icon.png" alt=""><p>0</p></li>

		<?php if($tpl_new) echo '<li><img src="'.TEMPLATE.'images/new-32.png" alt=""><p></p></li>'?>
		<?php if($tpl_hits) echo '<li><img src="'.TEMPLATE.'images/bestprice-32.png" alt=""><p></p></li>'?>
		<?php if($tpl_sale) echo '<li><img src="'.TEMPLATE.'images/sale-32.png" alt=""><p></p></li>'?>


		</ul>
		<a href="<?php echo href('page=cart', 'mod=addtocart', 'parent='.$tpl_id); ?>" class="add-cart-style"></a>
		<p class="style-price-list"><strong><?php echo group_numerals($tpl_price); ?></strong> руб.</p>
	<div class="style-text-list"><?php echo $tpl_mini_description; ?></div>

</li>
