<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <title><?php echo SITENAME; ?> - Create Forum</title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="container">
        <h1>Create Forum</h1>

        <?php if (!empty($data['errors'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($data['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo URLROOT; ?>/forums/create" method="POST">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control"><?php echo isset($data['description']) ? $data['description'] : ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Forum</button>
        </form>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>