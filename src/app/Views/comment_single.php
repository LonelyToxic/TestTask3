<div class="comment mb-4 p-3 border rounded" data-id="<?= esc($id) ?>">
    <h5><?= esc($name) ?></h5>
    <p><?= esc($text) ?></p>
    <small class="text-muted"><?= esc($created_at) ?></small>
    <button class="btn btn-danger btn-delete mt-2" data-id="<?= esc($id) ?>">Delete</button>
</div>
