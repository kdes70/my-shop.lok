
<?php

    if(isset($_SESSION['msg']))
        {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        }

?>
<div id="block-form-registration">
<form method="post" id="form_profil" action="">
<ul id="form-regist">
<h3>Изменение профиля: <?php echo $_SESSION['userdata']['login']; ?></h3>
<li>
<label>Ваш текуший пароль:</label>
<span class="star" >*</span>
<input type="text" name="form[value1]" id="form[value1]"  />
</li>

<li>
<label>Новый пароль</label>
<span class="star" >*</span>
<input type="text" name="form[value2]" id="form[value2]" />
</li>

<li>
<label>Фамилия</label>
<span class="star" >*</span>
<input type="text" name="form[value3]" id="form[value3]" value="<?php echo $_SESSION['userdata']['surname']; ?>"/>
</li>

<li>
<label>Имя</label>
<span class="star" >*</span>
<input type="text" name="form[value4]" id="form[value4]" value="<?php echo $_SESSION['userdata']['name']; ?>"/>
</li>

<li>
<label>Отчество</label>
<span class="star" >*</span>
<input type="text" name="form[value5]" id="form[value5]" value="<?php echo $_SESSION['userdata']['patronymic']; ?>"/>
</li>

<li>
<label>E-mail</label>
<span class="star" >*</span>
<input type="email" name="form[value6]" id="form[value6]" value="<?php echo $_SESSION['userdata']['email']; ?>"/>
</li>

<li>
<label>Мобильный телефон</label>
<span class="star" >*</span>
<input type="phone" name="form[value7]" id="form[value7]" onkeyup="this.value = this.value.replace (/\D/, '')" value="<?php echo $_SESSION['userdata']['phone']; ?>"/>
</li>

<li>
<label>Адрес доставки</label>
<span class="star" >*</span>
<input type="text" name="form[value8]" id="form[value8]" value="<?php echo $_SESSION['userdata']['address']; ?>"/>
</li>

<li><p align="right"><input type="submit" name="edit" id="form_submit" value="Редоктировать" /></p></li>

</ul>


</form>


</div>






<div class="clear"></div>
