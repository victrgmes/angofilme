<?php

namespace PayPal\Validation;

/**
 * Class ArgumentValidator
 *
 * @package PayPal\Validation
 */
class ArgumentValidator
{

    /**
     * Helper method for validating an argument that will be used by this API in any requests.
     *
     * @param $argument     mixed The object to be validated
     * @param $argumentName string|null The name of the argument.
     *                      This will be placed in the exception message for easy reference
     * @return bool
     */
    public static function validate($argument, $argumentName = null)
    {
        if ($argument === null) {
            // Erro se o objeto for nulo
            throw new \InvalidArgumentException("$argumentName não pode ser nulo");
        } elseif (gettype($argument) == 'string' && trim($argument) == '') {
            // Erro se a cadeia de caracteres estiver vazia
            throw new \InvalidArgumentException("$argumentName string não pode estar vazia");
        }
        return true;
    }
}
