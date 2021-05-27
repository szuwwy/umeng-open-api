<?php

namespace Wwy\example;

use Wwy\client\APIId;
use Wwy\client\APIRequest;
use Wwy\client\APIResponse;
use Wwy\client\SyncAPIClient;

use Wwy\client\entity\AuthorizationToken;
use Wwy\client\entity\ParentResult;
use Wwy\client\entity\ResponseStatus;
use Wwy\client\entity\ResponseWrapper;

use Wwy\client\policy\ClientPolicy;
use Wwy\client\policy\DataProtocol;
use Wwy\client\policy\RequestPolicy;

use Wwy\example\param\apiexample\ExampleFamilyGetParam;
use Wwy\example\param\apiexample\ExampleFamilyPostParam;
use Wwy\example\param\apiexample\ExampleFamilyGetResult;
use Wwy\example\param\apiexample\ExampleFamilyPostResult;

class ExampleFacade
{
	private $serverHost = "gateway.open.umeng.com";
	private $httpPort = 80;
	private $httpsPort = 443;
	private $appKey;
	private $secKey;
	private $syncAPIClient;

	public function setServerHost($serverHost)
	{
		$this->serverHost = $serverHost;
	}

	public function setHttpPort($httpPort)
	{
		$this->httpPort = $httpPort;
	}

	public function setHttpsPort($httpsPort)
	{
		$this->httpsPort = $httpsPort;
	}

	public function setAppKey($appKey)
	{
		$this->appKey = $appKey;
	}

	public function setSecKey($secKey)
	{
		$this->secKey = $secKey;
	}

	public function initClient()
	{
		$clientPolicy = new ClientPolicy ();
		$clientPolicy->appKey = $this->appKey;
		$clientPolicy->secKey = $this->secKey;
		$clientPolicy->httpPort = $this->httpPort;
		$clientPolicy->httpsPort = $this->httpsPort;
		$clientPolicy->serverHost = $this->serverHost;
		
		$this->syncAPIClient = new SyncAPIClient ( $clientPolicy );
	}

	public function getAPIClient()
	{
		if ($this->syncAPIClient == null) {
			$this->initClient ();
		}
		return $this->syncAPIClient;
	}
	
	/**
	 * 鏍规嵁鎺堟潈鐮佹崲鍙栨巿鏉冧护鐗�
	 *
	 * @param
	 *        	code 鎺堟潈鐮�
	 * @return 鎺堟潈浠ょ墝
	 */
	public function getToken($code)
	{
		$reqPolicy = new RequestPolicy ();
		$reqPolicy->httpMethod = "POST";
		$reqPolicy->needAuthorization = false;
		$reqPolicy->requestSendTimestamp = true;
		$reqPolicy->useHttps = true;
		$reqPolicy->requestProtocol = DataProtocol::param2;
		
		$request = new APIRequest ();
		$request->addtionalParams ["code"] = $code;
		$request->addtionalParams ["grant_type"] = "authorization_code";
		$request->addtionalParams ["need_refresh_token"] = true;
		$request->addtionalParams ["client_id"] = $this->appKey;
		$request->addtionalParams ["client_secret"] = $this->secKey;
		$request->addtionalParams ["redirect_uri"] = "default";
		$apiId = new APIId ( "system.oauth2", "getToken", $reqPolicy->defaultApiVersion );
		$request->apiId = $apiId;
		
		$resultDefinition = new AuthorizationToken ();
		$this->getAPIClient ()->send ( $request, $resultDefinition, $reqPolicy );
		return $resultDefinition;
	}
	
	/**
	 * 鍒锋柊token
	 *
	 * @param
	 *        	refreshToken refresh 浠ょ墝
	 * @return 鎺堟潈浠ょ墝
	 */
	public function refreshToken($refreshToken)
	{
		$reqPolicy = new RequestPolicy ();
		$reqPolicy->httpMethod = "POST";
		$reqPolicy->needAuthorization = false;
		$reqPolicy->requestSendTimestamp = true;
		$reqPolicy->useHttps = true;
		$reqPolicy->requestProtocol = DataProtocol::param2;
		
		$request = new APIRequest ();
		$request->addtionalParams ["refreshToken"] = $refreshToken;
		$request->addtionalParams ["grant_type"] = "refresh_token";
		$request->addtionalParams ["client_id"] = $this->appKey;
		$request->addtionalParams ["client_secret"] = $this->secKey;
		$apiId = new APIId ( "system.oauth2", "getToken", $reqPolicy->defaultApiVersion );
		$request->apiId = $apiId;
		
		$resultDefinition = new AuthorizationToken ();
		$this->getAPIClient ()->send ( $request, $resultDefinition, $reqPolicy );
		return $resultDefinition;
	}

	public function exampleFamilyGet(ExampleFamilyGetParam $param, ExampleFamilyGetResult $resultDefinition)
	{
		$reqPolicy = new RequestPolicy ();
		$reqPolicy->httpMethod = "POST";
		$reqPolicy->needAuthorization = false;
		$reqPolicy->requestSendTimestamp = false;
		$reqPolicy->useHttps = false;
		$reqPolicy->useSignture = false;
		$reqPolicy->accessPrivateApi = false;
		
		$request = new APIRequest ();
		$apiId = new APIId ( "api.example", "example.family.get", 1 );
		$request->apiId = $apiId;
		
		$request->requestEntity = $param;
		
		$this->getAPIClient ()->send ( $request, $resultDefinition, $reqPolicy );
	}

	public function exampleFamilyPost(ExampleFamilyPostParam $param, $accessToken, ExampleFamilyPostResult $resultDefinition)
	{
		$reqPolicy = new RequestPolicy ();
		$reqPolicy->httpMethod = "POST";
		$reqPolicy->needAuthorization = true;
		$reqPolicy->requestSendTimestamp = false;
		$reqPolicy->useHttps = false;
		$reqPolicy->useSignture = true;
		$reqPolicy->accessPrivateApi = false;
		
		$request = new APIRequest ();
		$apiId = new APIId ( "api.example", "example.family.post", 1 );
		$request->apiId = $apiId;
		
		$request->requestEntity = $param;
		$request->accessToken = $accessToken;
		$this->getAPIClient ()->send ( $request, $resultDefinition, $reqPolicy );
	}
}
