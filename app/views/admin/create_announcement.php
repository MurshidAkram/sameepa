  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
      <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
      <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
      <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/create_announcement.css">
      <title>Create Announcement | <?php echo SITENAME; ?></title>
  </head>

  <body>
      <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

      <div class="dashboard-container side-panel-open">
          <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
              <main class="create-announcement-dashboard">
                  <a href="<?php echo URLROOT; ?>/admin/announcements" class="btn-back">Back</a>
                  <section class="announcement-form">
                      <h1>Create New Announcement</h1>
                      <form action="<?php echo URLROOT; ?>/admin/create_announcement" method="post">
                          <div class="form-group">
                              <label for="topic">Topic:</label>
                              <input type="text" id="topic" name="topic" required>
                          </div>

                          <div class="form-group">
                              <label for="date">Date:</label>
                              <input type="date" id="date" name="date" required>
                          </div>

                          <div class="form-group">
                              <label for="description">Description:</label>
                              <textarea id="description" name="description" required></textarea>
                          </div>

                          <div class="form-group">
                              <label for="category">Category:</label>
                              <select id="category" name="category" required>
                                  <option value="">Select a category</option>
                                  <option value="general">General</option>
                                  <option value="maintenance">Maintenance</option>
                                  <option value="event">Event</option>
                                  <option value="emergency">Emergency</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="target_audience">Target Audience:</label>
                              <select id="target_audience" name="target_audience" required>
                                  <option value="">Select target audience</option>
                                  <option value="all_residents">All Residents</option>
                                  <option value="homeowners">Homeowners</option>
                                  <option value="tenants">Tenants</option>
                                  <option value="staff">Staff</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="priority">Priority:</label>
                              <select id="priority" name="priority" required>
                                  <option value="">Select priority</option>
                                  <option value="low">Low</option>
                                  <option value="medium">Medium</option>
                                  <option value="high">High</option>
                                  <option value="urgent">Urgent</option>
                              </select>
                          </div>

                          <button type="submit" class="btn-submit">Create Announcement</button>
                      </form>
                  </section>
              </main>
      </div>
      <?php require APPROOT . '/views/inc/components/footer.php'; ?>
  </body>

  </html>