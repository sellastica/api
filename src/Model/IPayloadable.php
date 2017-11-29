<?php
namespace Sellastica\Api\Model;

interface IPayloadable
{
	/**
	 * @return PayloadObject
	 */
	function toPayloadObject();
}
