<?php
namespace Sellastica\Api\Exception;

use Nette;
use Sellastica\Api\Exception\ApiException;

class InvalidApiParameterException extends ApiException
{
	/**
	 * @param string $param
	 * @param string $requested
	 * @param int $code
	 * @param \Exception $previous
	 */
	public function __construct(
		string $param = null,
		string $requested = null,
		int $code = Nette\Http\IResponse::S400_BAD_REQUEST,
		\Exception $previous = null
	)
	{
		$message = 'Invalid request parameters';
		if (isset($param)) {
			$message .= ' (' . $param;
			if (isset($requested)) {
				$message .= ' should be ' . $requested;
			}

			$message .= ')';
		}

		parent::__construct($message, $code, $previous);
	}
}
