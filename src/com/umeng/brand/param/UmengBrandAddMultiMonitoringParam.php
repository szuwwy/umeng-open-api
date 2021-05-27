<?php

namespace Wwy\umeng\brand\param; 

use Wwy\client\entity\SDKDomain;
use Wwy\client\entity\ByteArray;
use Wwy\umeng\brand\param\UmengBrandMonitoring;

class UmengBrandAddMultiMonitoringParam 
{

        
    /**
     * @return 多个监测单元信息
     */
    public function getMonitorings() 
    {
        $tempResult = $this->sdkStdResult["monitorings"];
        return $tempResult;
    }
    
    /**
     * 设置多个监测单元信息     
     * @param array include @see UmengBrandMonitoring[] $monitorings     
     * 参数示例：<pre></pre>     
     * 此参数必填     
     */
    public function setMonitorings(UmengBrandMonitoring $monitorings) 
    {
        $this->sdkStdResult["monitorings"] = $monitorings;
    }
    
        
    private $sdkStdResult = array();
    
    public function getSdkStdResult()
    {
    	return $this->sdkStdResult;
    }

}
