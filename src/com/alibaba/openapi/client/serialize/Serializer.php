<?php

namespace Wwy\client\serialize;

interface Serializer
{
	public function supportedContentType();
	public function serialize($serializer);
}
