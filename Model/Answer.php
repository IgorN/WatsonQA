<?php

namespace Babylon\WatsonBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Model reflects the answer from Watson.
 */
class Answer
{
    /**
     * @Assert\NotBlank
     *
     * An integer that uniquely identifies an answer in the context of the question.
     *
     * @var string
     */
    private $id;

    /**
     * @Assert\NotBlank
     *
     * A string that contains an answer to the question in the form of text.
     *
     * @var string
     */
    private $text;

    /**
     * A decimal percentage that represents the confidence that Watson has in this answer.
     * Higher values represent higher confidences.
     *
     * @var string
     */
    private $confidence;

    /**
     * @Assert\NotBlank
     *
     * An integer that is assigned by the service to identify this question and its answers.
     *
     * @var string
     */
    private $questionId;

    /**
     * @Assert\NotBlank
     *
     * A string that contains an question in the form of text.
     *
     * @var string
     */
    private $questionText;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Helper method for convert raw confidence to percent.
     *
     * @return float
     */
    public function getConfidencePercent()
    {
        return round($this->confidence * 100);
    }

    /**
     * @param string $confidence
     *
     * @return $this
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * @param string $questionId
     *
     * @return $this
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionText()
    {
        return $this->questionText;
    }

    /**
     * @param string $questionText
     *
     * @return $this
     */
    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;

        return $this;
    }
}