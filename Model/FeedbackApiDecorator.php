<?php

namespace Babylon\WatsonBundle\Model;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Babylon\WatsonBundle\Exception\WatsonModelValidationException;
use Babylon\WatsonBundle\Exception\WatsonInvalidArgumentException;

/**
 * Decorated the feedback model for working with watson api.
 */
class FeedbackApiDecorator implements FeedbackInterface
{
    /**
     * Element name for watson request to feedback api method.
     */
    const QUESTION_ID_ELEMENT_NAME = 'questionId';

    /**
     * Element name for watson request to feedback api method.
     */
    const QUESTION_TEXT_ELEMENT_NAME = 'questionText';

    /**
     * Element name for watson request to feedback api method.
     */
    const ANSWER_ID_ELEMENT_NAME = 'answerId';

    /**
     * Element name for watson request to feedback api method.
     */
    const ANSWER_TEXT_ELEMENT_NAME = 'answerText';

    /**
     * Element name for watson request  to feedback api method.
     */
    const FEEDBACK_ELEMENT_NAME = 'feedback';

    /**
     * @var Feedback
     */
    private $feedback;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Initialization of the required data.
     *
     * @param Feedback $feedback
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Prepared all required data to watson feedback api method.
     *
     * @return array
     */
    public function getData()
    {
        $this->isValid($this->feedback);

        return [
            self::QUESTION_ID_ELEMENT_NAME => $this->feedback->getAnswer()->getQuestionId(),
            self::QUESTION_TEXT_ELEMENT_NAME => $this->feedback->getAnswer()->getQuestionText(),
            self::ANSWER_ID_ELEMENT_NAME => $this->feedback->getAnswer()->getId(),
            self::ANSWER_TEXT_ELEMENT_NAME => $this->feedback->getAnswer()->getText(),
            self::FEEDBACK_ELEMENT_NAME => $this->feedback->getVote()
        ];
    }

    /**
     * Validate feedback object.
     *
     * @param Feedback $feedback
     *
     * @throws WatsonModelValidationException
     */
    public function isValid($feedback)
    {
        $errors = $this->getValidator()->validate($feedback);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }
            var_dump($errorsArray);
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