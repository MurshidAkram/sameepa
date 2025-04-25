<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">

    <title>Report Details | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
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

        <main class="groups-main">
            <aside class="groups-sidebar">
                <h2>Chat Navigation</h2>
                <?php $current_page = basename($_SERVER['REQUEST_URI']); ?>

                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="<?php echo ($current_page == 'index' ? 'active' : ''); ?>">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="<?php echo ($current_page == 'search' ? 'active' : ''); ?>">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="<?php echo ($current_page == 'requests' ? 'active' : ''); ?>">Chat Requests</a>
                    <a href="<?php echo ($_SESSION['user_role_id'] == 3) ? URLROOT . '/chat/report' : URLROOT . '/chat/myreports'; ?>" 
   class="<?php echo ($current_page == (($_SESSION['user_role_id'] == 3) ? 'view Reports' : 'Report')) ? 'active' : ''; ?>">
    <?php echo ($_SESSION['user_role_id'] == 3) ? 'Reports' : 'Report'; ?>
</a>
                </nav>
            </aside>

            <div class="group-view-container">
                <div class="top-actions">
                    <a href="<?php echo ($_SESSION['user_role_id'] == 3) ? URLROOT . '/chat/report' : URLROOT . '/chat/myreports'; ?>" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                    <!-- Add a "Close Report" button/action if needed, perhaps handled via status update -->
                </div>

                <div class="group-view-content">
                    <div>
                        <h1 class="group-title">Report: <?php echo htmlspecialchars($data['report']->category); ?></h1>

                        <div class="group-meta">
                        <?php if ($_SESSION['user_role_id'] == 3): ?>
    <div class="meta-item">
        <i class="fas fa-user"></i>
        Reported By: <?php echo htmlspecialchars($data['report']->reporter_name); ?>
    </div>
<?php endif; ?>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                Reported on: <?php echo date('F j, Y, g:i a', strtotime($data['report']->created_at)); ?>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-flag"></i>
                                Status: <?php echo htmlspecialchars(ucfirst($data['report']->status)); ?>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user-shield"></i>
                                Reported User/Message: <?php echo htmlspecialchars($data['report']->reported_user_message); ?>
                            </div>
                        </div>

                        <div class="group-description">
                            <h2>Report Details</h2>
                            <p><?php echo htmlspecialchars($data['report']->description); ?></p>
                        </div>

                        <!-- Assuming there's no specific "Reported Conversation" block data in the model for now -->
                        <!-- You might add a section here to display relevant chat messages if available -->

                        <?php if ($_SESSION['user_role_id'] == 3 && $data['report']->status == 'pending') : ?>
                            <div class="form-buttons">
                                <form action="<?php echo URLROOT; ?>/chat/validatereport/<?php echo $data['report']->id; ?>" method="POST" style="display: inline-block;">
                                    <button type="submit" class="btn-submit">
                                        <i class="fas fa-check"></i> Validate Report
                                    </button>
                                </form>
                                <form action="<?php echo URLROOT; ?>/chat/dismissreport/<?php echo $data['report']->id; ?>" method="POST" style="display: inline-block;">
                                    <button type="submit" class="btn-cancel">
                                        <i class="fas fa-ban"></i> Dismiss Report
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['user_role_id'] != 3 && $data['report']->reporter_id == $_SESSION['user_id'] && $data['report']->status == 'pending') : ?>
    <div class="form-buttons">
        <a href="<?php echo URLROOT; ?>/chat/editreport/<?php echo $data['report']->id; ?>" class="btn-submit">
            <i class="fas fa-edit"></i> Edit Report
        </a>
        <form action="<?php echo URLROOT; ?>/chat/deletereport/<?php echo $data['report']->id; ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this report?');">
            <button type="submit" class="btn-cancel">
                <i class="fas fa-trash"></i> Delete Report
            </button>
        </form>
    </div>
<?php endif; ?>

                   </div>

                   <!-- Assuming there's no specific "Report Evidence" image data in the model for now -->
                   <!-- You might add a section here to display uploaded evidence if available -->

                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
<style>
  .group-view-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.group-view-content {
    background-color: #ffffff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.top-actions {
    margin-bottom: 15px;
}

.back-button {
    background-color: #4b5563;
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #374151;
}

.back-button i {
    font-size: 0.8rem;
}

.group-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.group-meta {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 25px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    color: #666;
}

.meta-item i {
    font-size: 0.8rem;
    color: #800080;
}

.meta-item span {
    color: #2c3e50;
    font-weight: 500;
}

.meta-item.reported-user-message {
    flex-direction: column;
    align-items: flex-start;
}

.meta-item.reported-user-message span {
    margin-left: 20px;
    display: block;
}

.group-description {
    position: relative;
    margin-bottom: 20px;
    padding-top: 15px;
}

.group-description::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background-color: #800080;
}

.group-description h2 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.group-description p {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.5;
}

/* Styling for the form-buttons section */
.form-buttons {
    display: flex;
    gap: 15px; /* Space between buttons */
    margin-top: 20px; /* Space above buttons */
}

/* Edit Report button */
.btn-submit {
    background: linear-gradient(135deg, #800080, #6a006a); /* Purple gradient */
    color: #ffffff; /* White text */
    padding: 10px 20px; /* Padding to match screenshot */
    border-radius: 6px; /* Rounded corners */
    border: none; /* No border */
    font-size: 0.95rem; /* Font size */
    font-weight: 500; /* Medium weight */
    text-decoration: none; /* For the <a> tag */
    display: inline-flex; /* Flex to align icon and text */
    align-items: center; /* Center vertically */
    gap: 5px; /* Space between icon and text */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: background 0.3s ease, transform 0.1s ease, box-shadow 0.2s ease;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #6a006a, #550055); /* Darker purple on hover */
    transform: translateY(-2px); /* Slight lift on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
}

.btn-submit:active {
    transform: translateY(0); /* Reset lift on click */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Reduced shadow on click */
}

.btn-submit i {
    font-size: 0.9rem; /* Slightly smaller icon */
}

/* Delete Report button */
.btn-cancel {
    background: linear-gradient(135deg, #e74c3c, #c0392b); /* Red gradient */
    color: #ffffff; /* White text */
    padding: 10px 20px; /* Padding to match screenshot */
    border-radius: 6px; /* Rounded corners */
    border: none; /* No border */
    font-size: 0.95rem; /* Font size */
    font-weight: 500; /* Medium weight */
    display: inline-flex; /* Flex to align icon and text */
    align-items: center; /* Center vertically */
    gap: 5px; /* Space between icon and text */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: background 0.3s ease, transform 0.1s ease, box-shadow 0.2s ease;
}

.btn-cancel:hover {
    background: linear-gradient(135deg, #c0392b, #a0291f); /* Darker red on hover */
    transform: translateY(-2px); /* Slight lift on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
}

.btn-cancel:active {
    transform: translateY(0); /* Reset lift on click */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Reduced shadow on click */
}

.btn-cancel i {
    font-size: 0.9rem; /* Slightly smaller icon */
}
    </style>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".groups-nav a");

        links.forEach(link => {
            link.addEventListener("click", function() {
                // Remove active class from all links
                links.forEach(l => l.classList.remove("active"));

                // Add active class to the clicked link
                this.classList.add("active");
            });
        });
    });
</script>

</html>