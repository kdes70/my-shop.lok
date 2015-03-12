<div id="blok-content"><!-- blok content start -->
    <div id="block-step">
        <div id="name-step">
            <ul>
                <li><a href="<?php echo href('page=cart', 'mod=oneclick'); ?>" >1. Корзина товаров</a></li>
               <li><span>&rarr;</span></li>
               <li><a href="<?php echo href('page=cart', 'mod=confirm'); ?>" >2. Контактная информация</a></li>
               <li><span>&rarr;</span></li>
               <li><a class="active" >3. Завершение</a></li>
            </ul>
        </div>
        <p>шаг 3 из 3</p>
    </div>
        <h3>Конечная информация:</3>



      <?php
   echo $name ." <br/>";  
   echo $email ." <br/>"; 
   echo $phone ." <br/>"; 
   echo $addres ." <br/>";
    ?>
<?php // echo print_arr($_SESSION);?>  

<?php foreach ($_SESSION['cart'] as $key => $value):  ?>


      <p><a href=""><?php echo $value['name']; ?></a></p>
     
      <h5><span class="span-count"><?php echo $value['qty']; ?></span> x <span><?php echo $value['price']; ?></span></h5>
      <p><?php echo $value['sum']; ?></p>
   

<?php endforeach; ?>



<div class="clear"></div>




    </div><!-- blok content end -->



