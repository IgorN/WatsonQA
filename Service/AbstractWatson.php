<?php

namespace Babylon\WatsonBundle\Service;

use Babylon\WatsonBundle\Model\AbstractWatson as WatsonModel;

/**
 * Base class for all watson service classes.
 */
abstract class AbstractWatson
{
    /**
     * @var WatsonConnector
     */
    protected $watsonConnector;

    /**
     * @var WatsonModel
     */
    protected $watsonModel;

    /**
     * Initialization of the required data.
     *
     * @param WatsonConnector $watsonConnector
     * @param WatsonModel     $watsonModel
     */
    public function __construct(
        WatsonConnector $watsonConnector,
        WatsonModel $watsonModel
    )
    {
        $this->watsonConnector = $watsonConnector;
        $this->watsonModel = $watsonModel;

        $this->initAuth();
    }

    /**
     * Initialize auth settings
     */
    abstract public function initAuth();

    /**
     * Get last response from watson.
     *
     * @return array
     */
    public function getLastResponse()
    {
        return json_decode($this->watsonConnector->getResponse());
    }
}