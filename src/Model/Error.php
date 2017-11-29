<?php
namespace Sellastica\Api\Model;

class Error
{
	/** @var int */
	private $code;
	/** @var string */
	private $message;
	/** @var string */
	private $field;
	/** @var array */
	private $errors = [];

	/**
	 * @param string $message
	 * @param int $code
	 * @param string $field
	 */
	public function __construct($message, $code, $field = null)
	{
		$this->message = $message;
		$this->code = $code;
		$this->field = $field;
	}

	/**
	 * @param string $message
	 * @param int $code
	 * @param string $field
	 */
	public function addError($message, $code, $field = null)
	{
		$this->errors[] = [
			'code' => $code,
			'message' => $message,
			'field' => $field,
		];
	}

	/**
	 * Returns structured error message
	 * @example [code, message, errors => [code, messsage], [code, messsage], ...]
	 * @return array
	 */
	public function toArray()
	{
		$array = [
			'code' => $this->code,
			'message' => $this->message,
		];
		if (isset($this->field)) {
			$array['field'] = $this->field;
		}

		if (sizeof($this->errors)) {
			$array['errors'] = $this->errors;
		}

		return $array;
	}
}