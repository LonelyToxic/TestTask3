<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .pagination li {
            margin-right: 5px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Comments</h1>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="?sort_by=id&sort_order=ASC" class="btn btn-outline-secondary mb-2">Sort by ID ASC</a>
                <a href="?sort_by=id&sort_order=DESC" class="btn btn-outline-secondary mb-2">Sort by ID DESC</a>
                <a href="?sort_by=created_at&sort_order=ASC" class="btn btn-outline-secondary mb-2">Sort by Date ASC</a>
                <a href="?sort_by=created_at&sort_order=DESC" class="btn btn-outline-secondary mb-2">Sort by Date DESC</a>
            </div>
        </div>

        <div id="comments">
            <?php if (! empty($comments) && is_array($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment mb-4 p-3 border rounded" data-id="<?= esc($comment['id']) ?>">
                        <h5><?= esc($comment['name']) ?></h5>
                        <p><?= esc($comment['text']) ?></p>
                        <small class="text-muted"><?= esc($comment['created_at']) ?></small>
                        <button class="btn btn-danger btn-delete mt-2" data-id="<?= esc($comment['id']) ?>">Delete</button>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p>No comments found.</p>
            <?php endif ?>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <?= $pager->links('default', 'bootstrap_pagination') ?>
        </div>

        <form id="commentForm" action="/comment/create" method="post" class="mt-4">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="text">Comment</label>
                <textarea id="text" name="text" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="created_at">Date</label>
                <input type="date" id="created_at" name="created_at" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#commentForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#comments').prepend(response);
                        $('#commentForm')[0].reset();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.btn-delete', function() {
                var commentId = $(this).data('id');
                $.ajax({
                    url: '/comment/delete/' + commentId,
                    method: 'DELETE',
                    data: {
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        $('.comment[data-id="' + commentId + '"]').remove();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
