<?php

namespace Wwy\umeng\uapp\param; 

use Wwy\client\entity\SDKDomain;
use Wwy\client\entity\ByteArray;

class UmengUappGetAllAppDataParam
{

    private $sdkStdResult=array();
    
    public function getSdkStdResult()
    {
    	return $this->sdkStdResult;
    }

}
