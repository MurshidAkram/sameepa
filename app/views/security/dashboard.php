<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Security Dashboard | <?php echo SITENAME; ?></title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .dashboard-container {
      display: flex;
      background-color: #f8f9fa;
      padding: 20px;
      gap: 20px;
      min-height: calc(100vh - 120px);
    }

    .side-panel {
      flex-basis: 15%;
    }

    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .section {
      display: flex;
      flex-direction: column;
      background: #ffffff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      width: 100%;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .section h2 {
      font-size: 1.5em;
      color: #333;
      margin: 0;
    }

    .welcome-message {
      font-size: 1.2em;
      color: #555;
    }

    .grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .card {
      flex: 1 1 calc(33.333% - 20px);
      min-width: 250px;
      background: #f7f7f7;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      font-size: 1.2em;
      color: #333;
      margin-top: 0;
    }

    .card p {
      font-size: 1em;
      color: #555;
      margin-bottom: 0;
    }

    .metric-value {
      font-size: 1.8em;
      font-weight: bold;
      color: #6A5ACD;
      margin: 10px 0;
    }

    .officer-list {
      margin-top: 10px;
      text-align: left;
    }

    .officer-item {
      display: flex;
      justify-content: space-between;
      padding: 5px 0;
      border-bottom: 1px solid #eee;
    }

    .officer-name {
      font-weight: 500;
    }

    .officer-shift {
      color: #666;
      font-size: 0.9em;
    }

    .chart-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }

    .chart {
      flex: 1 1 calc(50% - 20px);
      min-width: 300px;
      
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chart h3 {
      margin-top: 0;
      color: #333;
      text-align: center;
    }

    .chart canvas {
      width: 100%;
      height: 250px;
    }

    /* Card colors */
    .card.passes { background-color: #D2B4DE; }
    .card.personnel { background-color: #A569BD; color: white; }
    .card.personnel h3, .card.personnel p, .card.personnel .officer-name { color: white; }
    .card.personnel .officer-shift { color: #f0f0f0; }

    /* Mini chart inside card */
    .card canvas {
      margin-top: 10px;
      width: 100% !important;
      height: 60px !important;
    }
  </style>
</head>
<body>
<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

<div class="dashboard-container">
  <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h2>Security Dashboard</h2>
        <div class="welcome-message">
          Welcome, <?php echo htmlspecialchars($data['name'] ?? $data['email']); ?> (Security)
        </div>
      </div>

      <!-- Key Metrics Section -->
      <div class="grid">
        <div class="card passes">
          <h3>Today's Visitor Passes</h3>
          <div class="metric-value" id="active-passes"><?php echo count($data['todayPasses']); ?></div>
          <p>Passes issued for today</p>
          <canvas id="miniVisitorChart"></canvas>
        </div>

        <div class="card personnel">
          <h3>Officers On Duty</h3>
          <div class="metric-value" id="on-duty"><?php echo count($data['onDutyOfficers']); ?></div>
          <p>Currently active</p>
          <canvas id="miniOfficerChart"></canvas>

          <div class="officer-list">
            <?php foreach ($data['onDutyOfficers'] as $officer): ?>
              <div class="officer-item">
                <span class="officer-name"><?php echo htmlspecialchars($officer->name); ?></span>
                <span class="officer-shift"><?php echo htmlspecialchars($officer->shift_name); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Charts Section -->
    <section class="section">
      <h2>Security Analytics</h2>
      <div class="chart-container">
        <div class="chart">
          <h3>Weekly Visitor Flow</h3>
          <canvas id="visitorFlowCanvas"></canvas>
        </div>
        <div class="chart">
          <h3>Monthly Incident Trends</h3>
          <canvas id="incidentTrendsCanvas"></canvas>
        </div>
      </div>
    </section>
  </div>
</div>

<?php require APPROOT . '/views/inc/components/footer.php'; ?>

<script>
  function initializeCharts() {
    // Weekly Visitor Flow Chart
    new Chart(document.getElementById('visitorFlowCanvas').getContext('2d'), {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($data['visitorFlow']['labels']); ?>,
        datasets: [{
          label: 'Visitor Passes',
          data: <?php echo json_encode($data['visitorFlow']['data']); ?>,
          backgroundColor: '#9b59b6',
          borderColor: '#8E44AD',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Passes'
            }
          }
        }
      }
    });

    // Monthly Incident Trends
    new Chart(document.getElementById('incidentTrendsCanvas').getContext('2d'), {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($data['incidentTrends']['labels']); ?>,
        datasets: [{
          label: 'Incidents',
          data: <?php echo json_encode($data['incidentTrends']['data']); ?>,
          backgroundColor: ['#8E44AD', '#9B59B6', '#A569BD', '#BB8FCE', '#D2B4DE'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Incidents'
            }
          }
        }
      }
    });

    // Mini Visitor Chart
    new Chart(document.getElementById('miniVisitorChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: <?php echo json_encode($data['miniVisitor']['labels']); ?>,
        datasets: [{
          data: <?php echo json_encode($data['miniVisitor']['data']); ?>,
          borderColor: '#6A5ACD',
          backgroundColor: 'rgba(106, 90, 205, 0.1)',
          fill: true,
          tension: 0.4,
          pointRadius: 0
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { display: false },
          y: { display: false }
        }
      }
    });

    // Mini Officer Chart
    new Chart(document.getElementById('miniOfficerChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($data['miniOfficer']['labels']); ?>,
        datasets: [{
          data: <?php echo json_encode($data['miniOfficer']['data']); ?>,
          backgroundColor: 'rgba(255,255,255,0.5)',
          borderColor: 'white',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { display: false },
          y: { display: false }
        }
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initializeCharts();

    // Optional: Auto-refresh basic metric data
    setInterval(() => {
      fetch('<?php echo URLROOT; ?>/security/getChartData')
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('active-passes').textContent = data.activePasses;
            document.getElementById('on-duty').textContent = data.onDuty;
          }
        });
    }, 300000); // every 5 mins
  });
</script>
</body>
</html>
