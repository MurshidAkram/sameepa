<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/polls.css">
    <title>Edit Poll | Community Garden Location</title>

    <style>
        .edit-poll-container {
            background: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 100%);
            border: 1px solid #d1d9e6;
            padding: 2.5rem;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05),
                0 5px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .form-group.disabled input {
            background-color: #f0f0f0;
            cursor: not-allowed;
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
        // Simulated side panel for a resident user
        require APPROOT . '/views/inc/components/side_panel_resident.php';
        ?>

        <main class="polls-main">
            <div class="create-poll-container edit-poll-container">
                <h1>Edit Poll</h1>
                <form action="#" method="POST" class="poll-form">
                    <div class="form-group">
                        <label for="title">Poll Title <span class="required">*</span></label>
                        <input type="text" name="title" id="title"
                            value="Community Garden Location"
                            maxlength="100"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Poll Description</label>
                        <textarea name="description" id="description"
                            maxlength="500"
                            rows="4"
                            required>Help us decide the best location for our new community garden. Your input matters!</textarea>
                    </div>

                    <div class="form-group">
                        <label>Poll End Date <span class="required">*</span></label>
                        <input type="date" name="end_date" id="end_date"
                            value="<?php echo date('Y-m-d', strtotime('+2 weeks')); ?>"
                            min="<?php echo date('Y-m-d'); ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Poll Choices</label>
                        <div class="poll-choices-container" id="poll-choices-container">
                            <?php
                            $choices = [
                                'North Side Park',
                                'Community Center Grounds',
                                'Vacant Lot on Main Street',
                                'Behind the Library'
                            ];

                            foreach ($choices as $choice): ?>
                                <div class="poll-choice-input">
                                    <input type="text" name="choices[]"
                                        value="<?php echo $choice; ?>"
                                        placeholder="Enter poll choice"
                                        class="form-control"
                                        maxlength="100"
                                        required>
                                    <button type="button" class="btn-remove-choice" onclick="removeChoice(this)">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn-add-choice" onclick="addChoice()">Add Choice</button>
                        <small class="form-text text-muted">You must have 2-5 poll choices.</small>
                    </div>

                    <div class="form-actions">
                        <a href="<?php echo URLROOT; ?>/polls/index" class="btn btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Poll</button>
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