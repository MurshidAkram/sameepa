<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/complaints.css">

    <title>Create Complaint | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">


        <main>
            <div class="create-complaint-container">
                <div class="page-header">
                    <h1>Create New Complaint</h1>
                    <a href="<?php echo URLROOT; ?>/complaints/mycomplaints" class="btn btn-secondary">Back</a>
                </div>

                <form action="<?php echo URLROOT; ?>/complaints/create" method="POST" class="complaint-form">
                    <div class="form-group">
                        <label for="title">Complaint Title</label>
                        <input type="text" name="title" id="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" rows="6"><?php echo $data['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit Complaint</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>