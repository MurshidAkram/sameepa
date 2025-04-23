<!-- app/views/chat/search.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title><?php echo $data['title']; ?> | <?php echo SITENAME; ?></title>
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
                    <a href="<?php echo URLROOT; ?>/chat/index" class="<?php echo ($current_page == 'index' || $current_page == 'chat') ? 'active' : ''; ?>">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="<?php echo ($current_page == 'search') ? 'active' : ''; ?>">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="<?php echo ($current_page == 'requests') ? 'active' : ''; ?>">Chat Requests</a>
                    <a href="<?php echo ($_SESSION['user_role_id'] == 3) ? URLROOT . '/chat/report' : URLROOT . '/chat/myreports'; ?>" 
   class="<?php echo ($current_page == (($_SESSION['user_role_id'] == 3) ? 'view Reports' : 'Report')) ? 'active' : ''; ?>">
    <?php echo ($_SESSION['user_role_id'] == 3) ? 'Reports' : 'Report'; ?>
</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>Search Users</h1>
                <?php flash('chat_message'); ?>
                
                <form class="groups-search" method="POST" action="<?php echo URLROOT; ?>/chat/search">
                    <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Search users...">
                    <button type="submit">Search</button>
                </form>
                
                <p>Find and connect with other users in the community.</p>
                
                <div class="users-grid">
                    <?php
                    // Define role name mapping
                    $roleNames = [
                        1 => 'Resident',
                        2 => 'Admin',
                        3 => 'Super Admin',
                        4 =>'Maintenance',
                        5 =>'Security',
                        6=>'External Service Provider'
                    ];
                    ?>

                    <?php if (!empty($data['users'])): ?>
                        <?php foreach ($data['users'] as $user): ?>
                            <div class="user-card">
                                <div class="user-avatar">
                                    <?php if (!empty($user->profile_picture)): ?>
                                        <img src="<?php echo htmlspecialchars($user->profile_picture); ?>" alt="Profile Picture">
                                    <?php else: ?>
                                        <img src="<?php echo URLROOT; ?>/img/default-user.png" alt="Default Profile">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="user-details">
                                    <h3 class="user-name"><?php echo htmlspecialchars($user->name); ?></h3>
                                    <span class="user-role">
                                        <?php echo isset($roleNames[$user->role_id]) ? $roleNames[$user->role_id] : 'Unknown'; ?>
                                    </span>
                                </div>
                                
                                <div class="user-actions">
                                    <?php if (!isset($data['existingRequests'][$user->id])): ?>
                                        <form action="<?php echo URLROOT; ?>/chat/sendRequest" method="POST">
                                            <input type="hidden" name="recipient_id" value="<?php echo $user->id; ?>">
                                            <button type="submit" class="btn-primary">Send Request</button>
                                        </form>
                                    <?php elseif ($data['existingRequests'][$user->id] == 'pending'): ?>
                                        <button class="btn-disabled" disabled>Request Pending</button>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/chat/viewChat/<?php echo $user->id; ?>" class="btn-view">View Chat</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-users">
                            <p>No users found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

<style>
.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.user-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    padding: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.2s;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.user-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 15px;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-details {
    text-align: center;
    margin-bottom: 15px;
}

.user-name {
    margin: 0 0 5px;
    font-size: 1.2em;
    color: #333;
}

.user-role {
    font-size: 0.9em;
    color: #666;
}

.user-actions {
    width: 100%;
}

.btn-primary, .btn-view, .btn-disabled {
    display: block;
    width: 100%;
    padding: 8px 0;
    border-radius: 4px;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-primary {
    background: #800080;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background: #6a006a;
}

.btn-view {
    background: rgb(123, 123, 123);
    color: #fff;
    text-decoration: none;
}

.btn-view:hover {
    background: rgb(92, 92, 93);
}

.btn-disabled {
    background: #ccc;
    color: #666;
    cursor: not-allowed;
}

.no-users {
    grid-column: 1 / -1;
    text-align: center;
    padding: 30px;
    color: #666;
}

.groups-search {
    display: flex;
    margin-bottom: 20px;
}

.groups-search input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px 0 0 4px;
    font-size: 1em;
}

.groups-search button {
    background: #800080;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".groups-nav a");

        links.forEach(link => {
            link.addEventListener("click", function() {
                links.forEach(l => l.classList.remove("active"));
                this.classList.add("active");
            });
        });
    });
</script>
</html>
