<?php

namespace Babylon\WatsonBundle\Service;

use Babylon\WatsonBundle\Handler\QuestionResponseHandler;
use Babylon\WatsonBundle\Model\FeedbackInterface;
use Babylon\WatsonBundle\Model\QuestionInterface;
use Babylon\WatsonBundle\Exception\WatsonServiceUnavailableException;
use Babylon\WatsonBundle\Exception\WatsonServiceException;

/**
 * Wrapper for watson question-and-answer api.
 */
class WatsonQuestion extends AbstractWatson
{
    /**
     * @var QuestionResponseHandler
     */
    private $questionResponseHandler;

    /**
     * {@inheritdoc}
     */
    public function initAuth()
    {
        $this->watsonConnector->setAuthorizationBasicHeader(
            $this->watsonModel->getAuthBase64String()
        );
    }

    /**
     * Call watson question api method.
     *
     * @param QuestionInterface $question
     *
     * @return \Babylon\WatsonBundle\Model\Collection
     *
     * @throws WatsonServiceUnavailableException|WatsonServiceException
     */
    public function ask(QuestionInterface $question)
    {
        if (!$this->ping()) {
            throw new WatsonServiceUnavailableException();
        }

        $this->watsonConnector->setUri($this->watsonModel->getQuestionUrl());

        $questionJson = json_encode($question->getValue());

        $arrayResult = json_decode($this->watsonConnector->call($questionJson));

        if (! $this->watsonConnector->isOk()) {
            throw new WatsonServiceException(
                $arrayResult->user_message,
                $arrayResult->status
            );
        }

        return $this->getQuestionResponseHandler()
            ->getAnswerCollection($arrayResult);
    }

    /**
     * Call watson feedback api method.
     *
     * @param FeedbackInterface $feedback
     *
     * @return bool
     *
     * @throws WatsonServiceUnavailableException
     */
    public function feedback(FeedbackInterface $feedback)
    {
        if (!$this->ping()) {
            throw new WatsonServiceUnavailableException();
        }

        $this->watsonConnector->setUri($this->watsonModel->getFeedbackUrl());

        $feedbackJson = json_encode($feedback->getData());

        $this->watsonConnector->call($feedbackJson, WatsonConnector::HTTP_METHOD_PUT);

        return $this->watsonConnector->isOk();
    }

    /**
     * Pings the services to verify that it is available.
     *
     * @return bool
     */
    public function ping()
    {
        $this->watsonConnector->setUri($this->watsonModel->getPingUrl());

        $this->watsonConnector->call('', WatsonConnector::HTTP_METHOD_GET);

        return $this->watsonConnector->isOk();
    }

    /**
     * Handler for question answer response.
     *
     * @return QuestionResponseHandler
     */
    public function getQuestionResponseHandler()
    {
        return $this->questionResponseHandler;
    }

    /**
     * Set handler. Used fo DI.
     *
     * @param QuestionResponseHandler $handler
     */
    public function setQuestionResponseHandler(
        QuestionResponseHandler $handler
    )
    {
        $this->questionResponseHandler = $handler;
    }
}