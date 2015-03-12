    <div id="blok-content"><!-- blok content start -->
<ul id="blok-tovar-grid">
<p   class="reg_message_error"><?php echo getInfo($info); ?></p>


<?php foreach ($search_res as $value): ?>

<li>
    <div class="blok-img-grid"><img src="<?=IRB_HOST;?>photo/<?php echo $value['image']; ?>" alt=""></div>
    <p class="style-title"><a href="<?php echo $tpl_url; ?>"><?php echo $value['title']; ?></a></p>
        <ul class="tovar-info-grid">
            <li><img src="<?=TEMPLATE;?>images/eye-icon.png" alt=""><p>0</p></li>
            <li><img src="<?=TEMPLATE;?>images/comment-icon.png" alt=""><p>0</p></li>

        <?php if($value['new']) echo '<li><img src="'.TEMPLATE.'images/new-32.png" alt=""><p></p></li>'?>
        <?php if($value['hits']) echo '<li><img src="'.TEMPLATE.'images/bestprice-32.png" alt=""><p></p></li>'?>
        <?php if($value['sale']) echo '<li><img src="'.TEMPLATE.'images/sale-32.png" alt=""><p></p></li>'?>

        </ul>
        <a href="<?php echo href('page=cart', 'mod=addtocart', 'parent='.$value['id']); ?>" class="add-cart-style"></a>
        <p class="style-price-grid"><strong><?php echo $value['price']; ?></strong> руб.</p>
    <div class="mini-features"><?php echo $value['mini_features']; ?></div>

</li>

<?php endforeach; ?>
</ul>
</div>
