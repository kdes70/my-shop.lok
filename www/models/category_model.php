<?php 

/**
* Модель Категории
* @author IT studio WebdiM
* @copyright © 2013 WebdiM
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
	class Category_Model 
	{
		public  $table, $id, $res;

		
		function __construct($table, $id)
		{
			$this->id = $id;
			$this->table = $table;
		}
/**
 * Метод получения массива категорий
*=================================*/

public function creatCatArrey(){

	$res = mysqlQuery("SELECT * FROM `". IRB_DBPREFIX . $this->table ."` ORDER BY `parent_id`, `name`");

	// масив категорий
	$cat = array();

	while ($row = mysqli_fetch_assoc($res)) {
		$cat[$row['id']]['icon'] = $row['icon'];
		if(!$row['parent_id']){

			$cat[$row['id']][] = $row['name'];
			//$cat[$row['id']]['icon'] = $row['icon'];
		}
		else{

			$cat[$row['parent_id']]['sub'][$row['id']] = $row['name'];
		}
		# code...

	}
	return $cat;

}

/**
* Метод получение всех брендов
*/
	public function createBrandArr()
	{
		$this->res = mysqlQuery("SELECT * FROM `". IRB_DBPREFIX . $this->table ."` WHERE `parent_id`= 0");
	}



/**
* Метод представления.
* @param string $template
* @param string $mod
* @param string $link
* @param string $rating
* @return string 
*/      
    public function createRowsCat($template, $mod, $link)
    {
        $rows  = '';    
        $tpl   = getTpl($template);    
        $bb = new IRB_BBdecoder();
       
        while($row = mysqli_fetch_assoc($this->res))
        {
            //$this->title       = !empty($row['m_title']) ? htmlChars($row['m_title']) : '';
           // $this->keywords    = !empty($row['m_keywords']) ? htmlChars($row['m_keywords']) : '';
           // $this->description = !empty($row['m_description']) ? htmlChars($row['m_description']) : '';
         
          //  $row['title'] = htmlChars($row['title']);
            
          //  if($this->clear)
          //      $row['text'] = $bb -> stripBBtags($row['text']);
          //  else
          //      $row['text'] = $bb -> createBBtags($row['text']);
                
            $row['link']  = $link;
          //  $num          = ($this->num > 1) ? $this->num : 0;
          //  $link_name    = ($mod == 'full') ? translateWord($row['title']) : 0;
          //  $row['url']   = href('mod='. $mod, 'parent='. $row['id'], 'id='. $link_name, 'num='. $num);           
            $rows .= parseTpl($tpl, $row);   
        }
        
        return $rows;    
    } 
	}
 ?>