<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/complaints.css">
    <title>Complaints | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <div class="complaints-container">
                <div class="page-header">
                    <h1>My Complaints</h1>
                    <button id="newComplaintBtn" class="btn btn-primary">Create New Complaint</button>
                </div>

                <div class="complaints-list">
                    <div class="announcement-card complaint-card">
                        <div class="announcement-content">
                            <h2>Noise Disturbance</h2>
                            <div class="announcement-meta">
                                <span>Submitted: May 15, 2024</span>
                                <span class="complaint-status status-pending">Pending</span>
                            </div>
                            <div class="announcement-preview">
                                Continuous loud music from neighbors affecting sleep.
                            </div>
                            <div class="announcement-actions">
                                <button class="btn-react view-details-btn">View Details</button>
                            </div>
                        </div>
                    </div>

                    <div class="announcement-card complaint-card">
                        <div class="announcement-content">
                            <h2>Maintenance Request</h2>
                            <div class="announcement-meta">
                                <span>Submitted: April 22, 2024</span>
                                <span class="complaint-status status-resolved">Resolved</span>
                            </div>
                            <div class="announcement-preview">
                                Leaking tap in kitchen needs repair.
                            </div>
                            <div class="announcement-actions">
                                <button class="btn-react view-details-btn">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals -->
    <div id="complaintModal" class="modal">
        <div class="modal-content create-announcement-container">
            <div class="page-header">
                <h1>Create New Complaint</h1>
                <button class="close-modal btn btn-cancel">&times;</button>
            </div>
            <form class="announcement-form">
                <div class="form-group">
                    <label>Complaint Title</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-cancel close-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Complaint</button>
                </div>
            </form>
        </div>
    </div>

    <div id="detailsModal" class="modal">
        <div class="modal-content create-announcement-container">
            <div class="page-header">
                <h1>Complaint Details</h1>
                <button class="close-modal btn btn-cancel">&times;</button>
            </div>
            <div class="complaint-details">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="complaintDetailsTitle" readonly>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" id="complaintStatus" readonly>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="complaintFullDescription" readonly></textarea>
                </div>
                <div class="form-group">
                    <label>Admin Response</label>
                    <textarea class="form-control" id="adminResponseText" readonly></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-cancel close-modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const newComplaintBtn = document.getElementById('newComplaintBtn');
            const complaintModal = document.getElementById('complaintModal');
            const detailsModal = document.getElementById('detailsModal');
            const closeModalBtns = document.querySelectorAll('.close-modal');
            const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
            const complaintForm = complaintModal.querySelector('form');

            // Open new complaint modal
            newComplaintBtn.addEventListener('click', () => {
                complaintModal.style.display = 'block';
            });

            // Close modals
            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    complaintModal.style.display = 'none';
                    detailsModal.style.display = 'none';
                });
            });

            // View complaint details
            viewDetailsBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const complaintCard = e.target.closest('.complaint-card');
                    const title = complaintCard.querySelector('h2').textContent;
                    const description = complaintCard.querySelector('.announcement-preview').textContent;
                    const status = complaintCard.querySelector('.complaint-status').textContent;

                    document.getElementById('complaintDetailsTitle').value = title;
                    document.getElementById('complaintFullDescription').textContent = description.trim();
                    document.getElementById('complaintStatus').value = status;

                    detailsModal.style.display = 'block';
                });
            });

            // Submit complaint form
            complaintForm.addEventListener('submit', (e) => {
                e.preventDefault();
                // Add form submission logic here
                complaintModal.style.display = 'none';
                complaintForm.reset();
            });

            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target == complaintModal) {
                    complaintModal.style.display = 'none';
                }
                if (e.target == detailsModal) {
                    detailsModal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>