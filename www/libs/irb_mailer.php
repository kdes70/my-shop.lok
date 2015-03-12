<?php  

/** 
 * IRB_Mailer - PHP email transport class 
 * NOTE: Requires PHP version 5 or later  
 * Info: http://irbis-team.ru   
 * @author IT studio IRBIS-team 
 * @copyright © 2009 IRBIS-team 
 * @version 0.1 
 * @license http://www.opensource.org/licenses/rpl1.5.txt 
 */   

class IRB_Mailer   
{   

  ///////////////////////////////////////////////// 
  //               PUBLIC 
  ///////////////////////////////////////////////// 

  /** 
   * Establishes the address of the addressee 
   * Устанавливает адрес получателя    
   * @var string 
   */       
  public $to;  
   
  /** 
   * Sets the From email address for the message. 
   * Устанавливает адрес получателя.    
   * @var string 
   */      
  public $from;  
   
  /** 
   * Sets the Subject of the message. 
   * Устанавливает адрес получателя    
   * @var string 
   */      
  public $subject;  
   
  /** 
   * Sets the Body of the message.  
   * Устанавливает тело сообщения    
   * @var string 
   */          
  public $message; 
     
  /** 
   * Errors of performance of the program. 
   * @var array 
   */   
  public $mailererrors    = array(  
                      
                     'no_text'          => 'There is no message text', 
                     'no_file'          => 'The path to a file is not specified', 
                     'no_path'          => 'There is no file on the specified path',
                     'no_addresse'      => 'There is no addresse', 
                     'not_correct'      => 'The e-mail address is not correct', 
                     'no_sender'        => 'There is no sender',                    
                     'no_theme'         => 'There is no theme', 
                     'no_send'          => 'For technical reasons letter sending 
                                            is impossible at present',
                 
                                 );     
  ///////////////////////////////////////////////// 
  //         PROPERTIES AND  PRIVATE 
  /////////////////////////////////////////////////      
    private $n = "\n";    
    private $boundary1;   
    private $boundary2;       
    private $html = false;   
    private $attach = false;       
    private $multipart; 
    private $headers;   
    private $attachment;         
    private $errors = array();   
    private $dummy = 'Your post client does not support specification MIME 1.0    
    For correct display of the letter you should replace the post program.'; 
     
  ///////////////////////////////////////////////// 
  // METHODS, VARIABLES 
  /////////////////////////////////////////////////     
               
  /** 
  * Constructor.    
  * @param string $message       
  * @Establishes a symbol of carrying over of a line and dividers, 
  * Language of error messages,   
  * and  prepares the message in a text kind. 
  * Конструктор. Устанавливает символ переноса строки и разделители, 
  * язык сообщений об ошибках, 
  * а так же готовит сообщение в текстовом виде           
  */       
  public function __construct($message = false, $language = false)   
  { 
       
    if(substr(PHP_OS, 0, 3) == "WIN")   
      $this->n = "\r\n"; 
       
      $this->boundary1 = '==' . md5(uniqid(time())); 
      $this->boundary2 = '==' . md5(uniqid(time())); 
            
    if(is_array($language)) 
      $this->mailererrors = $language;  
       
    if($message)   
    { 
      $this->message = $message; 
      $this->headers = $this->dummy . $this->n . $this->n . $this->headers .
      '--' . $this->boundary2 . $this->n; 
      $this->headers .= 'Content-type: text/plain; charset="utf-8"' . $this->n; 
      $this->headers .= 'Content-Transfer-Encoding: base64' . $this->n . $this->n; 
      $this->multipart = $this->headers . chunk_split(base64_encode($this->message)) . $this->n; 
    } 
     else   
    { 
      $this->errors[] = $this->mailererrors['no_text']; 
    } 
  }       
     
/** 
* Method of an attachment of a file. 
* Метод прикрепления файла  
* @access public     
* @param string  $file and $filename       
* @return void 
*/    
  public function attacheFile($file = false, $filename = false)   
  { 
          
    if($file)   
    { 
      $this->attach = true; 
                                
      if(file_exists($file))   
      { 
           
        if(!$filename)   
          $filename = basename($file); 
        else   
          $filename = '=?utf-8?b?'. base64_encode($filename) .'?='. strrchr(basename($file), "."); 
            
         $this->attachment = 'Content-type: application/octet-stream; name="'. $filename .'"'. $this->n; 
         $this->attachment .= 'Content-disposition: attachment;  filename="'. $filename .'"'. $this->n; 
         $this->attachment .= 'Content-Transfer-Encoding: base64'. $this->n . $this->n; 
         $this->attachment .= chunk_split(base64_encode(file_get_contents($file))) . $this->n . $this->n; 
      } 
       else   
      { 
        $this->errors[] = $this->mailererrors['no_path']; 
      } 
    } 
     else   
    { 
      $this->errors[] = $this->mailererrors['no_file']; 
    } 
  }  
     
/** 
* Sets message type to HTML. 
* Устанавливает HTML формат сообщения 
* @access public          
* @return void 
*/     
   public function setHtml()   
   {   
      
     $this->html = true;   
     $this->multipart  = '';         
         
     if($this->attach)   
     {   
       $this->multipart  = '--'. $this->boundary1 . $this->n;   
       $this->multipart .= 'Content-type: multipart/alternative; boundary="'. 
       $this->boundary2 .'"'. $this->n.$this->n;                
     }   
               
     $this->multipart .=  $this->headers;    
     $this->multipart .= chunk_split(base64_encode(strip_tags($this->message))) . $this->n;          
     $this->multipart .=  '--'. $this->boundary2 . $this->n;         
     $this->multipart .= 'Content-type: text/html; charset="utf-8"'. $this->n;   
     $this->multipart .= 'Content-Transfer-Encoding: base64'. $this->n. $this->n;   
     $this->multipart .= chunk_split(base64_encode($this->message)) . $this->n; 
     $this->multipart  .= '--'. $this->boundary2 .'--';         
   }  
     
/** 
* Adds a "To" address.. 
* Устанавливает адрес "Кому" 
* @access public 
* @param string  $to          
* @return void 
*/     
   public function createTo($to = false)   
   {   
      if(!$to)   
        $this->errors[] = $this->mailererrors['no_addresse'];    
      elseif(!preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $to))  
        $this->errors[] = $this->mailererrors['not_correct'];   
      else  
        $this->to = trim($to);  
   }   
     
/** 
* Adds a "From" address. 
* Устанавливает адрес "От кого" 
* @access public 
* @param string  $from          
* @return void 
*/     
   public function createFrom($from = false)   
   {   
      if($from)      
        $this->from = trim(preg_replace('/[\r\n]+/', ' ', $from));   
      else   
        $this->errors[] = $this->mailererrors['no_sender'];         
   }   
     
/** 
* Adds a Subject. 
* Устанавливает тему сообщения 
* @access public 
* @param string  $subject          
* @return void 
*/     
   public function createSubject($subject = false)   
   {   
      if($subject)   
        $this->subject = '=?utf-8?b?'. base64_encode($subject) .'?=';   
      else   
        $this->errors[] = $this->mailererrors['no_theme'];         
   }   
     
/** 
* Forms the letter. 
* Формирует письмо 
* @access private         
* @return string 
*/  
  private function createMail()   
  { 
      $host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
      $header  = 'Date: '. date('D, d M Y h:i:s O') . $this->n;       
      $header .= 'From: '. $this->from .' <'. $this->from .'>'. $this->n; 
      $header .= 'Message-ID: <'. md5(uniqid(time())) .'@'. $host .'>'. $this->n;      
      $header .= 'X-Priority: 3: '. $this->n;   
      $header .= 'X-Mailer:  IRB_Mailer 1.0 (irbis-team.ru)'. $this->n;      
      $header .= 'MIME-Version: 1.0' . $this->n;     

         
    if($this->html && !$this->attach)   
    { 
       $header .= 'Content-type: multipart/alternative; boundary="'. $this->boundary2 .'"'; 
    } 
    elseif($this->html && $this->attach)   
    { 
       $header .= 'Content-type: multipart/mixed; boundary="'. $this->boundary1 .'"'; 
       $this->multipart .= $this->n .'--'. $this->boundary1 . $this->n; 
       $this->multipart .= $this->attachment; 
       $this->multipart .= '--'. $this->boundary1 .'--'. $this->n; 
    } 
    elseif($this->attach)   
    { 
       $header .= 'Content-type: multipart/mixed; boundary="'. $this->boundary2 .'"'; 
       $this->multipart .= '--'. $this->boundary2 . $this->n; 
       $this->multipart .= $this->attachment; 
       $this->multipart .= '--'. $this->boundary1 .'--'. $this->n; 
    } 
     else   
    { 
       $header .= 'Content-type: multipart/related; boundary="'. $this->boundary2 .'"'; 
       $this->multipart .= '--'. $this->boundary2 .'--'. $this->n; 
    } 
      return $header; 
  }    
       
/** 
* Deduces a script error. 
* Диагностика ошибок     
* @access private    
* @return string or boolean 
*/       
   private function checkData()   
   {   
      if(count($this->errors))    
        return "IRB_Mailer error: \n". implode("\n", $this->errors);   
      else   
        return false;     
   }   
       
/** 
* Sends mail using the PHP mail() function. 
* Отправляет письмо используя PHP функцию  mail()    
* @access public    
* @return string  
*/  
   public function sendMail()   
   {            
      if(!$error = $this->checkData())   
      {      
            
        $header = $this->createMail();   
               
        if(!mail($this->to, $this->subject, $this->multipart, $header, '-f'. $this->from))   
           return "IRB_Mailer error: \n". $this->mailererrors['no_send'];   
        else   
           return NULL;   
      }   
      else   
      {   
        return $error;   
      }   
   }     
} 

