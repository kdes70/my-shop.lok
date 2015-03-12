//прокрутка новостей
$(document).ready(function() {
	$('#newsticker').jCarouselLite({
		vertical: true,
		hoverPause: true,
		btnPrev: "#img-prev",
		btnNext: "#img-next",
		visible: 3,
		auto: 3000,
		speed: 500

	});

	//Изменения вида

	if($.cookie("display") == null){
			$.cookie("display", "grid");
			//$('#style-grid').attr('src', '/skins/shop/images/icon-grid-active.png');
		}
		if($.cookie("display") == "list"){
			$('#style-list').attr('src', '/skins/shop/images/icon-list-active.png');
			$('#style-grid').attr('src', '/skins/shop/images/icon-grid.png');
		}
		else{
			$('#style-grid').attr('src', '/skins/shop/images/icon-grid-active.png');
			$('#style-list').attr('src', '/skins/shop/images/icon-list.png');

		}

		$(".grid-list").click(function() {
			var display = $(this).attr("id");//Получаем значение вида



			display = (display == "grid") ? "grid" : "list"; //Допустимые значения

				if(display == $.cookie("display")){
					//Если значение совподает с кукой то ничего не делаем
					return false;
				}
				else{
					//Иначе устанавливаем новое значение вида в Куки
					$.cookie("display", display);
					window.location = "";
					return false;

				}


		});



	//Сортировка товара

	//выводим список сортировок
	$("#select-sort").click(function(){
   $("#sorting-list").slideToggle(200);
});
	//Акардион меню категорий
	$('#block-category > ul > li > a').click(function(){

            if ($(this).attr('class') != 'active'){

			$('#block-category > ul > li > ul').slideUp(400);
            $(this).next().slideToggle(400);

                    $('#block-category > ul > li > a').removeClass('active');
					$(this).addClass('active');

				//	$(this.nextAll('img')).attr('src', 'skins/shop/images/img-next.png');

                    $.cookie('select_cat', $(this).attr('id'));

				}else
                {

                    $('#block-category > ul > li > a').removeClass('active');
                    $('#block-category > ul > li > ul').slideUp(400);
                //    $(this).next('.cat-arr').attr('src', 'skins/shop/images/img-prev.png');
                    $.cookie('select_cat', '');
                }
});
	if ($.cookie('select_cat') != '')
{
$('#block-category > ul > li > #'+$.cookie('select_cat')).addClass('active').next().show();
}


//Обнавление капчи
$('#reloadcaptcha').click(function(){
$('#block-captcha > img').attr("src","/components/captcha/reg_captcha.php?r="+ Math.random());
});

//форма входа
// $('.autch-top').toggle(
//        function() {
//          //  $(".autch-top").attr("id","active-button");
//          //  $("#block-top-auth").fadeIn(200);
//        },
//        function() {
//          //  $(".autch-top").attr("id","");
//          //  $("#block-top-auth").fadeOut(200);
//        }
//     );

 $(".autch-top").click(function () {
      $("#block-top-auth").toggle();
    });
//Скрытие пароля
$('#button-pass-show-hide').click(function(){
 var statuspass = $('#button-pass-show-hide').attr("class");

    if (statuspass == "pass-show")
    {
       $('#button-pass-show-hide').attr("class","pass-hide");

     			            var $input = $("#auth_pass");
			                var change = "text";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;

    }else{
        $('#button-pass-show-hide').attr("class","pass-show");

     			            var $input = $("#auth_pass");
			                var change = "password";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;

    }



  });

//Авторизация
	$("#button-auth").click(function(e) {
		 e.preventDefault();
		 var login = $("#auth_login").val();
		 var pass  = $("#auth_pass").val();
		 var auth  = $("#auth").val();

			if ($("#rememberme").prop('checked'))
			{
			rememberme         = 'yes';
			}else { rememberme = ''; }

			console.log(login+ '|' +pass+ '|' +auth+ '|'+rememberme);
			//Валидация логина
			if (login == "" || login.length > 30 )
			{
				$("#auth_login").css("borderColor","#FDB6B6");
				$("#message-auth").slideDown(400).html('Поля логин/пароль должны быть заполнены!');
				send_login = 'no';
			}else {$("#auth_login").css("borderColor","#DBDBDB");send_login = 'yes';  }


			//Валидация пароля
			if (pass == "" || pass.length > 15 )
			{
				$("#auth_pass").css("borderColor","#FDB6B6");
				$("#message-auth").slideDown(400).html('Поля логин/пароль должны быть заполнены!');
				send_pass = 'no';
			}else { $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes'; }

	if ( send_login == 'yes' && send_pass == 'yes' )
	{
	 $("#button-auth").hide();
	 $(".auth-loading").show();
			$.ajax({
				url:'/registration/read',
				type: 'POST',
				data: {auth: auth, 'form[value1]': login, 'form[value2]': pass, 'form[value3]': rememberme},
				success: function(res){
					console.log(res);
					if(res != 'Поля логин/пароль должны быть заполнены!' && res != 'Ошибка ввода данных')
					{
						//Если пользователь успешно авторзован
						//$('#input-auth li').hide();
						$("#message-auth").slideDown(400).html(res);

						if (res == 'Добро пожаловать!')
						{
							$('#input-auth li').hide();
							$("#button-auth").hide();
	 						$(".auth-loading").show();
							setTimeout(function(){
							    location.reload();
							  }, 800)
						}
					}else{
						//Если авторизация не удачна
						$("#message-auth").slideDown(400).html(res);
						$(".auth-loading").hide();
						$("#button-auth").show();
					}


				},
				 error: function(){
                alert("Error!");
           }
			});
	}

	});
// показываем форму востоновления пароля

$('#remid-pass').click(function(){

			$('#input-auth').fadeOut(200, function() {
				setTimeout(function(){
					$('#input-auth').append();
				}, 200);
			//$("#auth_pass").hide(),$("#auth_login").hide();

            $('#block-remind').fadeIn(300);
			});
});

$('#prev-auth').click(function(){

			$('#block-remind').fadeOut(200, function() {
				//$("#auth_pass").show(),$("#auth_login").show();
				$('#input-auth').appendTo('#block-top-auth');
            $('#input-auth').fadeIn(300);

			});
});

// востоновление пароля

$('#remind').click(function(){

 var recall_email = $("#remind-email").val();
 var remind = $("#remind").val();
 var remind_login = $("#remind-login").val();

 if (recall_email == "" || recall_email.length > 20 )
 {
    $("#remind-email").css("borderColor","#FDB6B6");

 }else
 {
   $("#remind-email").css("borderColor","#DBDBDB");

   $("#button-remind").hide();
   $(".auth-loading").show();

  $.ajax({
  type: "POST",
  url: "/registration/remid",
  data: {"form[value4]": recall_email, "remind": remind, "form[value5]": remind_login},
  //dataType: "html",
  cache: false,
  success: function(data) {
console.log(data);
  if (data == 'yes')
  {
     $(".auth-loading").hide();
     $("#button-remind").show();
     $('#message-remind').attr("class","message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);

     setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-auth').show()", 3000);
   }
   else if(data == 'to_login'){

   	$('#remind-login').show();
	$('#message-remind').attr("class","message-remind-success").html("Укажите логин учетной записи что требуется востоновить").slideDown(400);
	$(".auth-loading").hide();
   }
  else
  {
      $(".auth-loading").hide();
      $("#button-remind").show();
      $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);

  }
  }
});
  }
  });

// окошко профиля
 $('#auth-user-info').click(function() {

 	$("#block-user").fadeToggle(100);

    });

 //Результаты поиска

// $('#input-search').bind('textchange', function () {

//  var input_search = $("#input-search").val();

// if (input_search.length >= 3 && input_search.length < 150 )
// {
//  $.ajax({
//   type: "POST",
//   url: "/search",
//   data: "text="+input_search,
//   dataType: "html",
//   cache: false,
//   success: function(data) {

//  if (data > '')
//  {
//      $("#result-search").show().html(data);
//  }else{

//     $("#result-search").hide();
//  }

//       }
// });

// }else
// {
//   $("#result-search").hide();
// }

// });
//
  //Шаблон проверки email на правильность
    function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
    }

 // Контактные данные
  $('#confirm-button-next').click(function(e){

   var order_fio = $("#order_fio").val();
   var order_email = $("#order_email").val();
   var order_phone = $("#order_phone").val();
   var order_address = $("#order_address").val();

 if (!$(".order_delivery").is(":checked"))
 {
    $(".label_delivery").css("color","#E07B7B");
    send_order_delivery = '0';

 }else { $(".label_delivery").css("color","black"); send_order_delivery = '1';


  // Проверка ФИО
 if (order_fio == "" || order_fio.length > 50 )
 {
    $("#order_fio").css("borderColor","#FDB6B6");
   send_order_fio = '0';

 }else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}


 //проверка email
 if (isValidEmailAddress(order_email) == false)
 {
    $("#order_email").css("borderColor","#FDB6B6");
  send_order_email = '0';
 }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}

 // Проверка телефона

  if (order_phone == "" || order_phone.length > 50)
 {
    $("#order_phone").css("borderColor","#FDB6B6");
    send_order_phone = '0';
 }else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}

 // Проверка Адресса

  if (order_address == "" || order_address.length > 150)
 {
    $("#order_address").css("borderColor","#FDB6B6");
    send_order_address = '0';
 }else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}

}
 // Глобальная проверка
 if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
 {
    // Отправляем форму
   return true;
 }

e.preventDefault();

});


//добавление товара в корзину------------------************************

$('.add-cart-style').click(function(){

 var  tid = $(this).attr("tid");

//alert(tid);
 $.ajax({
  type: "POST",
  url: "cart/addtocart/",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) {
 // loadcart();
 // console.log(data);
      }
});

});


});
