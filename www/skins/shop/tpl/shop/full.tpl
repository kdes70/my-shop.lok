<div id="block-content-info">
<div id="img_full"><img src="<?=IRB_HOST;?>photo/<?php echo $tpl_image; ?>"  /></div>


<div id="block-mini-description">

<p id="content-title"><?php echo $tpl_title; ?></p>

<ul class="reviews-and-counts-content">
<li><img src="<?=TEMPLATE;?>images/eye-icon.png" alt=""><p>0</p></li>
            <li><img src="<?=TEMPLATE;?>images/comment-icon.png" alt=""><p>0</p></li>
</ul>


<p id="style-price" ><?php echo $tpl_price; ?> руб</p>

<a class="add-cart" id="add-cart-view" tid="'.$row1["products_id"].'" ></a>

<p id="content-text"><?php echo $tpl_mini_description; ?></p>

</div>

</div>
