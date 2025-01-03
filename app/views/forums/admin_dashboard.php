<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums/admin_dashboard.css">
    <title>Forums Management | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main class="admin-main">
            <div class="admin-header">
                <div class="header-content">
                    <h1>Forums Management</h1>
                    <div class="search-container">
                        <input type="search" id="search-forums" placeholder="Search forums..." class="search-input">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/forums/myforums" class="action-btn my-forums">
                    <i class="fas fa-list"></i> My Forums
                </a>
                <a href="<?php echo URLROOT; ?>/forums/create" class="action-btn create">
                    <i class="fas fa-plus"></i> Create Forum
                </a>
            </div>

            <div class="forums-stats">
                <div class="stat-card">                    
                    <div class="stat-info">
                        <h3><i class="fas fa-comments"></i> Total Forums</h3>
                        <p><?php echo isset($data['forums']) ? count($data['forums']) : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">                    
                    <div class="stat-info">
                        <h3><i class="fas fa-flag"></i> Reported Comments</h3>
                        <p><?php echo isset($forum->total_reports) ? $forum->total_reports : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">                    
                    <div class="stat-info">
                        <h3><i class="fas fa-users"></i> Active Users</h3>
                        <p><?php echo isset($forum->active_users) ? $forum->active_users : 0; ?></p>
                    </div>
                </div>
            </div>

              <div class="forums-container">
                  <div class="table-header">
                      <h2>All Forums</h2>
                      <div class="filters">
                          <select class="filter-select" id="sort-filter">
                              <option value="newest">Newest First</option>
                              <option value="oldest">Oldest First</option>
                              <option value="most-active">Most Active</option>
                          </select>
                      </div>
                  </div>
                  <div class="table-responsive">
                      <table class="forums-table">
                          <thead>
                              <tr>
                                  <th>Title</th>
                                  <th>Description</th>
                                  <th>Created By</th>
                                  <th>Date</th>
                                  <th>Comments</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($data['forums'] as $forum) : ?>
                                  <tr>
                                      <td class="forum-title"><?php echo $forum->title; ?></td>
                                      <td class="forum-description"><?php echo substr($forum->description, 0, 100) . '...'; ?></td>
                                      <td>
                                          <span class="creator">
                                              <?php echo $this->getUserNameById($forum->created_by); ?>
                                          </span>
                                      </td>
                                      <td>
                                          <span class="date">
                                              <?php echo date('M d, Y', strtotime($forum->created_at)); ?>
                                          </span>
                                      </td>
                                      <td>
                                          <span class="comment-count">
                                              <?php echo $this->getCommentCountByForumId($forum->id); ?>
                                          </span>
                                      </td>
                                      <td class="action-buttons">
                                          <a href="<?php echo URLROOT; ?>/forums/view_forum/<?php echo $forum->id; ?>" class="btn view">
                                              <i class="fas fa-eye"></i>
                                          </a>
                                          <a href="<?php echo URLROOT; ?>/forums/reported_comments/<?php echo $forum->id; ?>" class="btn reports">
                                              <i class="fas fa-flag"></i>
                                          </a>
                                          <a href="<?php echo URLROOT; ?>/forums/delete/<?php echo $forum->id; ?>" class="btn delete" 
                                           onclick="return confirm('Are you sure you want to delete this forum?')">
                                              <i class="fas fa-trash"></i>
                                          </a>
                                      </td>
                                  </tr>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                  </div>
              </div>
          </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    
    <script>
        document.getElementById('sort-filter').addEventListener('change', function() {
            // Add sorting functionality here
        });

        document.getElementById('search-forums').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.forums-table tbody tr');
    
    rows.forEach(row => {
        const forumTitle = row.querySelector('.forum-title').textContent.toLowerCase();
        const forumDescription = row.querySelector('.forum-description').textContent.toLowerCase();
        row.style.display = (forumTitle.includes(searchText) || forumDescription.includes(searchText)) ? '' : 'none';
    });
});

    </script>
</body>
</html>