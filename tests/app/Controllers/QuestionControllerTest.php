<?php

namespace Tests\App\Controllers;

use App\Services\Contracts\QuestionServiceInterface;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;

class QuestionControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $mockQuestionService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockQuestionService = $this->createMock(QuestionServiceInterface::class);
        Services::injectMock('questionService', $this->mockQuestionService);
    }

    public function testStore()
    {
        $this->mockQuestionService
            ->expects($this->once())
            ->method('addQuestion')
            ->with(1, 'Sample Question');

        $result = $this->post('questions/store', [
            'questionnaire_id' => 1,
            'name' => 'Sample Question',
        ]);

        $result->assertRedirectTo('questionnaires/1');
    }

    public function testDelete()
    {
        $this->mockQuestionService
            ->expects($this->once())
            ->method('deleteQuestion')
            ->with(3);

        $result = $this->post('questions/delete/3');

        $result->assertRedirect();
    }
}
