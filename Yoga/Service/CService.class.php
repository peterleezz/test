<?php
namespace Service;
class CService 
{
    
    /**
     * 获取一个CService实现
     * @param string $methodPrefix
     * @return CService
     */
    public static function factory($methodPrefix){
        $className = "Service\\".$methodPrefix . 'Service';
        if( !isset( self::$_loadedSevices[$className] )){
//            self::$_loadedSevices[$className] = new CAOP(new $className);
            self::$_loadedSevices[$className] = new $className;
        }

        return self::$_loadedSevices[$className];
    }


    /**
     * 返回该service实例最后一次方法调用是成功还是失败，如果失败，错误描述调用getError返回。
     *
     * @return boolean
     */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * 将Service的状态回到初始正确的状态。这个方法是给单元测试用例准备的。
	 * 在正常的业务代码中如果SERVICE的某个方法产生了错误，则认为这个SERVICE已经异常，代码不应该继续执行下去了。
	 * 所以在业务代码中不要调用这个方法来复位。
	 *
	 */
	public function cleanStatus() {
		$this->status = true;
		$this->errorMessage ="";
	}

	/**
	 * 参见getStatus
	 *
	 * @return array 错误信息格式array(<code> => <message>, ...);
	 */
	public function getError() {
		return $this->errorMessage;
	}

	/**
	 * 设置错误信息。输入参数为在error.php中定义的key，或者是一个CError对象：
	 * 如果KEY是一个STRING， 如果KEY只没有定义，则会抛出异常，这样做的目的是保证每个错误的设置对应一个唯一的错误定义。
	 * 如果KEY是一个数组，则CODE必须符合错误代码的规则
	 *
	 * @param string|CError $errorKey
	 */
	protected function setError($errorKey) {
		$this->status = false;  
		if (is_string($errorKey)) {
			$error=C("ERROR.$errorKey");
			if (empty($error)) {
				$this->errorMessage .= $errorKey;
			} else {		
				$error=C("ERROR.$errorKey");	
				$this->errorMessage .= $error;
			}
		}  else {
			throw new Exception ("Unknown error key type");
		}
	}

	protected function clearError()
	{
		$this->errorMessage  = "";
	}
	/**
	 * 方法调用是否成功失败，成功为true，失败为false;
	 * CService的继承者在实现每个方法的时候，如果需要返回错误信息给调用者，则调用setError方法来设置错误信息，该方法会把status标志置为false;
	 * 错误信息为一个字符串。
	 * @var boolean
	 */
	protected $status = true;
	/**
	 * 参见$responseStatus的描述
	 * @var string
	 */
	protected $errorMessage;

    protected static $_loadedSevices = array();

}
