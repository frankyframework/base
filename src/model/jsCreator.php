<?php
namespace Base\model;
use Base\model\Minifier;


class jsCreator
{
    
    private $js;   
    private $embebed;   
    private $jsFolder = '/public/cache/js/';
    private $Namejs;
    public function __construct($name="global.js") {
        $this->js = array();
        $this->Namejs = $name;
        $this->path = "";
        $this->embebed = "";
    }
    
    public function addJs($js)
    {
        $this->js = $js;
    }
    
    public function setEmbebed($code)
    {
        $this->embebed = $code;
    }
    

    public function setName($name)
    {
        $this->Namejs = $name;
    }
    
    private function MKD()
    {
        
         if(!file_exists(PROJECT_DIR.$this->jsFolder))
        {
            mkdir(PROJECT_DIR.$this->jsFolder,0777);
            
        }
    }
   
    
   
    private function crearJs()
    {
        $this->MKD();
        $buffer = "";
        if(is_array($this->js))
        {
            foreach($this->js as $file)
            {
                $buffer .= file_get_contents(PROJECT_DIR.$file);
            }
        }
        else
        {
            $buffer = file_get_contents($this->js);
        }

       
        
        $globalFile = fopen(PROJECT_DIR.$this->jsFolder.$this->Namejs, 'w');
        

        $contenidoJs = Minifier::minify($buffer."\n".$this->embebed);

        $objDate = new \DateTime();
        $objDate->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        fwrite($globalFile,'/***ARCHIVO GENERADO: '.$objDate->format(\DateTime::ISO8601).'***/ '.$contenidoJs);

        fclose($globalFile);

        chmod(PROJECT_DIR.$this->jsFolder.$this->Namejs, 0777);
    }
    

    
    public function  get($version)
    {
        if(!file_exists(PROJECT_DIR.$this->jsFolder.$version."/".$this->Namejs))
        {
            $this->crearJs();
        }
        return $this->jsFolder.$this->Namejs;   
    }
    
    
}
