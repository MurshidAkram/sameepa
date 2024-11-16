<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/facilities.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/facility_view.css">
    <title>Facilities | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
        // Load appropriate side panel based on user role
        switch($_SESSION['user_role_id']) {
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
        <main class="facilities-main">
            <h1>Facility Management</h1>
            <div class="action-buttons">
                <?php if($_SESSION['user_role_id'] == 2): ?>
                    <a href="<?php echo URLROOT; ?>/facilities/create" class="btn-create">Create New Facility</a>
                    <a href="<?php echo URLROOT; ?>/facilities/allbookings" class="btn-admin-bookings">All Bookings</a>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/facilities/allmybookings" class="btn-bookings">My Bookings</a>
            </div>
                                    
            <div class="facilities-grid">
                <?php foreach($data['facilities'] as $facility): ?>
                    <div class="facility-card">
                        <h3><?php echo $facility->name; ?></h3>
                        <p><?php echo $facility->description; ?></p>
                        <div class="facility-details">
                            <span><i class="fas fa-users"></i> Capacity: <?php echo $facility->capacity; ?></span>
                            <span><i class="fas fa-info-circle"></i> Status: <?php echo $facility->status; ?></span>
                        </div>
                        <div class="facility-actions">
                            <button onclick="viewFacility(<?php echo $facility->id; ?>)" class="btn-view">View</button>
                            <a href="<?php echo URLROOT; ?>/facilities/book/<?php echo $facility->id; ?>/<?php echo urlencode($facility->name); ?>" class="btn-book">Book</a>
                            <?php if($_SESSION['user_role_id'] == 2): ?>
                                <form action="<?php echo URLROOT; ?>/facilities/delete/<?php echo $facility->id; ?>" method="POST" style="display: inline;">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this facility?')">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
              <!-- Modal -->
              <div id="facilityModal" class="modal">
                  <div class="modal-content">
                      <span class="close">×</span>
                      <div class="facility-details-section">
                          <h1 id="facilityTitle"></h1>
                          <div class="facility-meta">
                              <div class="meta-item">
                                  <i class="fas fa-users"></i>
                                  <span id="facilityCapacity"></span>
                              </div>
                              <div class="meta-item">
                                  <i class="fas fa-info-circle"></i>
                                  <span id="facilityStatus"></span>
                              </div>
                          </div>
                          <div class="facility-description">
                              <h2>About This Facility</h2>
                              <p id="facilityDescription"></p>
                          </div>
                        
                          <!-- Add Edit Form Section -->
                          <div id="editFormSection" style="display: none;">
                              <h2>Edit Facility</h2>
                              <form id="editFacilityForm">
                                  <input type="hidden" id="editFacilityId">
                                  <div class="form-group">
                                      <label for="editName">Facility Name</label>
                                      <input type="text" id="editName" name="name" required>
                                  </div>
                                
                                  <div class="form-group">
                                      <label for="editDescription">Description</label>
                                      <textarea id="editDescription" name="description" required></textarea>
                                  </div>
                                
                                  <div class="form-group">
                                      <label for="editCapacity">Capacity</label>
                                      <input type="number" id="editCapacity" name="capacity" required>
                                  </div>
                                
                                  <div class="form-group">
                                      <label for="editStatus">Status</label>
                                      <select id="editStatus" name="status">
                                          <option value="Available">Available</option>
                                          <option value="Unavailable">Unavailable</option>
                                      </select>
                                  </div>
                                
                                  <button type="submit" class="btn-submit">Update Facility</button>
                              </form>
                          </div>

                          <?php if($_SESSION['user_role_id'] == 2): ?>
                              <button id="toggleEditBtn" class="btn-edit">Edit Facility</button>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
          </main>
      </div>

      <?php require APPROOT . '/views/inc/components/footer.php'; ?>

      <script>
          const modal = document.getElementById('facilityModal');
          const closeBtn = document.getElementsByClassName('close')[0];
          const editFormSection = document.getElementById('editFormSection');
          const toggleEditBtn = document.getElementById('toggleEditBtn');
          const editFacilityForm = document.getElementById('editFacilityForm');

          async function viewFacility(id) {
              try {
                  const response = await fetch(`<?php echo URLROOT; ?>/facilities/getFacilityData/${id}`);
                  const facility = await response.json();
                
                  document.getElementById('facilityTitle').textContent = facility.name;
                  document.getElementById('facilityCapacity').textContent = `Capacity: ${facility.capacity}`;
                  document.getElementById('facilityStatus').textContent = `Status: ${facility.status}`;
                  document.getElementById('facilityDescription').textContent = facility.description;
                
                  // Populate edit form
                  document.getElementById('editFacilityId').value = facility.id;
                  document.getElementById('editName').value = facility.name;
                  document.getElementById('editDescription').value = facility.description;
                  document.getElementById('editCapacity').value = facility.capacity;
                  document.getElementById('editStatus').value = facility.status;
                
                  modal.style.display = 'block';
              } catch (error) {
                  console.error('Error:', error);
              }
          }

          closeBtn.onclick = function() {
              modal.style.display = 'none';
          }

          window.onclick = function(event) {
              if (event.target == modal) {
                  modal.style.display = 'none';
              }
          }

          toggleEditBtn.onclick = function() {
              const viewContent = document.querySelector('.facility-details-section');
              if (editFormSection.style.display === 'none') {
                  editFormSection.style.display = 'block';
                  toggleEditBtn.textContent = 'Cancel Edit';
              } else {
                  editFormSection.style.display = 'none';
                  toggleEditBtn.textContent = 'Edit Facility';
              }
          }

          editFacilityForm.onsubmit = async function(e) {
              e.preventDefault();
              const facilityId = document.getElementById('editFacilityId').value;
            
              const formData = {
                  name: document.getElementById('editName').value,
                  description: document.getElementById('editDescription').value,
                  capacity: document.getElementById('editCapacity').value,
                  status: document.getElementById('editStatus').value
              };

              try {
                  const response = await fetch(`<?php echo URLROOT; ?>/facilities/edit/${facilityId}`, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json'
                      },
                      body: JSON.stringify(formData)
                  });

                  if (response.ok) {
                      window.location.reload();
                  }
              } catch (error) {
                  console.error('Error:', error);
              }
          }
      </script>
  </body>
  </html>

