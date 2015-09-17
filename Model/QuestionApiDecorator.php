<?php

namespace Babylon\WatsonBundle\Model;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Babylon\WatsonBundle\Exception\WatsonModelValidationException;
use Babylon\WatsonBundle\Exception\WatsonInvalidArgumentException;

/**
 * Decorated the question model for working with watson api.
 */
class QuestionApiDecorator implements QuestionInterface
{
    /**
     * Element name for watson request to question api method.
     */
    const ROOT_ELEMENT_NAME = 'question';

    /**
     * Element name for watson request to question api method.
     */
    const QUESTION_TEXT_ELEMENT_NAME = 'questionText';

    /**
     * @var Question
     */
    private $question;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Initialization of the required data.
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Prepared all required data to watson question api method.
     *
     * @return array
     */
    public function getValue()
    {
        $this->isValid($this->question);

        return [
            self::ROOT_ELEMENT_NAME => [
                self::QUESTION_TEXT_ELEMENT_NAME => $this->question->getValue()
            ]
        ];
    }

    /**
     * Validate question object.
     *
     * @param Question $question
     *
     * @throws WatsonModelValidationException
     */
    public function isValid($question)
    {
        $errors = $this->getValidator()->validate($question);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new WatsonModelValidationException($errorsArray);
        }
    }

    /**
     * Get validator service.
     *
     * @return ValidatorInterface
     *
     * @throws WatsonInvalidArgumentException
     */
    public function getValidator()
    {
        if (! ($this->validator instanceof ValidatorInterface)) {
            throw new WatsonInvalidArgumentException('Validator is not initialized!');
        }

        return $this->validator;
    }

    /**
     * Set validator service.
     *
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
}