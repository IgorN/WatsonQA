<?php

namespace Babylon\WatsonBundle\Exception;

/**
 * Used for service unavailable.
 */
class WatsonServiceUnavailableException extends WatsonException
{
    /**
     * Get exception object with predefined message and code.
     *
     * @return WatsonServiceUnavailableException
     */
    public function __construct()
    {
        return parent::__construct(
            'Watson services unavailable',
            503
        );
    }
}