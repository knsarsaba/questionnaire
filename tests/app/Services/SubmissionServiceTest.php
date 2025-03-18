<?php

namespace Tests\App\Services;

use App\Models\SubmissionAnswerModel;
use App\Models\SubmissionModel;
use App\Services\Contracts\QuestionnaireServiceInterface;
use App\Services\Contracts\QuestionServiceInterface;
use App\Services\SubmissionService;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\Files\UploadedFile;
use PHPUnit\Framework\TestCase;

class SubmissionServiceTest extends TestCase
{
    private $submissionModel;
    private $submissionAnswerModel;
    private $questionService;
    private $questionnaireService;
    private $submissionService;

    protected function setUp(): void
    {
        $this->submissionModel = $this->getMockBuilder(SubmissionModel::class)
            ->onlyMethods(['find', 'findAll', 'insert'])
            ->addMethods(['where', 'insertID'])
            ->getMock();

        $this->submissionAnswerModel = $this->getMockBuilder(SubmissionAnswerModel::class)
            ->onlyMethods(['findAll', 'insertBatch', 'insert', 'first'])
            ->addMethods(['join', 'where', 'select'])
            ->getMock();

        $this->submissionAnswerModel->method('join')->willReturnSelf();
        $this->submissionAnswerModel->method('where')->willReturnSelf();
        $this->submissionAnswerModel->method('select')->willReturnSelf();

        $this->questionService = $this->createMock(QuestionServiceInterface::class);
        $this->questionnaireService = $this->createMock(QuestionnaireServiceInterface::class);

        $this->submissionService = new SubmissionService(
            $this->submissionModel,
            $this->submissionAnswerModel,
            $this->questionService,
            $this->questionnaireService
        );
    }

    public function testGetSubmissionById()
    {
        $submissionId = 1;
        $expectedSubmission = ['id' => $submissionId, 'questionnaire_id' => 2];

        $this->submissionModel->expects($this->once())
            ->method('find')
            ->with($submissionId)
            ->willReturn($expectedSubmission);

        $result = $this->submissionService->getSubmissionById($submissionId);

        $this->assertEquals($expectedSubmission, $result);
    }

    public function testGetSubmissionsByQuestionnaireId()
    {
        $questionnaireId = 2;
        $submissions = [
            ['id' => 1, 'questionnaire_id' => $questionnaireId],
            ['id' => 2, 'questionnaire_id' => $questionnaireId],
        ];
        $answers = [
            ['submission_id' => 1, 'question_id' => 10, 'answer_id' => 20, 'question_name' => 'Q1', 'answer_text' => 'A1'],
            ['submission_id' => 2, 'question_id' => 11, 'answer_id' => 21, 'question_name' => 'Q2', 'answer_text' => 'A2'],
        ];

        $this->submissionModel->expects($this->once())
            ->method('where')
            ->with('questionnaire_id', $questionnaireId)
            ->willReturnSelf();

        $this->submissionModel->expects($this->once())
            ->method('findAll')
            ->willReturn($submissions);

        $this->submissionAnswerModel->expects($this->exactly(2))
            ->method('where')
            ->willReturnSelf();

        $this->submissionAnswerModel->expects($this->exactly(2))
            ->method('findAll')
            ->willReturnOnConsecutiveCalls([$answers[0]], [$answers[1]]);

        $result = $this->submissionService->getSubmissionsByQuestionnaireId($questionnaireId);

        $expectedResult = [
            ['id' => 1, 'questionnaire_id' => $questionnaireId, 'answers' => [$answers[0]]],
            ['id' => 2, 'questionnaire_id' => $questionnaireId, 'answers' => [$answers[1]]],
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testSubmitQuestionnaire()
    {
        $questionnaireId = 3;
        $answers = [10 => 20, 11 => 21];

        $this->submissionModel->expects($this->once())
            ->method('insert')
            ->with(['questionnaire_id' => $questionnaireId]);

        $this->submissionModel->expects($this->once())
            ->method('insertID')
            ->willReturn(100);

        $this->submissionAnswerModel->expects($this->once())
            ->method('insertBatch')
            ->with([
                ['submission_id' => 100, 'question_id' => 10, 'answer_id' => 20],
                ['submission_id' => 100, 'question_id' => 11, 'answer_id' => 21],
            ]);

        $result = $this->submissionService->submitQuestionnaire($questionnaireId, $answers);

        $this->assertEquals(100, $result);
    }

    public function testExportSubmissionsToCSV()
    {
        $questionnaireId = 5;
        $submissions = [
            ['id' => 1, 'answers' => [['question_id' => 10, 'question_name' => 'Q1', 'answer_id' => 20, 'answer_text' => 'A1']]],
        ];

        $this->submissionModel->expects($this->once())
            ->method('where')
            ->willReturnSelf();

        $this->submissionModel->expects($this->once())
            ->method('findAll')
            ->willReturn($submissions);

        $this->submissionAnswerModel->expects($this->once())
            ->method('findAll')
            ->willReturn($submissions[0]['answers']);

        $result = $this->submissionService->exportSubmissionsToCSV($questionnaireId);

        $this->assertStringContainsString('Q1', $result->getBody());
        $this->assertStringContainsString('A1', $result->getBody());
    }

    public function testImportSubmissionsFromCSV()
    {
        $fileMock = $this->createMock(UploadedFile::class);

        $csvContent = "Submission ID,Question ID,Question Name,Answer ID,Answer Text\n1,10,Q1,20,A1\n";
        $tempFile = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($tempFile, $csvContent);

        $fileMock->method('getTempName')->willReturn($tempFile);

        $this->questionService->expects($this->once())
            ->method('getQuestionById')
            ->with(10)
            ->willReturn(['id' => 10, 'questionnaire_id' => 5]);

        $this->questionnaireService->expects($this->once())
            ->method('getQuestionnaireById')
            ->with(5)
            ->willReturn(['id' => 5]);

        $this->submissionModel->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->submissionModel->expects($this->once())
            ->method('insert')
            ->willReturn(100);

        $this->submissionAnswerModel->expects($this->once())
            ->method('insert');

        $this->submissionAnswerModel->expects($this->once())
            ->method('first')
            ->willReturn(null);

        $result = $this->submissionService->importSubmissionsFromCSV($fileMock);

        $this->assertEquals(['status' => 'success', 'message' => 'Submissions imported successfully.'], $result);
    }
}
