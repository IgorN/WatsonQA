<?php

namespace Babylon\WatsonBundle\Model;

/**
 * Base class for all watson model classes.
 */
abstract class AbstractWatson
{
    /**
     * Service url from your watson app.
     *
     * @var string
     */
    protected $url;

    /**
     * username from your watson app.
     *
     * @var string
     */
    protected $username;

    /**
     * password from your watson app.
     *
     * @var string
     */
    protected $password;

    /**
     * Initialization and configure of the required data.
     *
     * @param string $url
     * @param string $username
     * @param string $password
     */
    public function __construct($url, $username, $password)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Prepare and get Base Auth string.
     *
     * @return string
     */
    public function getAuthBase64String()
    {
        return base64_encode($this->getUsername() . ':' . $this->getPassword());
    }
}