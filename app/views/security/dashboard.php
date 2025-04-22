<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Security Dashboard | <?php echo SITENAME; ?></title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
  .dashboard-container {
  display: flex;
  padding-bottom: 20px;
  padding: 15px;
  gap: 15px;
  
}

.padding{
  padding-bottom: 40px;
}

.main-content {
  width: 90%;
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
}

/* Force one card per row */
.compact-grid {
  display: flex;
  flex-direction: column;
  gap: 20px;
  width: 90%;
  align-items: center;
}

/* Card appearance */
.compact-card {
  background: #ffffff;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  width: 95%;
  max-width: 95%;
  overflow: hidden;
}

.compact-card h3 {
  font-size: 1.1em;
  margin: 0 0 10px 0;
  color: #333;
}

.metric-value {
  font-size: 3.5em;
  font-weight: bold;
  color: #6A5ACD;
  margin: 5px 0;
}

.mini-chart-container {
  height: 70px;
  margin-top: 10px;
}

/* Table inside cards - UPDATED */
.compact-table {
  width: 90%;
  font-size: 0.85em;
  border-collapse: collapse;
  margin-top: 10px;
}

.compact-table th {
  background-color: #9b59b6; /* Purple header */
  color: white;
  padding: 8px;
  text-align: left;
  font-weight: 500;
}

.compact-table td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #eee;
  transition: all 0.2s ease; /* Smooth hover transition */
}

.compact-table tr:hover td {
  background-color: #f5e6ff; /* White-violet hover color */
  cursor: pointer;
}

/* Chart container style */
.compact-chart {
  background: white;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  height: 260px;
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
}

.compact-chart h3 {
  font-size: 1em;
  margin: 0 0 10px 0;
  text-align: center;
}

/* Color themes */
.visitor-card { border-left: 4px solid #9b59b6; }
.officer-card { border-left: 4px solid #3498db; }
.incident-card { border-left: 4px solid #e74c3c; }

/* Additional improvements */
.compact-table th:first-child {
  border-top-left-radius: 4px;
}

.compact-table th:last-child {
  border-top-right-radius: 4px;
}

.compact-table tr:last-child td {
  border-bottom: none;
}
  </style>
</head>
<body>
<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

<div class="dashboard-container">
  <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

  <div class="main-content">
    <h2>Security Dashboard</h2>
    
    <div class="compact-grid">
      <!-- Visitor Card -->
      <div class="compact-card visitor-card">
        <h3>Today's Visitors</h3>
        <div class="metric-value" id="active-passes"><?php echo count($data['todayPasses']); ?></div>
        <p>Passes issued today</p>
    
        <table class="compact-table">
          <thead>
            <tr>
              <th>Visitor</th>
              <th>Resident</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($data['todayPasses'])) : ?>
              <?php foreach (array_slice($data['todayPasses'], 0, 100) as $pass) : ?>
                <tr>
                  <td><?php echo htmlspecialchars($pass->visitor_name); ?></td>
                  <td><?php echo htmlspecialchars($pass->resident_name); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php if (count($data['todayPasses']) > 3) : ?>
               
              <?php endif; ?>
            <?php else : ?>
              <tr><td colspan="2">None today</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Officers Card -->
      <div class="compact-card officer-card">
        <h3>On Duty Officers</h3>
        <div class="metric-value" id="on-duty"><?php echo count($data['onDutyOfficers']); ?></div>
        <p>Currently active</p>
        
        
        <table class="compact-table">
          <tbody>
            <?php foreach (array_slice($data['onDutyOfficers'], 0, 20) as $officer): ?>
              <tr>
                <td><?php echo htmlspecialchars($officer->name); ?></td>
                <td><?php echo htmlspecialchars($officer->shift_name); ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (count($data['onDutyOfficers']) > 5) : ?>
             
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Incidents Card -->
      <div class="compact-card incident-card" style="position: relative;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <div>
      <h3>Monthly Incidents</h3>
      <?php if (!empty($data['incidentTrends']['data'])): ?>
        <div class="metric-value"><?php echo array_sum($data['incidentTrends']['data']); ?></div>
        <p>Total this month</p>
      <?php else: ?>
        <div class="metric-value">0</div>
        <p>No incidents</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Large Pie Chart (5x size) -->
  <div style="width: 100%; height: 200px; margin: 10px 0;">
    <canvas id="largeIncidentPieChart"></canvas>
  </div>

  <table class="compact-table">
    <thead>
      <tr>
        <th>Type</th>
        <th>Count</th>
        <th>%</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $total = array_sum($data['incidentTrends']['data']);
      foreach (array_slice($data['incidentTrends']['labels'], 0, 100) as $index => $type): 
        $percentage = $total > 0 ? round(($data['incidentTrends']['data'][$index] / $total) * 100, 1) : 0;
      ?>
        <tr>
          <td><?php echo htmlspecialchars($type); ?></td>
          <td><?php echo $data['incidentTrends']['data'][$index]; ?></td>
          <td><?php echo $percentage; ?>%</td>
        </tr>
      <?php endforeach; ?>
      <?php if (count($data['incidentTrends']['labels']) > 5): ?>
      
      <?php endif; ?>
    </tbody>
  </table>
</div>
    </div>

    <!-- Compact Charts Row -->
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
      <div class="compact-chart">
        <h3>Weekly Visitors</h3>
        <canvas id="visitorFlowCanvas" style="height: 250px;"></canvas>
      </div>
      
      <div class="compact-chart">
        <h3>Incident Types</h3>
        <canvas id="incidentTrendsCanvas" style="height: 250px;"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="padding">

</div>
<?php require APPROOT . '/views/inc/components/footer.php'; ?>



<script>
// Initialize all charts
function initializeCharts() {
  // Weekly Visitor Flow - Small bar chart
  new Chart(document.getElementById('visitorFlowCanvas').getContext('2d'), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($data['visitorFlow']['labels']); ?>,
      datasets: [{
        data: <?php echo json_encode($data['visitorFlow']['data']); ?>,
        backgroundColor: '#9b59b6',
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { stepSize: 1 } }
      }
    }
  });

  // Incident Trends - Small horizontal bar chart
  new Chart(document.getElementById('incidentTrendsCanvas').getContext('2d'), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($data['incidentTrends']['labels']); ?>,
      datasets: [{
        data: <?php echo json_encode($data['incidentTrends']['data']); ?>,
        backgroundColor: '#e74c3c'
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { beginAtZero: true }
      }
    }
  });

  // Mini Visitor Chart - Tiny line chart
  const visitorCountByHour = calculateVisitorCountByHour(<?php echo json_encode($data['todayPasses']); ?>);
  new Chart(document.getElementById('miniVisitorChart').getContext('2d'), {
    type: 'line',
    data: {
      labels: visitorCountByHour.labels,
      datasets: [{
        data: visitorCountByHour.data,
        borderColor: '#9b59b6',
        borderWidth: 1,
        fill: false,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { x: { display: false }, y: { display: false } }
    }
  });

  // Mini Officer Chart - Tiny bar chart
  new Chart(document.getElementById('miniOfficerChart').getContext('2d'), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($data['miniOfficer']['labels']); ?>,
      datasets: [{
        data: <?php echo json_encode($data['miniOfficer']['data']); ?>,
        backgroundColor: '#3498db'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { x: { display: false }, y: { display: false } }
    }
  });

  // Mini Incident Chart - Tiny doughnut chart
  new Chart(document.getElementById('miniIncidentChart').getContext('2d'), {
    type: 'doughnut',
    data: {
      labels: <?php echo json_encode($data['incidentTrends']['labels']); ?>,
      datasets: [{
        data: <?php echo json_encode($data['incidentTrends']['data']); ?>,
        backgroundColor: ['#e74c3c', '#f39c12', '#2ecc71']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      cutout: '70%'
    }
  });
}

// Helper function to calculate visitor count by hour
function calculateVisitorCountByHour(passes) {
  const hours = Array.from({length: 24}, (_, i) => i);
  const counts = Array(24).fill(0);
  
  passes.forEach(pass => {
    if (pass.visit_time) {
      const hour = new Date('1970-01-01T' + pass.visit_time).getHours();
      counts[hour]++;
    }
  });
  
  return {
    labels: hours.map(h => h + ':00'),
    data: counts
  };
}

document.addEventListener('DOMContentLoaded', initializeCharts);
// Initialize the large pie chart (5x size)
document.addEventListener('DOMContentLoaded', function() {
  const ctx = document.getElementById('largeIncidentPieChart').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($data['incidentTrends']['labels']); ?>,
      datasets: [{
        data: <?php echo json_encode($data['incidentTrends']['data']); ?>,
        backgroundColor: [
          '#e74c3c', '#f39c12', '#2ecc71', '#3498db', '#9b59b6',
          '#1abc9c', '#d35400', '#34495e', '#7f8c8d', '#c0392b',
          '#e67e22', '#27ae60', '#2980b9', '#8e44ad', '#16a085'
        ],
        borderWidth: 1,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            boxWidth: 12,
            padding: 10,
            font: {
              size: 10
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = Math.round((context.raw / total) * 100);
              return `${context.label}: ${context.raw} (${percentage}%)`;
            }
          }
        }
      },
      cutout: '50%',
      animation: {
        animateScale: true,
        animateRotate: true
      }
    }
  });
});

</script>
</body>
</html>