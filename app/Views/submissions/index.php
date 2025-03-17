<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Submissions for "<?= esc($questionnaire['name']) ?>"</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Submission ID</th>
                <th>Submitted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissions as $submission): ?>
                <tr>
                    <td><?= esc($submission['id']) ?></td>
                    <td><?= esc($submission['submitted_at']) ?></td>
                    <td>
                        <a href="<?= site_url('submissions/' . $submission['id']) ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= site_url('questionnaires') ?>" class="btn btn-secondary">Back to Questionnaires</a>
</div>
<?= $this->endSection() ?>
