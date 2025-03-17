<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2><?= esc($questionnaire['name']) ?></h2>

    <!-- Add Question Form -->
    <form action="<?= site_url('questions/store') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="questionnaire_id" value="<?= $questionnaire['id'] ?>">
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Enter new question" required>
            <button type="submit" class="btn btn-primary">Add Question</button>
        </div>
    </form>

    <!-- List of Questions -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Question</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?= esc($question['name']) ?></td>
                    <td>
                        <form action="<?= site_url('questions/delete/' . $question['id']) ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <!-- Display Answers for Each Question -->
                <tr>
                    <td colspan="2">
                        <strong>Answers:</strong>
                        <ul>
                            <?php foreach ($question['answers'] as $answer): ?>
                                <li>
                                    <?= esc($answer['label']) ?>
                                    <form action="<?= site_url('answers/delete/' . $answer['id']) ?>" method="post" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="questionnaire_id" value="<?= $question['questionnaire_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <!-- Add Answer Form -->
                        <form action="<?= site_url('answers/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                            <input type="hidden" name="questionnaire_id" value="<?= $question['questionnaire_id'] ?>">
                            <div class="input-group mb-3">
                                <input type="text" name="label" class="form-control" placeholder="Enter new answer" required>
                                <button type="submit" class="btn btn-success">Add Answer</button>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
