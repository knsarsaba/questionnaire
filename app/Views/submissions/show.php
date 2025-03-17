<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Submission #<?= esc($submission['id']) ?> - <?= esc($questionnaire['name']) ?></h2>
    <p><strong>Submitted At:</strong> <?= esc($submission['submitted_at']) ?></p>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Question</th>
                <th>Answer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($answers as $answer): ?>
                <tr>
                    <td><?= esc($answer['question_name']) ?></td>
                    <td><?= esc($answer['answer_text']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= site_url('submissions?questionnaire_id=' . $questionnaire['id']) ?>" class="btn btn-secondary">Back to Submissions</a>
</div>
<?= $this->endSection() ?>
