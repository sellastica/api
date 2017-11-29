<?php
namespace Sellastica\Api\Model;

use Nette;

class EndpointFilter
{
	const INT = 'int',
		FLOAT = 'float',
		STRING = 'string';

	/** @var string */
	private $field;
	/** @var string|int|float */
	private $value;
	/** @var string */
	private $type;
	/** @var string */
	private $comparator;

	/**
	 * @param string $field
	 * @param float|int|string $value
	 * @param string $type
	 */
	public function __construct(string $field, $value, string $type)
	{
		$this->assertType($type);
		$this->field = $field;
		$this->value = $value;
		$this->type = $type;

		if (Nette\Utils\Strings::endsWith($field, '_min')) {
			$this->comparator = '>=';
		} elseif (Nette\Utils\Strings::endsWith($field, '_max')) {
			$this->comparator = '<=';
		} else {
			$this->comparator = '=';
		}
	}

	/**
	 * @return string
	 */
	public function getField(): string
	{
		return $this->field;
	}

	/**
	 * @return float|int|string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getComparator(): string
	{
		return $this->comparator;
	}

	/**
	 * @param string $type
	 */
	private function assertType(string $type)
	{
		if (!in_array($type, [self::INT, self::FLOAT, self::STRING])) {
			throw new \InvalidArgumentException(sprintf('Invalid type "%s"', $type));
		}
	}
}