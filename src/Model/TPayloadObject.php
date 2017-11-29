<?php
namespace Sellastica\Api\Model;

use Sellastica\Utils\Strings;

trait TPayloadObject
{
	/**
	 * @param array $fields
	 * @return array
	 */
	public function toArray(array $fields = [])
	{
		$array = [];
		if (sizeof($fields)) {
			foreach ($fields as $property => $field) {
				if (property_exists($this, $property)) {
					$array[$property] = $this->{$this->getGetterName($property)}($this->getSubsetFields($fields, $property));
				}
			}
		} else {
			foreach ($this as $property => $value) {
				$array[$property] = $this->{$this->getGetterName($property)}();
			}
		}

		return $array;
	}

	/**
	 * @param array $fields
	 * @param string $key
	 * @return array
	 */
	private function getSubsetFields(array $fields, string $key): array
	{
		if (isset($fields[$key])) {
			if (is_array($fields[$key])) {
				return $fields[$key];
			} else {
				return [];
			}
		} else {
			return [];
		}
	}

	/**
	 * @param string $property
	 * @return string
	 */
	protected function getGetterName(string $property): string
	{
		return 'get' . ucfirst(Strings::toCamelCase($property));
	}
}