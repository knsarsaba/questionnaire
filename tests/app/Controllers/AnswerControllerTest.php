<?php

namespace Tests\App\Controllers;

use App\Services\Contracts\AnswerServiceInterface;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;

class AnswerControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $mockAnswerService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockAnswerService = $this->createMock(AnswerServiceInterface::class);
        Services::injectMock('answerService', $this->mockAnswerService);
    }

    public function testStore()
    {
        $this->mockAnswerService
            ->expects($this->once())
            ->method('addAnswer')
            ->with(1, 'Sample Answer');

        $result = $this->post('answers/store', [
            'questionnaire_id' => 1,
            'question_id' => 1,
            'label' => 'Sample Answer',
        ]);

        $result->assertRedirectTo('questionnaires/1');
    }

    public function testDelete()
    {
        $this->mockAnswerService
            ->expects($this->once())
            ->method('deleteAnswer')
            ->with(5);

        $result = $this->post('answers/delete/5', [
            'questionnaire_id' => 2,
        ]);

        $result->assertRedirectTo('questionnaires/2');
    }
}
