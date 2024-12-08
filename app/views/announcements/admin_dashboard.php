<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/announcements/admin_dashboard.css">
    <title>Admin Dashboard - Announcements | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="admin-announcements-main">
            <div class="admin-header">
                <h1>Announcements Management</h1>
                <div class="search-container">
                    <input type="search" id="search-announcements" placeholder="Search announcements..." class="search-input">
                    <button class="search-btn" onclick="searchAnnouncements()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/announcements/create" class="btn-create">
                    <i class="fas fa-plus"></i> Create New Announcement
                </a>
            </div>

            <div class="announcements-stats">
                <div class="stat-card">
                    <i class="fas fa-bullhorn"></i>
                    <div class="stat-info">
                        <h3>Total Announcements</h3>
                        <p><?php echo $data['stats']['total']; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <h3>Active Announcements</h3>
                        <p><?php echo $data['stats']['active']; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar"></i>
                    <div class="stat-info">
                        <h3>This Month</h3>
                        <p><?php echo $data['stats']['monthly']; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-thumbs-up"></i>
                    <div class="stat-info">
                        <h3>Total Reactions</h3>
                        <p><?php echo $data['stats']['reactions']; ?></p>
                    </div>
                </div>
            </div>
            <div class="announcements-table-container">
                <div class="table-header">
                    <h2>All Announcements</h2>
                    <div class="filter-container">
                        <div class="filter-group">
                            <span class="filter-label">Status:</span>
                            <select class="filter-select" id="status-filter">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <span class="filter-label">Sort By:</span>
                            <select class="filter-select" id="sort-filter">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="announcements-list">
                    <?php foreach ($data['announcements'] as $announcement) : ?>
                        <div class="announcement-card" 
                             data-date="<?php echo $announcement->created_at; ?>"
                             data-reactions="<?php echo $announcement->total_reactions; ?>">
                            <div class="announcement-content">
                                <h2><?php echo $announcement->title; ?></h2>
                                <div class="announcement-meta">
                                    <span class="created-by">Posted by <?php echo $announcement->creator_name; ?></span>
                                    <span class="created-at"><?php echo date('M d, Y', strtotime($announcement->created_at)); ?></span>
                                    <span class="status-badge <?php echo $announcement->status; ?>"><?php echo ucfirst($announcement->status); ?></span>
                                </div>
                                <p class="announcement-preview"><?php echo substr($announcement->content, 0, 200) . '...'; ?></p>
                            </div>

                            <div class="announcement-actions">
                                <a href="<?php echo URLROOT; ?>/announcements/viewannouncement/<?php echo $announcement->id; ?>" class="abtnview">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo URLROOT; ?>/announcements/edit/<?php echo $announcement->id; ?>" class="abtnedit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form class="delete-form" action="<?php echo URLROOT; ?>/announcements/delete/<?php echo $announcement->id; ?>" method="post">
                                    <button type="submit" class="abtndelete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
          <script>
              function searchAnnouncements() {
                  const searchTerm = document.getElementById('search-announcements').value;
                  window.location.href = '<?php echo URLROOT; ?>/announcements/admin_dashboard?search=' + encodeURIComponent(searchTerm);
              }

              document.getElementById('status-filter').addEventListener('change', function() {
                  const status = this.value;
                  document.querySelectorAll('.announcement-card').forEach(card => {
                      if (status === 'all' || card.querySelector('.status-badge').classList.contains(status)) {
                          card.style.display = 'flex';
                      } else {
                          card.style.display = 'none';
                      }
                  });
              });

              document.getElementById('sort-filter').addEventListener('change', function() {
                  const sortBy = this.value;
                  const announcements = document.querySelectorAll('.announcement-card');
                  const announcementsList = document.querySelector('.announcements-list');
            
                  const sortedAnnouncements = Array.from(announcements).sort((a, b) => {
                      if (sortBy === 'newest') {
                          return new Date(b.dataset.date) - new Date(a.dataset.date);
                      } else if (sortBy === 'oldest') {
                          return new Date(a.dataset.date) - new Date(b.dataset.date);
                      }
                  });
            
                  announcementsList.innerHTML = '';
                  sortedAnnouncements.forEach(announcement => {
                      announcementsList.appendChild(announcement);
                  });
              });
          </script>
      </body>
</html>
