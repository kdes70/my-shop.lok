<?php

/**
* Модель
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

class Shop_Model
{

	public $table, $menu, $title, $keywords, $description;
	public $clear  = false;
	protected $res, $num, $cond;

/**
* Конструктор
* @param string $table
* @param int $num
*/
	public function __construct($table, $num = 1)
	{
		$this->table = $table;
		$this->num   = $num;
	}
// Добавим новый метод
/**
* Метод дополнительных условий для выборки
* @param string $and
* @return void
*/
	public function setCondition($cond)
	{
		$this->cond = "\nAND ". $cond;
	}

/**
* Метод сортировки выборки
* @param string $and
* @return void
*/
	public function setSort($perent, $sort ="")
	{
		$this->sort = " ORDER BY `".$perent."` ". $sort;
	}


/**
* Метод генерации ленты анонсов
* @param int $num_rows
* @param int $num_words
* @param bolean $list
* @return void
*/
	public function createPreview($num_rows, $num_words, $list = true)
	{
		$pag = new IRB_Paginator($this->num, $num_rows);

		$where = defined('IRB_ADMIN') ? str_replace('AND', 'WHERE', $this->cond) : "WHERE `public` = 1 ". $this->cond;

		$this->res = $pag -> countQuery("SELECT `id`, `title`, `price`, `image`, `mini_features`
											DATE_FORMAT(`date`,'%d-%m-%Y') AS `date`,
											SUBSTRING_INDEX(`text`,' ', ". $num_words .") AS `text`
											  FROM `". IRB_DBPREFIX . $this->table ."`
											  ". $where ."
											  ORDER BY `id` DESC "
										);
		if($list)
			$this->menu = $pag -> createMenu();
	}

/**
* Метод генерации списка товара
* @param int $num_rows
* @param int $num_words
* @param bolean $list
* @return void
*/
	public function createAllTovars($num_rows, $sort = false, $list = true){

		$pag = new IRB_Paginator($this->num, $num_rows);

		$sort == false ? $sorting = "ORDER BY `id` ASC" : $sorting = $this->sort;

		$where = defined('IRB_ADMIN') ? str_replace('AND', 'WHERE', $this->cond) : "WHERE `public` = 1 ". $this->cond;

		$this->res = $pag -> countQuery("SELECT `id`, `title`, `price`, `image`, `mini_features`, `mini_description`, `new`, `hits`, `sale`

											  FROM `". IRB_DBPREFIX . $this->table ."`
											  ". $where ."
											  ".$sorting
										);
		if($list)
			$this->menu = $pag -> createMenu();

	}

/**
* Метод генерации списка товаров по категории.
* @param int $id
* @param bool $public
* @return void
*/
	public function createCatTovars($id){

		//$where = defined('IRB_ADMIN') ? str_replace('AND', 'WHERE', $this->cond) : "WHERE `brand_id` = ".$id."  ". $this->cond;

		$this->res = mysqlQuery("(SELECT `id`, `title`, `price`, `image`, `mini_features`, `mini_description`, `hits`, `new`, `sale`
									FROM `". IRB_DBPREFIX . $this->table ."`
										WHERE `brand_id` = ".$id." AND `public` = 1)
								UNION
									(SELECT `id`, `title`, `price`, `image`, `mini_features`, `mini_description`, `hits`, `new`, `sale`
										FROM `". IRB_DBPREFIX . $this->table ."`
											WHERE `brand_id` IN
											(
												SELECT `id` FROM `". IRB_DBPREFIX ."category`
													WHERE `parent_id`= ".$id."
											) AND `public` = 1 )");

	}

/**
* Метод фильрации списка товара по пораметрам
* @param int $num_rows
* @param int $num_words
* @param bolean $list
* @return void
*/
	public function filter(){

	}

/**
* Метод генирации Астоперов
* @param int $num_rows
* @param int $num_words
* @param bolean $list
* @return void
*/
	public function eyesTopper(){

		$where = defined('IRB_ADMIN') ? str_replace('AND', 'WHERE', $this->cond) : "WHERE `public` = 1 ". $this->cond;

		$this->res = mysqlQuery("SELECT `id`, `title`, `price`, `image`, `mini_features`, `mini_description`, `new`, `hits`, `sale`
							FROM `". IRB_DBPREFIX . $this->table ."`
							".$where."
							");
	}


/**
* Метод генерации полного текста по идентификатору.
* @param int $id
* @param bool $public
* @return void
*/
	public function createFull($id)
	{
		$and = !defined('IRB_ADMIN')  ? " AND   `public` = 1 ". $this->cond : $this->cond;

		$this->res = mysqlQuery("SELECT `id`, `title`, `price`, `image`, `mini_features`, `mini_description`, `new`, `hits`, `sale`
									FROM `". IRB_DBPREFIX . $this->table ."`
									  WHERE `id` = ". (int)$id ."
									  ". $and ."
									ORDER BY `id` DESC "
								);

	}




/**
* Метод представления.
* @param string $template
* @param string $mod
* @param string $link
* @param string $rating
* @return string
*/
	public function createRows($template, $mod, $link)
	{
		$rows  = '';
		$tpl   = getTpl($template);
		$bb = new IRB_BBdecoder();

		while($row = mysqli_fetch_assoc($this->res))
		{
			$this->title       = !empty($row['m_title']) ? htmlChars($row['m_title']) : '';
			$this->keywords    = !empty($row['m_keywords']) ? htmlChars($row['m_keywords']) : '';
			$this->description = !empty($row['m_description']) ? htmlChars($row['m_description']) : '';

			$row['title'] = htmlChars($row['title']);


			// if($this->clear)
			//     $row['text'] = $bb -> stripBBtags($row['text']);
			// else
			//     $row['text'] = $bb -> createBBtags($row['text']);

			$row['link']  = $link;
			$num          = ($this->num > 1) ? $this->num : 0;
		    $link_name    = ($mod == 'full') ? translateWord($row['title']) : 0;
		    $row['url']   = href('page=shop', 'mod='. $mod, 'parent='. $row['id'], 'id='. $link_name, 'num='. $num);
			$rows .= parseTpl($tpl, $row);
		}

		return $rows;
	}
}














