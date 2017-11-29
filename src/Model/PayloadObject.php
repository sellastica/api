<?php
namespace Sellastica\Api\Model;

use Sellastica\Api\Model\IPayloadable;

abstract class PayloadObject
{
	use \Nette\SmartObject;

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
	 * @param array $fields
	 * @return array
	 */
	abstract public function toArray(array $fields = []);

	/**
	 * @return string
	 */
	abstract public static function getShortName();
}