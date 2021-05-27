<?php

namespace Wwy\client\serialize;

use Wwy\client\serialize\DeSerializer;
use Wwy\client\exception\OceanException;

class Json2Deserializer implements DeSerializer
{
	public function supportedContentType()
	{
		return DataProtocol::json2;
	}

	public function deSerialize($deSerializer, $resultDefinition, $charSet = null)
	{
		$stdResult = json_decode($deSerializer);
		$resultDefinition->setStdResult($stdResult);
		return $resultDefinition;
	}

	public function buildException($deSerializer, $resultType, $charSet = null)
	{
		$exceptionStdResult = json_decode($deSerializer);
		$errorCode = $exceptionStdResult->{"error_code"};
		$errorMessage = $exceptionStdResult->{"error_message"};
		
		$oceanException = new OceanException($errorMessage);
		$oceanException->setErrorCode($errorCode);
		return $oceanException;
	}
}
