<?php

namespace App\GraphQL\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\CustomScalarType;
use GraphQL\Utils\Utils;
use Respect\Validation\Validator;

class FloatType extends CustomScalarType
{
    public $name = 'float';

    /**
     * Serializes an internal value to include in a response.
     *
     * @param string $value
     * @return string
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     * @throws Error
     */
    public function parseValue($value)
    {
        if (!Validator::floatType()->validate((float) $value)) {
            throw new Error("Cannot represent following value as float: " . Utils::printSafeJson($value));
        }
        return $value;
    }
}
