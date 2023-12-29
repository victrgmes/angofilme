<?php

namespace PayPal\Validation;

/**
 * Class NumericValidator
 *
 * @package PayPal\Validation
 */
class NumericValidator
{

    /**
     * Helper method for validating an argument if it is numeric
     *
     * @param mixed     $argument
     * @param string|null $argumentName
     * @return bool
     */
    public static function validate($argument, $argumentName = null)
    {
        if (trim($argument) != null && !is_numeric($argument)) {
            throw new \InvalidArgumentException("$argumentName não é um valor numérico válido");
        }
        return true;
    }
}
