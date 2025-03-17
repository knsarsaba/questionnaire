<?php

namespace Tests\App\Services;

use App\Models\QuestionnaireModel;
use App\Services\QuestionnaireService;
use PHPUnit\Framework\TestCase;

class QuestionnaireServiceTest extends TestCase
{
    private $questionnaireModel;
    private $questionnaireService;

    protected function setUp(): void
    {
        $this->questionnaireModel = $this->getMockBuilder(QuestionnaireModel::class)
            ->onlyMethods(['find', 'findAll', 'insert', 'update', 'delete'])
            ->getMock();

        $this->questionnaireService = new QuestionnaireService($this->questionnaireModel);
    }

    public function testGetQuestionnaireById()
    {
        $questionnaireId = 1;
        $expectedData = ['id' => $questionnaireId, 'name' => 'Customer Feedback'];

        $this->questionnaireModel->expects($this->once())
            ->method('find')
            ->with($questionnaireId)
            ->willReturn($expectedData);

        $result = $this->questionnaireService->getQuestionnaireById($questionnaireId);

        $this->assertEquals($expectedData, $result);
    }

    public function testGetAllQuestionnaires()
    {
        $expectedData = [
            ['id' => 1, 'name' => 'Customer Feedback'],
            ['id' => 2, 'name' => 'Product Survey'],
        ];

        $this->questionnaireModel->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedData);

        $result = $this->questionnaireService->getAllQuestionnaires();

        $this->assertEquals($expectedData, $result);
    }

    public function testCreateQuestionnaire()
    {
        $name = 'New Questionnaire';

        $this->questionnaireModel->expects($this->once())
            ->method('insert')
            ->with(['name' => $name])
            ->willReturn(3);

        $result = $this->questionnaireService->createQuestionnaire($name);

        $this->assertEquals(3, $result);
    }

    public function testUpdateQuestionnaire()
    {
        $questionnaireId = 1;
        $updatedName = 'Updated Survey';

        $this->questionnaireModel->expects($this->once())
            ->method('update')
            ->with($questionnaireId, ['name' => $updatedName])
            ->willReturn(true);

        $result = $this->questionnaireService->updateQuestionnaire($questionnaireId, $updatedName);

        $this->assertTrue($result);
    }

    public function testDeleteQuestionnaire()
    {
        $questionnaireId = 1;

        $this->questionnaireModel->expects($this->once())
            ->method('delete')
            ->with($questionnaireId)
            ->willReturn(true);

        $result = $this->questionnaireService->deleteQuestionnaire($questionnaireId);

        $this->assertTrue($result);
    }
}
