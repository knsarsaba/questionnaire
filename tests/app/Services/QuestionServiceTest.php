<?php

namespace Tests\App\Services;

use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Services\QuestionService;
use PHPUnit\Framework\TestCase;

class QuestionServiceTest extends TestCase
{
    private $questionModel;
    private $answerModel;
    private $questionService;

    protected function setUp(): void
    {
        $this->questionModel = $this->getMockBuilder(QuestionModel::class)
            ->onlyMethods(['find', 'findAll', 'insert', 'delete'])
            ->addMethods(['where'])
            ->getMock();

        $this->answerModel = $this->getMockBuilder(AnswerModel::class)
            ->onlyMethods(['findAll'])
            ->addMethods(['where'])
            ->getMock();

        $this->questionService = new QuestionService($this->questionModel, $this->answerModel);
    }

    public function testGetQuestionById()
    {
        $questionId = 1;
        $expectedQuestion = ['id' => $questionId, 'name' => 'Sample Question'];

        $this->questionModel->expects($this->once())
            ->method('find')
            ->with($questionId)
            ->willReturn($expectedQuestion);

        $result = $this->questionService->getQuestionById($questionId);

        $this->assertEquals($expectedQuestion, $result);
    }

    public function testGetQuestionsByQuestionnaireId()
    {
        $questionnaireId = 1;
        $questions = [
            ['id' => 1, 'questionnaire_id' => $questionnaireId, 'name' => 'Question 1'],
            ['id' => 2, 'questionnaire_id' => $questionnaireId, 'name' => 'Question 2'],
        ];
        $answers = [
            ['id' => 1, 'question_id' => 1, 'label' => 'Answer 1'],
            ['id' => 2, 'question_id' => 2, 'label' => 'Answer 2'],
        ];

        $this->questionModel->expects($this->once())
            ->method('where')
            ->with('questionnaire_id', $questionnaireId)
            ->willReturnSelf();

        $this->questionModel->expects($this->once())
            ->method('findAll')
            ->willReturn($questions);

        $this->answerModel->expects($this->exactly(2))
            ->method('where')
            ->withConsecutive(
                ['question_id', 1],
                ['question_id', 2]
            )
            ->willReturnSelf();

        $this->answerModel->expects($this->exactly(2))
            ->method('findAll')
            ->willReturnOnConsecutiveCalls([$answers[0]], [$answers[1]]);

        $result = $this->questionService->getQuestionsByQuestionnaireId($questionnaireId);

        $expectedResult = [
            ['id' => 1, 'questionnaire_id' => $questionnaireId, 'name' => 'Question 1', 'answers' => [$answers[0]]],
            ['id' => 2, 'questionnaire_id' => $questionnaireId, 'name' => 'Question 2', 'answers' => [$answers[1]]],
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testAddQuestion()
    {
        $questionnaireId = 1;
        $questionName = 'New Question';

        $this->questionModel->expects($this->once())
            ->method('insert')
            ->with(['questionnaire_id' => $questionnaireId, 'name' => $questionName])
            ->willReturn(3);

        $result = $this->questionService->addQuestion($questionnaireId, $questionName);

        $this->assertEquals(3, $result);
    }

    public function testDeleteQuestion()
    {
        $questionId = 2;

        $this->questionModel->expects($this->once())
            ->method('delete')
            ->with($questionId)
            ->willReturn(true);

        $result = $this->questionService->deleteQuestion($questionId);

        $this->assertTrue($result);
    }
}
