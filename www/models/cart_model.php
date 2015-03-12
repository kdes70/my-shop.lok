<?php 
/**
* Модель Cart
* @author IT studio IRBIS-team
* @copyright © 2012 IRBIS-team
*/
/////////////////////////////////////////////////////////

/**
* Генерация страницы ошибки при доступе вне системы
*/
	if(!defined('IRB_KEY'))
	{
	   header("HTTP/1.1 404 Not Found");     
	   exit(file_get_contents('../404.html'));
	}
/////////////////////////////////////////////////////////

	/**
	* 
	*/
	class Cart_Model
	{	
		public $table;
		public $res, $all_price, $user_id;
		
		function __construct($table, $tcart)
		{
			$this->table = $table;
			$this->tcart = $tcart;
		}

	/*Метод добавления товара в корзину*/				
	public function addTocart($id){

		if(isset($_SESSION['cart'][$id]['qty']))
		{	//Если товар в корзине уже есть 
			$_SESSION['cart'][$id]['qty'] += 1;

			return $_SESSION['cart'];
		}else{

			$_SESSION['cart'][$id]['qty'] = 1;

			return $_SESSION['cart'];
		}
	}

	/*Метод подсчета суммы заказа в корзине + атребуты товара*/
	public function totalPrice($goods){

		$total_sum = 0;
		$str_goods = implode(',',array_keys($goods));

	$res =	mysqlQuery("SELECT `id`, `title`, `price`, `image`,mini_features
						FROM `". IRB_DBPREFIX . $this->table ."`
						WHERE `id` IN ($str_goods)");

		while($row = mysqli_fetch_assoc($res)){
		    $_SESSION['cart'][$row['id']]['name'] = $row['title'];
		    $_SESSION['cart'][$row['id']]['price'] = $row['price'];
		    $_SESSION['cart'][$row['id']]['image'] = $row['image'];
		    $_SESSION['cart'][$row['id']]['descript'] = $row['mini_features'];	
		    $_SESSION['cart'][$row['id']]['sum'] = $_SESSION['cart'][$row['id']]['qty'] * $row['price'];
		    $total_sum += $_SESSION['cart'][$row['id']]['qty'] * $row['price'];
	    }
    return $total_sum;
	}

	/*// Метод выбора тоаваров в карзине
	public function createTovarTocart(){

		$this->res = mysqlQuery("SELECT * FROM `". IRB_DBPREFIX . $this->table ."`a,`". IRB_DBPREFIX . $this->tcart ."`b
								WHERE b.`cart_ip`='".$_SERVER['REMOTE_ADDR']."' AND a.`id` = b.`cart_id_product`");

	}*/
	// //Метод удаления всех товаров корзины
	// public function clearTocart(){

	// 	mysqlQuery("DELETE FROM `". IRB_DBPREFIX . $this->tcart ."` 
	// 				WHERE `cart_ip`= '".$_SERVER['REMOTE_ADDR']."'");
	// }
	//Метод удаления товара из корзыны
	// public function deleteTovarTocart($id){
	// 	mysqlQuery("DELETE FROM `". IRB_DBPREFIX . $this->tcart ."`
	// 				WHERE `cart_id` = ".$id." AND `cart_ip`='".$_SERVER['REMOTE_ADDR']."'");
	// }

	/*Добавляем гостя в заказчики*/

 	public function addClient($fio, $email, $phone, $addres)
 	{
 		mysqlQuery("INSERT INTO `". IRB_DBPREFIX ."users` 
 						SET `name`    = '".$fio."',
 							`email`   = '".$email."',
 							`phone`   = '".$phone."',
 							`address` = '".$addres."'");
 		if(mysqli_affected_rows(DB::$link) > 0)
 		{
 			//Если гость добавлен в заказчики получаем его ID 
 			return $this->user_id = mysqli_insert_id(DB::$link);

 		}else{
 			return FALSE;
 		}
 	}

 	public function saveOrders($user_id, $dostavka, $prim)
 	{
	 		mysqlQuery("INSERT INTO `". IRB_DBPREFIX ."orders` 
	 					SET `id_user`  = ".$user_id.",
	 						`datatime` =  NOW(),
	 						`dostavka` = '".$dostavka."',
	 						`prim`     = '".$prim."'");
	 		
	 		if(mysqli_affected_rows(DB::$link) == -1)
	 		{ //Если не получилось сохранить заказ то удаляем заказчика
	 			mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."users`
	 						WHERE `id` =". $user_id ." AND `login` = ''");
	 			return FALSE;

	 		}
	 		 $order_id = mysqli_insert_id(DB::$link); // ID сохраненного заказа

	 		 foreach($_SESSION['cart'] as $goods_id => $value){
	        $val .= "($order_id, $goods_id, {$value['qty']}),";    
	    }
	    	$val = substr($val, 0, -1); // удаляем последнюю запятую

	    	

	    mysqlQuery("INSERT INTO `". IRB_DBPREFIX ."cart` (id_order, cart_id_product, cart_count)
	                VALUES $val");

	    if(mysqli_affected_rows(DB::$link) == -1){

	        // если не выгрузился заказа - удаляем заказчика (customers) и заказ (orders)
	        mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."orders` WHERE id_order = $order_id");
	        mysqlQuery("DELETE FROM `". IRB_DBPREFIX ."users`
	                        WHERE id = ". $this->user_id ." AND login = ''");
	        return false;
	    }
	    
	    // если заказ выгрузился
	    unset($_SESSION['cart']);
	    unset($_SESSION['total_sum']);
	    unset($_SESSION['total_quantity']);
	   // unset($_SESSION['order']);
	   $info[] = "<div class='success'>Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа.</div>";
    return true;
 		
 	}

	/**
* Метод представления.
* @param string $template
* @param string $mod
* @param string $link
* @param string $rating
* @return string 
*/      
	public function createRows($template, $mod)
	{
		$rows  = '';    
		$tpl   = getTpl($template);    
		$bb = new IRB_BBdecoder();
	   
		while($row = mysqli_fetch_assoc($this->res))
		{
			//Подсчитываем обшую стоимость
			$row['int'] = $row['cart_price'] * $row['cart_count'];
			$this->all_price = $this->all_price + $row['int']; 


			//$this->title       = !empty($row['m_title']) ? htmlChars($row['m_title']) : '';
			//$this->keywords    = !empty($row['m_keywords']) ? htmlChars($row['m_keywords']) : '';
			//$this->description = !empty($row['m_description']) ? htmlChars($row['m_description']) : '';
		 
			//$row['title'] = htmlChars($row['title']);
			
		  
			// if($this->clear)
			//     $row['text'] = $bb -> stripBBtags($row['text']);
			// else
			//     $row['text'] = $bb -> createBBtags($row['text']);
				
		//	$row['link']  = $link;
		//	$num          = ($this->num > 1) ? $this->num : 0;
		  //  $link_name    = ($mod == 'full') ? translateWord($row['title']) : 0;
		 //   $row['url']   = href('mod='. $mod, 'parent='. $row['id'], 'id='. $link_name, 'num='. $num);           
			$rows .= parseTpl($tpl, $row);   
		}
		
		return $rows;    
	} 
}     
	