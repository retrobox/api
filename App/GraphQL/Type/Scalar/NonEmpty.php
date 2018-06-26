<?php

namespace App\GraphQL\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\CustomScalarType;
use GraphQL\Utils\Utils;
use Illuminate\Support\Carbon;

class NonEmpty extends CustomScalarType
{

	public $name = 'NonEmpty';

	/**
	 * @param Carbon $value
	 * @return mixed
	 */
	public function serialize($value)
	{
		return $value;
	}

	public function parseValue($value)
	{
		if (empty($value) || $value = "") {
			throw new Error("Cannot represent following value as Non Empty: " . Utils::printSafeJson($value));
		} else {
			return $value;
		}
	}

	public function parseLiteral(/* GraphQL\Language\AST\ValueNode */
		$valueNode)
	{
		if (empty($valueNode->value) || $valueNode->value === '') {
			throw new Error("Cannot represent following value as Non Empty: " . Utils::printSafeJson($valueNode->value));
		} else {
			return $valueNode;
		}
	}
}