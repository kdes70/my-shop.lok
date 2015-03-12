<li>
	<div class="blok-img-grid"><img src="<?=IRB_HOST;?>photo/<?php echo $tpl_image; ?>" alt=""></div>
	<p class="style-title"><a href="<?php echo $tpl_url; ?>"><?php echo $tpl_title; ?></a></p>
		<ul class="tovar-info-grid">
			<li><img src="<?=TEMPLATE;?>images/eye-icon.png" alt=""><p>0</p></li>
			<li><img src="<?=TEMPLATE;?>images/comment-icon.png" alt=""><p>0</p></li>

		<?php if($tpl_new) echo '<li><img src="'.TEMPLATE.'images/new-32.png" alt=""><p></p></li>'?>
		<?php if($tpl_hits) echo '<li><img src="'.TEMPLATE.'images/bestprice-32.png" alt=""><p></p></li>'?>
		<?php if($tpl_sale) echo '<li><img src="'.TEMPLATE.'images/sale-32.png" alt=""><p></p></li>'?>

		</ul>
		<a class="add-cart-style" tid="<?php echo $tpl_id; ?>"></a>
		<p class="style-price-grid"><strong><?php echo group_numerals($tpl_price); ?></strong> руб.</p>
	<div class="mini-features"><?php echo $tpl_mini_features; ?></div>

</li>
