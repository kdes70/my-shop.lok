<?php

/** 
* Класс формирования древовидного вывода результата
* NOTE: Requires PHP version 5 or later  
* Info: http://irbis-team.ru   
* @author IT studio IRBIS-team 
* @copyright © 2012 IRBIS-team 
* @version 0.1 
* @license http://www.opensource.org/licenses/rpl1.5.txt 
*/  

class IRB_Tree
{

    public  $shift, $max_nest;
    private $result = '';
    
/**
* Конструктор
* @access public
* @param array $rows
*/   
    public function __construct($rows)
    {       
        $this->rows = $rows;
    }

/**
* Метод формирования дерева
* @access public
* @param int $shift //Сдвиг вправо в пикселях
* @param int $max_nest // Максимальная вложенность
* @return string
*/      
    public function createTree($shift = 40, $max_nest = 10)
    {
        $this->shift    = $shift;
        $this->max_nest = $max_nest;
     
        $data = $this->_sortArray();
        $this->_recursiveTree($data, $parent = 0, $shift = 0);
        return $this->result;
    }    
    
/**
* Рекурсивный метод обхода массива
* @access private
* @param array $data
* @param int $parent
* @param int $shift
* @return void
*/      
    private function _recursiveTree($data, $parent, $shift)
    {
        $arr   = $data[$parent];
        $cnt   = count($arr);
        $style = '';
        static $shift_cnt;
        
        if(!empty($shift) && ++$shift_cnt < $this->max_nest)
            $style = ' style="padding-left:'. $shift .'px;"';
        
        for($i = 0; $i < $cnt; $i++)
        {
            $this->result .= "<div". $style .">\n";
            $this->result .= $arr[$i]['rows'];
            
            if(isset($data[$arr[$i]['id']])) 
                $this->_recursiveTree($data, $arr[$i]['id'], $this->shift);
                
            $this->result .= "</div>\n";
        }
    }    
    
/**
* Метод формирования массива дерева
* @access private
* @return array
*/      
    private function _sortArray()
    {
        $cnt = count($this->rows);
     
        for ($i = 0; $i < $cnt; ++$i)
            $arr[$this->rows[$i]['id_parent']][] = $this->rows[$i];
        
        return $arr;
    }

}


