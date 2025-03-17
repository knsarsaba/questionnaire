<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Questionnaires</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questionnaires as $questionnaire): ?>
                <tr>
                    <td><?= esc($questionnaire['id']) ?></td>
                    <td><?= esc($questionnaire['name']) ?></td>
                    <td>
                        <a href="<?= site_url('questionnaires/' . $questionnaire['id']) ?>" class="btn btn-info btn-sm">View Questions</a>
                        <a href="<?= site_url('questionnaires/edit/' . $questionnaire['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?= site_url('questionnaires/delete/' . $questionnaire['id']) ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="<?= site_url('submissions/create/' . $questionnaire['id']) ?>" class="btn btn-success btn-sm">Submit Answer</a>
                        <a href="<?= site_url('submissions?questionnaire_id=' . $questionnaire['id']) ?>" class="btn btn-secondary btn-sm">View Submissions</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= site_url('questionnaires/create') ?>" class="btn btn-primary mb-3">Create Questionnaire</a>
</div>
<?= $this->endSection() ?>
