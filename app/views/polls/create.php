<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/polls.css">
    <title>Create Poll | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
        switch ($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="polls-main">
            <div class="create-poll-container">
                <h1>Create New Poll</h1>
                <form action="<?php echo URLROOT; ?>/polls/create" method="POST" class="poll-form">
                    <div class="form-group">
                        <label for="title">Poll Title <span class="required">*</span></label>
                        <input type="text" name="title" id="title"
                            class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['title'] ?? ''; ?>"
                            maxlength="100"
                            required>
                        <?php if (!empty($data['title_err'])): ?>
                            <div class="invalid-feedback"><?php echo $data['title_err']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="description">Poll Description</label>
                        <textarea name="description" id="description"
                            class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"
                            maxlength="500"
                            rows="4"><?php echo $data['description'] ?? ''; ?></textarea>
                        <?php if (!empty($data['description_err'])): ?>
                            <div class="invalid-feedback"><?php echo $data['description_err']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="end_date">Poll End Date <span class="required">*</span></label>
                        <input type="date" name="end_date" id="end_date"
                            class="form-control <?php echo (!empty($data['end_date_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['end_date'] ?? ''; ?>"
                            min="<?php echo date('Y-m-d'); ?>"
                            required>
                        <?php if (!empty($data['end_date_err'])): ?>
                            <div class="invalid-feedback"><?php echo $data['end_date_err']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Poll Choices <span class="required">*</span></label>
                        <div class="poll-choices-container" id="poll-choices-container">
                            <div class="poll-choice-input">
                                <input type="text" name="choices[]"
                                    placeholder="Enter poll choice"
                                    class="form-control"
                                    maxlength="100"
                                    required>
                                <button type="button" class="btn-remove-choice" onclick="removeChoice(this)">Remove</button>
                            </div>
                            <div class="poll-choice-input">
                                <input type="text" name="choices[]"
                                    placeholder="Enter poll choice"
                                    class="form-control"
                                    maxlength="100"
                                    required>
                                <button type="button" class="btn-remove-choice" onclick="removeChoice(this)">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn-add-choice" onclick="addChoice()">Add Choice</button>
                        <small class="form-text text-muted">You must have 2-5 poll choices.</small>
                    </div>

                    <div class="form-actions">
                        <a href="<?php echo URLROOT; ?>/polls" class="btn btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Poll</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function addChoice() {
            const container = document.getElementById('poll-choices-container');
            if (container.children.length < 5) {
                const newChoice = document.createElement('div');
                newChoice.className = 'poll-choice-input';
                newChoice.innerHTML = `
                <input type="text" name="choices[]" 
                       placeholder="Enter poll choice" 
                       class="form-control" 
                       maxlength="100" 
                       required>
                <button type="button" class="btn-remove-choice" onclick="removeChoice(this)">Remove</button>
            `;
                container.appendChild(newChoice);
            } else {
                alert('You can add a maximum of 5 poll choices.');
            }
        }

        function removeChoice(btn) {
            const container = document.getElementById('poll-choices-container');
            if (container.children.length > 2) {
                btn.closest('.poll-choice-input').remove();
            } else {
                alert('You must have at least two poll choices.');
            }
        }
    </script>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>