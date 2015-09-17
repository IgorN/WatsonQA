<?php

namespace Babylon\WatsonBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Babylon\WatsonBundle\Form\QuestionType;
use Babylon\WatsonBundle\Model\Question;
use Babylon\WatsonBundle\Model\QuestionApiDecorator;
use Babylon\WatsonBundle\Model\Answer;
use Babylon\WatsonBundle\Model\Feedback;
use Babylon\WatsonBundle\Model\FeedbackApiDecorator;

/**
 * Used for demo.
 */
class DemoController extends Controller
{
    /**
     * Render page with question form and answer result.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $question = new Question();

        $form = $this->createForm(new QuestionType(), $question);

        $form->handleRequest($request);

        $answerCollection = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $questionApiDecorator = new QuestionApiDecorator($question);
            $questionApiDecorator->setValidator($this->get('validator'));

            $watsonQuestion = $this->get('babylon_watson.service.watson_question');
            $answerCollection = $watsonQuestion->ask($questionApiDecorator);
        }

        return $this->render(
            'BabylonWatsonBundle:Demo:index.html.twig',
            [
                'form' => $form->createView(),
                'answers' => $answerCollection,
                'voteList' => Feedback::$feedBackVoteValues
            ]
        );
    }

    /**
     * Used for debug watson data.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function debugAction(Request $request)
    {
        $question = new Question();
        $question->setValue($request->get('value'));

        $watsonQuestion = $this->get('babylon_watson.service.watson_question');
        $watsonQuestion->ask((new QuestionApiDecorator($question)));

        return new JsonResponse($watsonQuestion->getLastResponse());
    }

    /**
     * Send feedback to watson.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Babylon\WatsonBundle\Exception\WatsonIncorrectFeedbackVoteException
     */
    public function feedbackAction(Request $request)
    {
        $answerData = (object) $request->request->get('answer');

        $answer = new Answer();
        $answer->setId($answerData->id)
            ->setQuestionId($answerData->questionId)
            ->setText($answerData->text)
            ->setQuestionText($answerData->questionText);

        $feedback = new Feedback($answer);
        $feedback->setVote($answerData->vote);

        $feedbackApiDecorator = new FeedbackApiDecorator($feedback);
        $feedbackApiDecorator->setValidator($this->get('validator'));

        $watsonQuestion = $this->get('babylon_watson.service.watson_question');
        $status = $watsonQuestion->feedback($feedbackApiDecorator);

        $msg = $watsonQuestion->getLastResponse()->result;

        return new JsonResponse(['status' => $status, 'msg' => $msg], 200);
    }
}
