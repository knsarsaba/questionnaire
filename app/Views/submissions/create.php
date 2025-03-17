<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Submit Answers</h2>
    <p>Answer the following questions for <strong>Questionnaire #<?= esc($questionnaireId) ?></strong></p>

    <form action="<?= site_url('submissions/store') ?>" method="post">
        <input type="hidden" name="questionnaire_id" value="<?= esc($questionnaireId) ?>">

        <?php foreach ($questions as $question): ?>
            <div class="mb-3">
                <label class="form-label"><strong><?= esc($question['name']) ?></strong></label>
                <?php if (!empty($question['answers'])): ?>
                    <?php foreach ($question['answers'] as $answer): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="answers[<?= esc($question['id']) ?>]"
                                value="<?= esc($answer['id']) ?>"
                                required>
                            <label class="form-check-label"><?= esc($answer['label']) ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No answers available for this question.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?= $this->endSection() ?>
