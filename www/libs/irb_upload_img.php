<?php

/**
 * IRB_Upload_Img - Класс загрузки изображений
 * NOTE: Requires PHP version 5 or later 
 * @package IRB_Upload_Img
 * @author IT studio IRBIS-team (www.irbis-team.com)
 * @copyright © 2012 IRBIS-team
 * @version 0.1
 * @license http://www.opensource.org/licenses/rpl1.5.txt
 */

class IRB_Upload_Img
{
    public $error, $name, $new_name, $upload_name;
    public $width = 800;
    public $height = 800;    
    
    public function __construct($error)
    {
        $this->error = $error;
    }
/*
* Метод загрузки файла на сервер
* @param string $file
* @param string $dir
* @return mixed
*/
    public function uploadFile($file, $dir = 'photo/')
    {
             
        if(!empty($this->error[$_FILES[$file]['error']])) 
            return $this->error[$_FILES[$file]['error']]; 
        elseif(($extension = $this->checkFile($file)) === false)    
            return $this->error['UPLOAD_ERR_EXTENTION']; 
            
        $img = getimagesize($_FILES[$file]['tmp_name']);
            
        if($img[2] < 1 || $img[2] > 3)
            return $this->error['UPLOAD_ERR_EXTENTION'];
        elseif($img[0] > $this->width + $this->width * 0.1) 
            return $this->error['UPLOAD_ERR_WIDTH'];
        elseif($img[1] > $this->height + $this->height * 0.1) 
            return $this->error['UPLOAD_ERR_HEIGHT'];            
        else
        {
            $this->name = $this->generateFilename($file);
            $this->name .=  '.'. $extension;            
            $this->new_name  = IRB_HOST . $dir . $this->name;
            $this->upload_name = IRB_ROOT .'/'. $dir . $this->name; 
         

            
            if(move_uploaded_file($_FILES[$file]['tmp_name'], $this->upload_name))
                return false; 
            else  
                return $this->error['UPLOAD_ERR_UPLOAD'];    
        }
    }    
    
/*
* Метод проверки типа файла
* @param string
* @return string
*/
    public function checkFile($file)
    {
        $extension = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION); 
        $valid_extensions = array('jpg', 'jpeg', 'gif', 'png');        
        return in_array($extension, $valid_extensions) ? $extension : false;
        
    }
    
/*
* Метод генерации уникального имени
* @return string
*/
    public function generateFilename($file)
    {
        return time() . strtolower(substr($_FILES[$file]['tmp_name'], -8, 4)); 
    }

    
    
    
    public function imgResize($width, $height)
    {            
        if (!file_exists($this->upload_name)) return false;
        
        $size = getimagesize($this->upload_name);
     
        if ($size === false) return false;
        
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
       
        $icfunc = "imagecreatefrom" . $format;
        if (!function_exists($icfunc)) return false;
        
        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];
        
        $ratio       = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);
        
        $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
        $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
        
        $isrc = $icfunc($this->new_name);
        $idest = imagecreatetruecolor($width, $height);
        
        imagefill($idest, 0, 0, 0xFFFFFF);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, 
        $new_width, $new_height, $size[0], $size[1]);
        
        imagejpeg($idest, $this->upload_name, 85);
        
        imagedestroy($isrc);
        imagedestroy($idest);
        
        return true;
    }
}
 

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    