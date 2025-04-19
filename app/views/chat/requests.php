<!-- app/views/chat/requests.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Chat Requests | <?php echo SITENAME; ?></title>
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
                </nav>
            </aside>

            <div class="groups-content">
                <h1>Chat Requests</h1>

                <div class="groups-grid">
                    <?php if (!empty($data['requests'])): ?>
                        <?php foreach ($data['requests'] as $request): ?>
                            <div class="group-card" id="request-<?php echo $request->id; ?>">
                                <div class="group-image">
                                    <img src="<?php echo URLROOT; ?>/img/default-user.png" alt="User profile">
                                </div>
                                <div class="group-details">
                                    <h3 class="group-title"><?php echo htmlspecialchars($request->name); ?></h3>
                                    <div class="group-actions" id="actions-<?php echo $request->id; ?>">
                                        <button onclick="acceptRequest(<?php echo $request->id; ?>, <?php echo $request->sender_id; ?>)"
                                            class="btn-update-group">Accept</button>
                                        <button onclick="declineRequest(<?php echo $request->id; ?>)"
                                            class="btn-delete-group">Decline</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-groups">
                            <p>No pending chat requests.</p>
                            <a href="<?php echo URLROOT; ?>/chat/search" class="btn-view-group">Find Users to Chat</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .group-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .group-image {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }
        .group-image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .group-details {
            flex: 1;
        }
        .group-title {
            margin: 0 0 10px 0;
            font-size: 1.1em;
            color: #333;
        }
        .group-actions {
            display: flex;
            gap: 10px;
        }
        .btn-update-group, .btn-delete-group {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .btn-update-group {
            background-color: #4CAF50;
            color: white;
        }
        .btn-delete-group {
            background-color: #f44336;
            color: white;
        }
        .btn-update-group:hover {
            background-color: #45a049;
        }
        .btn-delete-group:hover {
            background-color: #da190b;
        }
        .btn-start-chat {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn-start-chat:hover {
            background-color: #45a049;
        }
        .no-groups {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn-view-group {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-view-group:hover {
            background-color: #45a049;
        }
    </style>

<script>
function acceptRequest(requestId, senderId) {
    fetch("<?php echo URLROOT; ?>/chat/acceptRequest", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `request_id=${requestId}&sender_id=${senderId}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const actionsDiv = document.getElementById("actions-" + requestId);
            actionsDiv.innerHTML = `<a href="${data.start_chat_url}" class="btn-start-chat">Start Chat</a>`;
        } else {
            alert("Failed to accept request.");
        }
    });
}

function declineRequest(requestId) {
    fetch("<?php echo URLROOT; ?>/chat/declineRequest", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `request_id=${requestId}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const requestCard = document.getElementById("request-" + requestId);
            if (requestCard) {
                requestCard.remove();
            }

            // Optional: check if no more requests are left
            if (document.querySelectorAll('.group-card').length === 0) {
                const contentDiv = document.querySelector('.groups-content .groups-grid');
                contentDiv.innerHTML = `
                    <div class="no-groups">
                        <p>No pending chat requests.</p>
                        <a href="<?php echo URLROOT; ?>/chat/search" class="btn-view-group">Find Users to Chat</a>
                    </div>
                `;
            }
        } else {
            alert("Failed to decline request.");
        }
    });
}
</script>

</body>
</html>