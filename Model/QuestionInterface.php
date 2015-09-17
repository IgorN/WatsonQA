<?php

namespace Babylon\WatsonBundle\Model;

/**
 * Used for DI and decorator pattern.
 */
interface QuestionInterface
{
    /**
     * @return string
     */
    public function getValue();
}