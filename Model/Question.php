<?php

namespace Babylon\WatsonBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Model reflects the question domain in this bundle.
 */
class Question implements QuestionInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = "5",
     *      max = "180"
     * )
     *
     * Question text.
     *
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}