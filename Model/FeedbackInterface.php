<?php

namespace Babylon\WatsonBundle\Model;

/**
 * Used for DI decorator pattern.
 */
interface FeedbackInterface
{
    /**
     * @return array
     */
    public function getData();
}