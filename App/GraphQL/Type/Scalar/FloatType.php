<?php

namespace App\GraphQL\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use Respect\Validation\Validator;

class FloatType extends ScalarType
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

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * E.g.
     * {
     *   user(email: "user@example.com")
     * }
     *
     * @param \GraphQL\Language\AST\Node $valueNode
     * @return string
     * @throws Error
     */
    public function parseLiteral($valueNode)
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }
        if (Validator::floatType()->validate((float) $valueNode->value)) {
            throw new Error("Not a valid float", [$valueNode]);
        }
        return $valueNode->value;
    }
}