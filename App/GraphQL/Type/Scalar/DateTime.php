<?php

namespace App\GraphQL\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\CustomScalarType;
use GraphQL\Utils\Utils;
use Illuminate\Support\Carbon;

class DateTime extends CustomScalarType
{

	public $name = 'datetime';

	/**
	 * @param Carbon $value
	 * @return mixed
	 */
	public function serialize($value)
	{
		return $value->toDateTimeString();
	}

	public function parseValue($value)
	{
		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
		$errors = \DateTime::getLastErrors();
		if ($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date == false) {
			throw new Error("Cannot represent following value as datetime: " . Utils::printSafeJson($value));
		} else {
			return $value;
		}
	}

}
