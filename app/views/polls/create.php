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

    <style>
        /* i added inline styling to improve the look */
        .create-poll-container {
            background: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 100%);
            border: 1px solid #d1d9e6;
            padding: 2.5rem;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05),
                0 5px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .create-poll-container:hover {
            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.08),
                0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .poll-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .poll-form input,
        .poll-form textarea {
            border: 1.5px solid #e0e0e0;
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .poll-form input:focus,
        .poll-form textarea:focus {
            border-color: #800080;
            outline: none;
            box-shadow: 0 0 0 3px rgba(128, 0, 128, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .btn-cancel,
        .btn-primary {
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: #333;
            border: 1.5px solid #d0d0d0;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
        }

        .btn-primary {
            background-color: #800080;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #660066;
            transform: translateY(-2px);
        }

        .form-text.text-muted {
            color: #777;
            font-style: italic;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        /* Poll Choices Styling */
        .poll-choices-container {
            background: linear-gradient(to right, #f9f9f9, #f5f5f5);
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .poll-choice-input {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .poll-choice-input input {
            flex-grow: 1;
        }

        .btn-remove-choice {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            transition: background-color 0.3s ease;
        }

        .btn-remove-choice:hover {
            background-color: #ff1a1a;
        }
    </style>
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