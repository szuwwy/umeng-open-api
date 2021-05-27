<?php

namespace Wwy\client\serialize;

use Wwy\client\policy\DataProtocol;
use Wwy\client\serialize\Json2Deserializer;
use Wwy\client\serialize\Param2RequestSerializer;

class SerializerProvider
{
	private static $serializerStore = array();
	private static $deSerializerStore = array();
	private static $isInited = false;

	private static function initial()
	{
		SerializerProvider::$serializerStore [DataProtocol::param2] = new Param2RequestSerializer();
		SerializerProvider::$deSerializerStore [DataProtocol::json2] = new Json2Deserializer();
		SerializerProvider::$deSerializerStore [DataProtocol::param2] = new Json2Deserializer();
		$isInited = true;
	}

	public static function getSerializer($key) 
	{
		if (! SerializerProvider::$isInited) {
			SerializerProvider::initial();
		}
		$result = SerializerProvider::$serializerStore[$key];
		return $result;
	}

	public static function getDeSerializer($key) 
	{
		if (! SerializerProvider::$isInited) {
			SerializerProvider::initial();
		}
		$result = SerializerProvider::$deSerializerStore[$key];
		return $result;
	}
}
