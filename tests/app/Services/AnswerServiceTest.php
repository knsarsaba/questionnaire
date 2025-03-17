<?php

namespace Tests\App\Services;

use App\Models\AnswerModel;
use App\Services\AnswerService;
use PHPUnit\Framework\TestCase;

class AnswerServiceTest extends TestCase
{
    private $answerModel;
    private $answerService;

    protected function setUp(): void
    {
        $this->answerModel = $this->getMockBuilder(AnswerModel::class)
            ->addMethods(['where'])
            ->onlyMethods(['findAll', 'insert', 'delete'])
            ->getMock();

        $this->answerService = new AnswerService($this->answerModel);
    }

    public function testGetAnswersByQuestionId()
    {
        $questionId = 1;
        $expectedAnswers = [
            ['id' => 1, 'question_id' => $questionId, 'label' => 'Answer 1'],
            ['id' => 2, 'question_id' => $questionId, 'label' => 'Answer 2'],
        ];

        $this->answerModel->expects($this->once())
            ->method('where')
            ->with('question_id', $questionId)
            ->willReturnSelf();

        $this->answerModel->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedAnswers);

        $result = $this->answerService->getAnswersByQuestionId($questionId);

        $this->assertEquals($expectedAnswers, $result);
    }

    public function testAddAnswer()
    {
        $questionId = 1;
        $label = 'New Answer';

        $this->answerModel->expects($this->once())
            ->method('insert')
            ->with(['question_id' => $questionId, 'label' => $label])
            ->willReturn(3);

        $result = $this->answerService->addAnswer($questionId, $label);

        $this->assertEquals(3, $result);
    }

    public function testDeleteAnswer()
    {
        $answerId = 2;

        $this->answerModel->expects($this->once())
            ->method('delete')
            ->with($answerId)
            ->willReturn(true);

        $result = $this->answerService->deleteAnswer($answerId);

        $this->assertTrue($result);
    }
}
