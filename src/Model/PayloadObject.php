<?php
namespace Sellastica\Api\Model;

abstract class PayloadObject
{
	/** @var IPayloadable */
	private $parent;


	/**
	 * @param IPayloadable $parent
	 */
	public function __construct(IPayloadable $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return IPayloadable
	 */
	protected function getParent()
	{
		return $this->parent;
	}

	/**
	 * @param IPayloadable $entity
	 * @param array $fields
	 * @param mixed $default
	 * @return array|mixed
	 */
	protected function toPayloadObject(
		IPayloadable $entity = null,
		array $fields = [],
		$default = null
	)
	{
		return $entity instanceof IPayloadable
			? $entity->toPayloadObject()->toArray($fields)
			: $default;
	}

	/**
	 * @return array
	 */
	abstract protected function getProperties(): array;

	/**
	 * @param string $property
	 * @return bool
	 */
	private function hasProperty(string $property): bool
	{
		return in_array($property, $this->getProperties());
	}

	/**
	 * All relation properties
	 * @return array
	 */
	abstract protected function getRelationProperties(): array;

	/**
	 * @param string $property
	 * @return bool
	 */
	private function isRelation(string $property): bool
	{
		return in_array($property, $this->getRelationProperties());
	}

	/**
	 * @param array $fields
	 * @param array $expand
	 * @return array
	 */
	public function toArray(array $fields = [], array $expand = []): array
	{
		$array = [];
		foreach ($this->getProperties() as $property) {
			//if fields filter is not empty and does not contain $property
			if (!empty($fields) && !array_key_exists($property, $fields)) {
				continue;
			}

			if ($this->isRelation($property)) {
				if (array_key_exists($property, $fields) && is_array($fields[$property])) {
					$subsetFields = $this->getSubsetFields($fields, $property);
				} elseif (in_array($property, $expand)) {
					//if property should be expanded
					$subsetFields = [];
				} else {
					$subsetFields = ['id' => 'id'];
				}
			}

			$array[$property] = $this->{$this->getGetterName($property)}($subsetFields ?? []);
		}

		return $array;
	}

	/**
	 * @param array $fields
	 * @param array $expand
	 * @return \stdClass
	 */
	public function toStdClass(array $fields = [], array $expand = []): \stdClass
	{
		return \Nette\Utils\Json::decode(
			\Nette\Utils\Json::encode($this->toArray($fields, $expand))
		);
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
				return array_merge(['id' => 'id'], $fields[$key]);
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
		return 'get' . ucfirst(\Sellastica\Utils\Strings::toCamelCase($property));
	}

	/**
	 * @return string
	 */
	abstract public static function getShortName();
}