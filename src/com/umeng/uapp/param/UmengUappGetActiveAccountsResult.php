<?php

namespace Wwy\umeng\uapp\param; 

use Wwy\client\entity\SDKDomain;
use Wwy\client\entity\ByteArray;
use Wwy\umeng\uapp\param\UmengUappActiveAccountInfo;

class UmengUappGetActiveAccountsResult
{

    private $activeAccountInfo;
    
    /**
     * @return 
     */
    public function getActiveAccountInfo()
    {
        return $this->activeAccountInfo;
    }
    
    /**
     * 设置     
     * @param array include @see UmengUappActiveAccountInfo[] $activeAccountInfo     
     * 此参数必填     
     */
    public function setActiveAccountInfo(UmengUappActiveAccountInfo $activeAccountInfo)
    {
        $this->activeAccountInfo = $activeAccountInfo;
    }
    
    	
	private $stdResult;
	
	public function setStdResult($stdResult)
    {
		$this->stdResult = $stdResult;
		if (array_key_exists ( "activeAccountInfo", $this->stdResult )) {
			$activeAccountInfoResult=$this->stdResult->{"activeAccountInfo"};
			$object = json_decode ( json_encode ( $activeAccountInfoResult ), true );
			$this->activeAccountInfo = array ();
			for($i = 0; $i < count ( $object ); $i ++) {
				$arrayobject = new \ArrayObject ( $object [$i] );
				$UmengUappActiveAccountInfoResult=new UmengUappActiveAccountInfo();
				$UmengUappActiveAccountInfoResult->setArrayResult($arrayobject );
				$this->activeAccountInfo [$i] = $UmengUappActiveAccountInfoResult;
			}
		}
    }
	
	private $arrayResult;

	public function setArrayResult($arrayResult)
    {
		$this->arrayResult = $arrayResult;
		if (array_key_exists ( "activeAccountInfo", $this->arrayResult )) {
    		$activeAccountInfoResult=$arrayResult['activeAccountInfo'];
    		$this->activeAccountInfo = new UmengUappActiveAccountInfo();
    		$this->activeAccountInfo->setStdResult ( $activeAccountInfoResult);
    	}
    }

}
