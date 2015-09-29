<?php
 
class LogService {
    private $_logConfig;
    private $moduleName;
    const LOG_LEVEL_NONE = 0x00;
    const LOG_LEVEL_DEBUG = 0x01;
    const LOG_LEVEL_INFO = 0x02;
    const LOG_LEVEL_WARN = 0x10;
    const LOG_LEVEL_ERROR = 0x20;
    const LOG_LEVEL_ALL = 0xFF;

    
    function __construct($moduleName, $file_name = null){
         $log =   array( 
        'log_level' => 0xFF, // 0 - debug, 1 - info, 2 - warn, 3 - error
        'trace' => 0, // 是否将调用链和行号都打出来。 0 - 不打印, 1 - 打印。
    );

    	$this->moduleName = $moduleName;
    	$this->_logConfig = $log;
        if ($file_name){
            $this->_logConfig['log_file_name'] =  dirname(__FILE__) . DIRECTORY_SEPARATOR . $file_name;
        }
    }

    public function debug($msg){
    	$this->log($msg, self::LOG_LEVEL_DEBUG);
    }

    public function info($msg){
    	$this->log($msg, self::LOG_LEVEL_INFO);
    }

    public function warn($msg){
    	$this->log($msg, self::LOG_LEVEL_WARN);
    }

    public function error($msg){
    	$this->log($msg, self::LOG_LEVEL_ERROR);
    }

    public function dump($msg){
        ob_start();
        error_log(date('Y-m-d h:i:s') . ": \n", 3, $this->_logConfig['log_file_name']);
        var_dump($msg);
        error_log(ob_get_clean(), 3, $this->_logConfig['log_file_name']);
    }


    public function log($msg, $level) {
    	if ($level & $this->_logConfig['log_level']) {
            if (!is_string($msg)){
                $msg = var_export($msg, true);
            }
	        $msg = date('Y-m-d h:i:s') . " [" . $this->moduleName . "] - LV{$level} - " . $msg . "\n";
	        if ($this->_logConfig['trace'] != 0) {
	        	$msg .= $this->getCallChain() . "\n";
	        }
	        error_log($msg, 3, $this->_logConfig['log_file_name']);
    	}
    }


    private function getCallChain() {
		//Get root calling module name
        /**
         * @see http://php.net/manual/en/function.debug-backtrace.php
         *
         * debug_backtrace has diffrent args before and after 5.3.6
         */
		$tr = debug_backtrace();

		//Get caller stack
		$ident = "\t";
		$call_chain = "";
		foreach ($tr as $t) {
            if(!empty($t['file'])){
                $call_chain .= $ident . $this->getFileName($t['file']) .":" . $t['line'] . " -> " . $t['function'] . "\n";
                $ident .= $ident;
            }
		}

		return $call_chain;
    }
	private function getFileName($pathName) {
		$ret = $pathName;
		$pn = str_replace('\\', '/', $pathName);
		$rp = strrpos($pn, "/");
		if ($rp >= 0) {
			$ret = substr($pathName, $rp+1);
		}
		return $ret;
	}
}
