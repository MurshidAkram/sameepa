<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>External Provider Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
      <div class="dashboard-container">
          <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

          <main>
              <div class="dashboard-layout">
                  <!-- Left Side Profile Card -->
                  <div class="profile-sidebar">
                    <div class="profile-card">
                        <p>Profile</p>
                        <div class="profile-image">
                            <img src="<?php echo URLROOT; ?>/img/default-profile.png" alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h2 class="username"><?php echo $_SESSION['name']; ?></h2>
                            <div class="stats">
                                <div class="stat-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>11</span>
                                    <p>Completed</p>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-users"></i>
                                    <span>56</span>
                                    <p>Followers</p>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-star"></i>
                                    <span>4.8</span>
                                    <p>Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- Right Side Content -->
                  <div class="dashboard-content">
                      <!-- Your existing dashboard cards here -->
                      <div class="dashboard-grid">
                          <!-- Service Requests Card -->
                          <div class="card requests-card">
                              <h2>Service Requests</h2>
                              <table class="requests-table">
                                  <tr>
                                      <th>Request ID</th>
                                      <th>Service</th>
                                      <th>Status</th>
                                  </tr>
                                  <tr>
                                      <td>SR001</td>
                                      <td>Plumbing</td>
                                      <td class="status-pending">Pending</td>
                                  </tr>
                                  <tr>
                                      <td>SR002</td>
                                      <td>Electrical</td>
                                      <td class="status-completed">Completed</td>
                                  </tr>
                                  <tr>
                                      <td>SR003</td>
                                      <td>Carpentry</td>
                                      <td class="status-in-progress">In Progress</td>
                                  </tr>
                              </table>
                          </div>

                          <!-- Payment Overview Card -->
                          <div class="card payment-card">
                              <h2>Monthly Payments</h2>
                              <canvas id="paymentChart"></canvas>
                          </div>

                          <!-- Service Analytics Card -->
                          <div class="card analytics-card">
                              <h2>Service Analytics</h2>
                              <canvas id="serviceAnalyticsChart"></canvas>
                          </div>
                      </div>
                  </div>
              </div>
          </main>
      </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Payment Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Unpaid'],
                datasets: [{
                    data: [120, 30],
                    backgroundColor: ['#800080', '#e0e0e0']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed;
                            }
                        }
                    }
                }
            }
        });

        // Service Analytics Chart
        const analyticsCtx = document.getElementById('serviceAnalyticsChart').getContext('2d');
        new Chart(analyticsCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Completed Services',
                    data: [8, 6, 5, 9, 7, 10, 6],
                    backgroundColor: '#6a006a'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>



