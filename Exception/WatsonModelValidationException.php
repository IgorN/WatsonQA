<?php

namespace Babylon\WatsonBundle\Exception;

/**
 * Used for models validation errors.
 */
class WatsonModelValidationException extends WatsonException
{
    protected $errors = [];

    /**
     * Get exception object with predefined message and code.
     *
     * @param array $errors
     *
     * @return WatsonModelValidationException
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;

        $this->message = 'Model is invalid!';
        $this->code = 400;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }


}