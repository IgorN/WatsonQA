<?php

namespace Babylon\WatsonBundle\Model;

/**
 * Model reflects the watson settings for question and answer service.
 */
class WatsonQuestion extends AbstractWatson
{
    /**
     * API version.
     */
    const API_VERSION = 'v1';

    /**
     * Name of the ping api method.
     */
    const API_PING_METHOD = 'ping';

    /**
     * Name of the question api method. For healthcare dataset.
     */
    const API_QUESTION_METHOD = 'question/healthcare';

    /**
     * Name of the feedback api method.
     */
    const API_FEEDBACK_METHOD = 'feedback';

    /**
     * Build and return url to ping api method.
     *
     * @return string
     */
    public function getPingUrl()
    {
        return $this->getUrl()
            . '/'
            . self::API_VERSION
            . '/'
            . self::API_PING_METHOD;
    }

    /**
     * Build and return url to question api method.
     *
     * @return string
     */
    public function getQuestionUrl()
    {
        return $this->getUrl()
            . '/'
            . self::API_VERSION
            . '/'
            . self::API_QUESTION_METHOD;
    }

    /**
     * Build and return url to feedback api method.
     *
     * @return string
     */
    public function getFeedbackUrl()
    {
        return $this->getUrl()
        . '/'
        . self::API_VERSION
        . '/'
        . self::API_FEEDBACK_METHOD;
    }
}