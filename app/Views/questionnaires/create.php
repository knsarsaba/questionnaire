<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2><?= isset($questionnaire) ? 'Update' : 'Create' ?> Questionnaire</h2>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('questionnaires/store') ?>" method="post">
        <input type="hidden" name="id" value="<?= isset($questionnaire) ? esc($questionnaire['id']) : '' ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= isset($questionnaire) ? esc($questionnaire['name']) : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-success"><?= isset($questionnaire) ? 'Update' : 'Create' ?></button>
        <a href="<?= site_url('questionnaires') ?>" class="btn btn-secondary">Cancel</a>
    </form>

</div>
<?= $this->endSection() ?>
