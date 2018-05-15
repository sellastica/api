<?php
namespace Sellastica\Api\Model;

class ResponseStatus
{
	/** @var array */
	private static $statuses = [
		200 => 'OK',
		201 => 'Created',
		204 => 'Removed',
		400 => 'Bad request',
		401 => 'Unauthorized request',
		404 => 'Not found',
		405 => 'Method not allowed',
		422 => 'Unprocessable request',
		429 => 'Too many requests',
		500 => 'Server error',
	];

	/** @var int */
	private $code;
	/** @var string */
	private $message;
	/** @var string */
	private $descriptions = [];


	/**
	 * @param int $code
	 * @param string $message
	 * @param string $description
	 */
	public function __construct(int $code, string $message, string $description = null)
	{
		$this->message = $message;
		$this->code = $code;
		if (isset($description)) {
			$this->addDescription($description);
		}
	}

	/**
	 * @return int
	 */
	public function getCode(): int
	{
		return $this->code;
	}

	/**
	 * @return bool
	 */
	public function isOk(): bool
	{
		return $this->code < 300;
	}

	/**
	 * @param string $description
	 */
	public function addDescription(string $description)
	{
		$this->descriptions[] = $description;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		$array = [
			'code' => $this->code,
			'message' => $this->message,
		];
		if (sizeof($this->descriptions)) {
			$array['description'] = $this->descriptions;
		}

		return $array;
	}

	/**
	 * @param int $code
	 * @param string|null $description
	 * @return ResponseStatus
	 * @throws \InvalidArgumentException
	 */
	public static function from(int $code, string $description = null): self
	{
		if (!isset(self::$statuses[$code])) {
			throw new \InvalidArgumentException("Uknown status $code");
		}

		return new self(
			$code, self::$statuses[$code], $description
		);
	}
}