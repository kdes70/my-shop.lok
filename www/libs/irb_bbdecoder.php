<?php

/**   
* Функция конфигурации
*/        
    function bbConfig()
    {  
        return array(
                       // Максимальная длина слова
                      'max_len'      => 80,
                        
                      // Распознование ссылок                            
                      'links'        => true,
                        
                      // Распознование картинок                            
                      'images'       => true,
                      
                      // Распознование видео                            
                      'video'        => true,
                              
            // Парные BB-теги
             'setup_bb'    => array(
                                       '[b]'                =>   '[/b]',
                                       '[i]'                =>   '[/i]',
                                       '[s]'                =>   '[/s]',
                                       '[u]'                =>   '[/u]',
                                       '[sub]'              =>   '[/sub]',
                                       '[sup]'              =>   '[/sup]',
                                       '[justify]'          =>   '[/justify]',
                                       '[left]'             =>   '[/left]',                                       
                                       '[right]'            =>   '[/right]',
                                       '[center]'           =>   '[/center]',
                                       '[quote]'            =>   '[/quote]',
                                       '[list=ol]'          =>   '[/list=ol]',
                                       '[list=ul]'          =>   '[/list=ul]',
                                       '[*]'                =>   '[/*]',
                                       '[size=1]'           =>   '[/size=1]',
                                       '[size=2]'           =>   '[/size=2]', 
                                       '[size=3]'           =>   '[/size=3]', 
                                       '[size=4]'           =>   '[/size=4]', 
                                       '[size=5]'           =>   '[/size=5]', 
                                       '[h=5]'              =>   '[/h=5]',
                                       '[h=4]'              =>   '[/h=4]', 
                                       '[h=3]'              =>   '[/h=3]', 
                                       '[h=2]'              =>   '[/h=2]', 
                                       '[h=1]'              =>   '[/h=1]',
                                       '[color=gray]'       =>   '[/color=gray]',
                                       '[color=green]'      =>   '[/color=green]',
                                       '[color=purple]'     =>   '[/color=purple]',
                                       '[color=olive]'      =>   '[/color=olive]',
                                       '[color=silver]'     =>   '[/color=silver]',
                                       '[color=aqua]'       =>   '[/color=aqua]',
                                       '[color=yellow]'     =>   '[/color=yellow]',
                                       '[color=blue]'       =>   '[/color=blue]',
                                       '[color=orange]'     =>   '[/color=orange]',
                                       '[color=red]'        =>   '[/color=red]',                                       
                                    ),
                        
             // Парные HTML-теги (на них заменяются теги из предыдущего массива)                     
             'setup_html'  => array(
                                       '<b>'                                      =>   '</b>',
                                       '<i>'                                      =>   '</i>',
                                       '<s>'                                      =>   '</s>',
                                       '<u>'                                      =>   '</u>',
                                       '<sub>'                                    =>   '</sub>', 
                                       '<sup>'                                    =>   '</sup>', 
                                       '<p align="justify">'                      =>   '</p>', 
                                       '<p align="left">'                         =>   '</p>', 
                                       '<p align="right">'                        =>   '</p>', 
                                       '<p align="center">'                       =>   '</p>',
                                       '<p class="quote"><b>цитата:</b><br />'    =>   '</p>',
                                       '<ol>'                                     =>   '</ol>',
                                       '<ul>'                                     =>   '</ul>',                                       
                                       '<li>'                                     =>   '</li>',
                                       '<span style="font-size:11px">'            =>   '</span>',
                                       '<span style="font-size:14px">'            =>   '</span>',
                                       '<span style="font-size:18px">'            =>   '</span>',
                                       '<span style="font-size:24px">'            =>   '</span>',
                                       '<span style="font-size:32px">'            =>   '</span>',
                                       '<h5>'                                     =>   '</h5>',
                                       '<h4>'                                     =>   '</h4>',                                       
                                       '<h3>'                                     =>   '</h3>',
                                       '<h2>'                                     =>   '</h2>',
                                       '<h1>'                                     =>   '</h1>',                                       
                                       '<span style="color:gray">'                =>   '</span>',
                                       '<span style="color:green">'               =>   '</span>',
                                       '<span style="color:purple">'              =>   '</span>',
                                       '<span style="color:olive">'               =>   '</span>',
                                       '<span style="color:silver">'              =>   '</span>',
                                       '<span style="color:aqua">'                =>   '</span>',
                                       '<span style="color:yellow">'              =>   '</span>',
                                       '<span style="color:blue">'                =>   '</span>',
                                       '<span style="color:orange">'              =>   '</span>',
                                       '<span style="color:red">'                 =>   '</span>',
                                   ), 
    // Не парные теги (смайлики и иже с ними)                       
            'single_tags' => array(
                                  '[:)]'   =>   '<img src="'. IRB_ROOT .'/skins/images/bb/1.gif" />',
                                  '[:(]'   =>   '<img src="'. IRB_ROOT .'/skins/images/bb/2.gif" />',
                                  '[0)]'   =>   '<img src="'. IRB_ROOT .'/skins/images/bb/3.gif" />',
                                  '[=)]'   =>   '<img src="'. IRB_ROOT .'/skins/images/bb/4.gif" />',
                               )
                    );
    }



/**
 * IRB_BBdecoder - class interpreter bb-tags
 * NOTE: Requires PHP version 5 or later and GD version 2.0.1 or later
 * @package irb_bbdecoder
 * @author IT studio IRBIS-team
 * @copyright © 2009 IRBIS-team
 * @version 0.1
 * @license http://www.opensource.org/licenses/rpl1.5.txt
 */ 

class IRB_BBdecoder
{

    private $bb_open;
    private $bb_close;    
    private $bb_single;                                                       
    private $html_open;
    private $html_close;
    private $html_single;
    private $tmp_open;
    private $tmp_close;
    private $tmp_single;
    private $max_len;
    private $links;
    private $images;
    private $video;

    public function __construct()
    {  
        $config   = bbConfig();
        extract($config);
        $confrepl = configReplace();
        extract($confrepl);        
        
        $this->bb_open      = array_keys($setup_bb);
        $this->bb_close     = array_values($setup_bb);                                                        
        $this->html_open    = array_keys($setup_html);
        $this->html_close   = array_values($setup_html);
        $this->bb_single    = array_keys($single_tags);
        $this->html_single  = array_values($single_tags);
     
        $this->tmp_open    = $tmp_open;
        $this->tmp_close   = $tmp_close;
        $this->tmp_single  = $tmp_single;
        $this->max_len     = $max_len;
        $this->links       = $links;
        $this->images      = $images;
        $this->video       = $video;
    }
/**   
* Основной метод интерпретатора
* @param string $text   //обрабатываемый текст
* @return string 
*/   
    public function createBBtags($text)
    {   
        $text = str_replace($this->tmp_open, '', $text);
        $text = str_replace($this->tmp_close, '', $text);
        $text = str_replace($this->tmp_single, '', $text);
                   
        $text = str_replace("\r", "", $text);
        $text = str_replace("\t", "    ", $text);
        
        $text = str_ireplace($this->bb_open, $this->tmp_open, $text);
        $text = str_ireplace($this->bb_close, $this->tmp_close, $text);
        $text = str_ireplace($this->bb_single, $this->tmp_single, $text);  
     
        $open_cnt = array();
     
        foreach($this->tmp_open as $k => $v)
        {
            $text = preg_replace("#". $v ."\s*?". $this->tmp_close[$k] ."#us", "", $text);
            $cnt = substr_count($text, $v);
           
            if($cnt > 0)
            {
               $open_cnt[$v] = $cnt;
               $close_cnt[$v] = substr_count($text, $this->tmp_close[$k]);
            }              
        }
        
     
        foreach($open_cnt as $k => $v)
        {  
            if($v > $close_cnt[$k])
            {
                for($i = 0; $i < $v - $close_cnt[$k]; ++$i)
                    $text = preg_replace('#'. $k .'(?!.*'. $k .')#us', '', $text);
            }  
        }  
       
        $text = $this->mBwordwrap($text, $this->max_len);                 
        $text = htmlspecialchars($text);
       
        if($this->links)
        {                   
            $text = preg_replace_callback('#\[url=http(s*)://([^\] ]+?)\](.+?)\[/url\]#si', 
                                          array($this, 'createLink1'), 
                                          $text
                                          );
            $text = preg_replace_callback('#\[url\]http(s*)://(.+?)\[/url\]#si', 
                                          array($this, 'createLink2'),
                                          $text
                                          );                        
        }    
     
        if($this->images) 
        {    
            $text = preg_replace_callback('#\[img=([^\]]+?)\]http://([^\] \?]+?)\[/img\]#si', 
                                          array($this, 'createImg1'), 
                                          $text);
                                          
            $text = preg_replace_callback('#\[img\]http://([^\] \?]+?)\[/img\]#si', 
                                          array($this, 'createImg2'), 
                                          $text
                                          ); 
        }            
     
        if($this->video)    
            $text = preg_replace_callback('#\[video\]http://([^\] \?]+?).flv\[/video\]#si', 
                                          array($this, 'createSwf'), 
                                          $text
                                          );    
       
        $text = str_replace($this->tmp_open, $this->html_open, $text);
        $text = str_replace($this->tmp_close, $this->html_close, $text);
        $text = str_replace($this->tmp_single, $this->html_single, $text);
     
              
        $text = str_replace('  ', '&nbsp;&nbsp;', $text);    
        $text = nl2br($text);
                    
        return $text;            
    } 

/**   
* Метод очистки текста от BB-тегов
* @param string $text
* @return string  
*/            
    public function stripBBtags($text)
    {
        $text = str_replace($this->bb_open, '', $text);
        $text = str_replace($this->bb_close, '', $text);
        $text = str_replace($this->bb_single, '', $text);
         $text = preg_replace('#\\[(code|url|img|video|html)[^\s]*?\].*?\[/\\1\]#usi', '', $text);      
        return $text;
    }     
 
 /**   
* Аналог wordwrap()  для кодировки UTF-8
* @param string $str  //обрабатываеемая строка
* @param int $width     //максимальная длина слова
* @param string $break //разделитель
* @return string  
*/           
    public function mBwordwrap($text, $width = 74, $break = "\n")
    {
       return preg_replace('#([^\s]{'. $width .'})#u', '$1'. $break , $text);
    }    
 
/**   
* Метод генерации ссылок
* @param array $match 
* @return string 
*/ 
    
    private function createLink1($match)
    {  
        $match[2] = str_replace("\n", "", $match[2]);
        return '<a href="http'. $match[1] .'://'. htmlspecialchars($match[2]) 
              . '" target="_blanck" >'. htmlspecialchars($match[3]) .'</a>'; 
    }
    
    private function createLink2($match)
    {  
        $match[2] = str_replace("\n", "", $match[2]);
        return '<a href="http'. $match[1] .'://'. htmlspecialchars($match[2]) 
              . '" target="_blanck" >'. htmlspecialchars($match[2]) .'</a>'; 
    }

/**   
* Методы генерации картинок
* @param array $match 
* @return string 
*/
    private function createImg1($match)
    {  
        $match[2] = str_replace("\n", "", $match[2]);
        return '<img src="http://'. htmlspecialchars($match[2]) .'" border="0" '
               . 'align="'. htmlspecialchars($match[1]) .'"/>'; 
    }
    
    private function createImg2($match)
    {  
        $match[1] = str_replace("\n", "", $match[1]);
        return '<img src="http://'. htmlspecialchars($match[1]) .'" border="0" />';  
    }
    
/**   
* Метод генерации видеоролика
* @param array $match 
* @return string 
*/
        
    private function createSwf($match)
    {  
        $match[1] = str_replace("\n", "", $match[1]);
         return  '<center><object type="application/x-shockwave-flash" data="'
               . IRB_ROOT .'/skins/images/video.swf" height="300" width="400">'
               . '<param name="bgcolor" value="#333333" /><param name="allowFullScreen" value="true" />'
               . '<param name="allowScriptAccess" value="always" />'
               . '<param name="movie" value="'
               . IRB_ROOT .'/skins/images/video.swf" />'
               . '<param name="FlashVars" value="way=http://'
               . htmlspecialchars($match[1]) .'.flv&amp;swf='
               . IRB_ROOT .'/skins/images/video.swf&amp;w=400&amp;h=300&amp;'
               . 'pic=http://&amp;autoplay=0&amp;tools=1&amp;'
               . 'skin=white&amp;volume=70&amp;q=&amp;comment=" />'
               . '</object></center>';
    }

}


    function configReplace()
    {
        return array(  
        
/** 
Массивы символов замены. Для корректной обработки теги нужно заменить на
одиночные символы, иначе можно порвать тег. Количество символов должно соответствовать количеству тегов.
Используются редко используемые символы 
*/
        // Открывающие теги
                'tmp_open'   => array(
                                       'ᐁ', 'ᐂ', 'ᐃ', 'ᐄ', 'ᐅ', 'ᐆ', 'ᐇ', 'ᐉ', 'ᐊ', 'ᐋ', 
                                       'ᐌ', 'ᐍ', 'ᐎ', 'ᐏ', 'ᐐ', 'ᐑ', 'ᐒ', 'ᐓ', 'ᐔ', 'ᐕ', 
                                       'ᐫ', 'ᐬ', 'ᐭ', 'ᐮ', 'ᐯ', 'ᐰ', 'ᐱ', 'ᐲ', 'ᐳ', 'ᐴ', 
                                       'ᐵ', 'ᐷ', 'ᐸ', 'ᐹ', 'ᐺ', 'ᐻ', 'ᐼ', 'ᐽ', 'ᐾ', 'ᐿ', 
                                       'ᑌ', 'ᑍ', 'ᑎ', 'ᑏ', 'ᑐ', 'ᑑ', 'ᑒ', 'ᑔ', 'ᑕ', 'ᑖ',
                                    ),                               
        // Закрывающие теги                  
                'tmp_close'  => array(
                                        
                                       'ᑗ', 'ᑘ', 'ᑙ', 'ᑚ', 'ᑛ', 'ᑜ', 'ᑝ', 'ᑞ', 'ᑟ', 'ᑠ',  
                                       'ᑡ', 'ᑢ', 'ᑣ', 'ᑤ', 'ᑥ', 'ᑧ', 'ᑨ', 'ᑩ', 'ᑪ', 'ᑫ',
                                       'ᑬ', 'ᑭ', 'ᑮ', 'ᑯ', 'ᑰ', 'ᑱ', 'ᑲ', 'ᑳ', 'ᑴ', 'ᑵ', 
                                       'ᑶ', 'ᑷ', 'ᑸ', 'ᑹ', 'ᑺ', 'ᑻ', 'ᑼ', 'ᑽ', 'ᑾ', 'ᑿ', 
                                       'ᒀ', 'ᒁ', 'ᒂ', 'ᒌ', 'ᒍ', 'ᒎ', 'ᒏ', 'ᒐ', 'ᒑ', 'ᒒ',
                                    ),                            
        // Одиночные теги                                  
                'tmp_single' => array(                  
                                       'ᒓ', 'ᒔ', 'ᒕ', 'ᒖ', 'ᒗ', 'ᒘ', 'ᒙ', 'ᒚ', 'ᒛ', 'ᒜ', 
                                       'ᒝ', 'ᒞ', 'ᒟ', 'ᒠ', 'ᒣ', 'ᒤ', 'ᒥ', 'ᒦ', 'ᒧ', 'ᒨ', 
                                       'ᒩ', 'ᒪ', 'ᒫ', 'ᒬ', 'ᒭ', 'ᒮ', 'ᒯ', 'ᒰ', 'ᒱ', 'ᒲ', 
                                       'ᒳ', 'ᒴ', 'ᒵ', 'ᒶ', 'ᒷ', 'ᒸ', 'ᒹ', 'ᒺ', 'ᓀ', 'ᓁ', 
                                       'ᓂ', 'ᓃ', 'ᓄ', 'ᓅ', 'ᓆ', 'ᓇ', 'ᓈ', 'ᓉ', 'ᓊ', 'ᓋ', 
                                    ),
                     );
    }




























