<?php

namespace Babylon\WatsonBundle\Handler;

use Babylon\WatsonBundle\Model\Answer;
use Babylon\WatsonBundle\Model\Collection;

/**
 * Prepare the raw response data from watson.
 */
class QuestionResponseHandler
{
    /**
     * Transform the raw data to internal collection of the answer objects.
     *
     * @param array $data
     *
     * @return Collection
     */
    public function getAnswerCollection($data)
    {
        $answerCollection = new Collection();
        $rootElement = current($data)->question;
        foreach ($rootElement->answers as $item) {
            $answer = new Answer();
            $answer
                ->setId($item->id)
                ->setText($item->text)
                ->setConfidence($item->confidence)
                ->setQuestionId($rootElement->id)
                ->setQuestionText($rootElement->questionText);
            $answerCollection->add($answer);
        }

        return $answerCollection;
    }
}