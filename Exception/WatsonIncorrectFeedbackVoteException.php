<?php

namespace Babylon\WatsonBundle\Exception;

/**
 * Used for incorrect feedback vote value.
 */
class WatsonIncorrectFeedbackVoteException extends WatsonException
{
    /**
     * Get exception object with predefined message and code.
     *
     * @return WatsonIncorrectFeedbackVoteException
     */
    public function __construct()
    {
        return parent::__construct(
            'Incorrect vote value. Must be only -1 or 0 or 1 or 9',
            400
        );
    }
}