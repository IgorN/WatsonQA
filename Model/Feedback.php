<?php

namespace Babylon\WatsonBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Babylon\WatsonBundle\Exception\WatsonIncorrectFeedbackVoteException;

/**
 * Model reflects the feedback domain in this bundle.
 */
class Feedback implements FeedbackInterface
{
    /**
     * An answers was irrelevant.
     */
    const VOTE_IRRELEVANT = "-1";

    /**
     * Neutral feedback.
     */
    const VOTE_NEUTRAL = "0";

    /**
     * Answer was relevant.
     */
    const VOTE_RELEVANT = "1";

    /**
     * An answer was partially relevant.
     */
    const VOTE_PARTIALLY_RELEVANT = "9";

    /**
     * List of available voting options
     *
     * @var array
     */
    public static $feedBackVoteValues = [
        'irrelevant' => self::VOTE_IRRELEVANT,
        'neutral' => self::VOTE_NEUTRAL,
        'relevant' => self::VOTE_RELEVANT,
        'partially_relevant' => self::VOTE_PARTIALLY_RELEVANT,
    ];

    /**
     * @Assert\Valid
     *
     * @var Answer
     */
    private $answer;

    /**
     * @Assert\NotBlank
     *
     * Selected vote.
     *
     * @var string
     */
    private $vote;

    /**
     * Initialization of the required data.
     *
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param string $vote
     *
     * @throws WatsonIncorrectFeedbackVoteException
     */
    public function setVote($vote)
    {
        if (!in_array($vote, self::$feedBackVoteValues)) {
            throw new WatsonIncorrectFeedbackVoteException();
        }

        $this->vote = $vote;
    }

    /**
     * @return Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Return empty data.
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }
}