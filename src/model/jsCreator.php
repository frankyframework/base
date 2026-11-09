<?php
namespace Base\model;

class jsCreator
{
    private array|string $js;   
    private string $embebed;   
    private string $version;   
    private $jsFolder = '/public/cache/js/';
    private string $Namejs;

    public function __construct($name="global.js") {
        $this->js = array();
        $this->embebed = '';
        $this->Namejs = $name;
  
    }
    
    public function addJs(array|string $js)
    {
        $this->js = $js;
    }
    
    public function setEmbebed(string $code)
    {
        $this->embebed = $code;
    }
    

    public function setName(string $name)
    {
        $this->Namejs = $name;
    }
    
    private function MKD()
    {
        if(!file_exists(PROJECT_DIR.$this->jsFolder))
        {
            mkdir(PROJECT_DIR.$this->jsFolder,0777);
            
        }
        if(!file_exists(PROJECT_DIR.$this->jsFolder.$this->version))
        {
            mkdir(PROJECT_DIR.$this->jsFolder.$this->version,0777);
            
        }
    }
   
    
   
    private function crearJs()
    {
        $this->MKD();
        $buffer = "";
        if (is_array($this->js)) {
            foreach ($this->js as $file) {
                $buffer .= file_get_contents(PROJECT_DIR . $file);
            }
        } else {
            $buffer = file_get_contents(PROJECT_DIR . $this->js);
        }

        $contenidoJs = $buffer . "\n" . $this->embebed;
        $contenidoJs = $this->minifyJs($contenidoJs);

        $globalFile = fopen(PROJECT_DIR . $this->jsFolder . $this->version . "/" . $this->Namejs, 'w');

        $objDate = new \DateTime();
        $objDate->setTimezone(new \DateTimeZone('America/Mexico_City'));

        fwrite($globalFile, '/***ARCHIVO GENERADO: ' . $objDate->format(\DateTime::ISO8601) . '***/ ' . $contenidoJs);

        fclose($globalFile);

        chmod(PROJECT_DIR . $this->jsFolder . $this->version . "/" . $this->Namejs, 0777);
    }
    
    private function minifyJs(string $js): string
    {
        $binario = PROJECT_DIR . '/node_modules/.bin/esbuild';
        if (!is_executable($binario) || !function_exists('shell_exec')) {
            // Fallback: devolver el JS sin minificar en lugar de colgar el request
            return $js;
        }

        $archivoTmp = tempnam(sys_get_temp_dir(), 'jsmin_');
        file_put_contents($archivoTmp, $js);

        $cmd = $binario . ' ' . escapeshellarg($archivoTmp) . ' --minify 2>/dev/null';
        $salida = shell_exec($cmd);

        unlink($archivoTmp);

        return ($salida !== null && $salida !== '') ? $salida : $js;
    }
    
    public function  get(string $version)
    {
        $this->version =  $version;
        if(!file_exists(PROJECT_DIR.$this->jsFolder.$version."/".$this->Namejs))
        {
            $this->crearJs();
        }
        return $this->jsFolder.$version."/".$this->Namejs;   
    }
}