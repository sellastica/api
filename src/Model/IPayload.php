<?php
namespace Sellastica\Api\Model;

interface IPayload
{
	/**
	 * @param array $fields
	 * @return array
	 */
	function toArray(array $fields = []);

	/**
	 * @return string
	 */
	static function getShortName();

	/**
	 * @return array
	 */
	static function getEndpointFilters();
}
