<?php
namespace Base\model;



class cssCreator
{
    
    private $css;
    private $cssFolder = '/public/cache/css/';
    private $Namecss;
    public function __construct($name="global.css") {
        $this->css = array();
        $this->Namecss = $name;
        $this->path = "";
    }
    
    public function addCss($css)
    {
        $this->css = $css;
    }
 
    
    public function setName($name)
    {
        $this->Namecss = $name;
    }
    
    private function MKD()
    {
         if(!file_exists(PROJECT_DIR.$this->cssFolder))
        {
            mkdir(PROJECT_DIR.$this->cssFolder,0777);
            
        }
        
  
    }
    
    private function crearCss()
    {
        $this->MKD();
        $buffer = "";
        if(is_array($this->css))
        {
            foreach($this->css as $file)
            {
                                               
                $buffer .= str_replace(array("../","fonts/franky-font."),
                        array(dirname($file)."/../",dirname($file)."/fonts/franky-font."),
                        file_get_contents(PROJECT_DIR.$file));

            }
        }
        else
        {
            $buffer = str_replace(array("../","fonts/franky-font."),
                    array(dirname($this->css)."/../",dirname($this->css)."/fonts/franky-font."),
                    file_get_contents(PROJECT_DIR.$this->css));
        }

        $globalFile = fopen(PROJECT_DIR.$this->cssFolder.$this->Namecss, 'w');
        
        
        
        $contenidoCss = $this->minify($buffer);

        $objDate = new \DateTime();
        $objDate->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        fwrite($globalFile,'/***ARCHIVO GENERADO: '.$objDate->format(\DateTime::ISO8601).'***/ '.$contenidoCss);

        fclose($globalFile);

        chmod(PROJECT_DIR.$this->cssFolder.$this->Namecss, 0777);
    }
    
    private function minify($contenido)
    {
        $comprimido='';
        // Remove comments
        $comprimido = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contenido);

        // Remove space after colons
        $comprimido = str_replace(': ', ':', $comprimido);

        // Remove whitespace
        $comprimido = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $comprimido);
        
        
        return $comprimido;
    }
    
    
    public function  get($version)
    {
        if(!file_exists(PROJECT_DIR.$this->cssFolder.$version."/".$this->Namecss))
        {
         
            $this->crearCss();
        }
        
        return $this->cssFolder.$this->Namecss;
        
        
    }
    
    
}
