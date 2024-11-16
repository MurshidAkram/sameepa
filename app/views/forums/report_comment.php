<!-- app/views/forums/report_comment.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <title>Report Comment | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="container">
        <h1>Report Comment</h1>
        <form action="<?php echo URLROOT; ?>/forums/report_comment/<?php echo $data['comment_id']; ?>" method="POST">
            <div class="form-group">
                <label for="reason">Reason for Reporting</label>
                <textarea name="reason" id="reason" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Report Comment</button>
        </form>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>