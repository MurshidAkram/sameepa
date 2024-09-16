<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/settings.css">
    <title>Super Admin Settings | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <h1>Super Admin Settings</h1>

            <!-- System Settings -->
            <section class="settings-section">
                <h2>System Settings</h2>
                <div class="setting-option">
                    <label>Communication:</label>
                    <button class="btn-settings" onclick="openModal('communicationModal')">Email & Notifications</button>
                </div>
                <div class="setting-option">
                    <label>Backup & Restore:</label>
                    <button class="btn-settings" onclick="openModal('backupRestoreModal')">Backup & Restore</button>
                </div>
                <div class="setting-option">
                    <label>Logs & Reports:</label>
                    <button class="btn-settings" onclick="openModal('logsReportsModal')">View Logs & Reports</button>
                </div>
            </section>

            <!-- Customization -->
            <section class="settings-section">
                <h2>Customization</h2>
                <div class="setting-option">
                    <label>Branding:</label>
                    <button class="btn-settings" onclick="openModal('brandingModal')">Manage Branding & Theme</button>
                </div>
                <div class="setting-option">
                    <label>Language:</label>
                    <button class="btn-settings" onclick="openModal('languageModal')">Language Settings</button>
                </div>
            </section>

            <!-- Popups -->
           <!-- Communication Modal -->
<div id="communicationModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <span class="close" onclick="closeModal('communicationModal')" tabindex="0">&times;</span>
        <h2>Email & Notifications</h2>
        <p>Configure how the system handles communication. Set up email servers, notification preferences, and automated messaging rules.</p>
        <ul>
            <li><strong>Email Server:</strong> Configure the outgoing email server (SMTP) settings.</li>
            <li><strong>Notification Preferences:</strong> Choose which events trigger email or SMS notifications to users and admins.</li>
            <li><strong>Autoresponders:</strong> Set automated replies for specific user interactions like registration or support tickets.</li>
        </ul>
        <button class="btn-settings">Save Settings</button>
    </div>
</div>

<!-- Backup & Restore Modal -->
<div id="backupRestoreModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <span class="close" onclick="closeModal('backupRestoreModal')" tabindex="0">&times;</span>
        <h2>Backup & Restore</h2>
        <p>Manage system backups to ensure data security and recovery. Schedule automatic backups or perform manual backups.</p>
        <ul>
            <li><strong>Backup Now:</strong> Perform an immediate backup of the system data.</li>
            <li><strong>Schedule Backups:</strong> Set a regular backup schedule (e.g., daily, weekly).</li>
            <li><strong>Restore Data:</strong> Select a backup file to restore system data to a previous state.</li>
        </ul>
        <button class="btn-settings">Perform Backup</button>
    </div>
</div>

<!-- Logs & Reports Modal -->
<div id="logsReportsModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <span class="close" onclick="closeModal('logsReportsModal')" tabindex="0">&times;</span>
        <h2>Logs & Reports</h2>
        <p>View system logs and generate reports to track user activities, system events, and more. Useful for monitoring and troubleshooting.</p>
        <ul>
            <li><strong>Activity Logs:</strong> View logs of user actions, including login attempts, data changes, and system interactions.</li>
            <li><strong>Error Logs:</strong> Check logs for system errors and warnings.</li>
            <li><strong>Generate Reports:</strong> Create detailed reports for system performance, user engagement, and other metrics.</li>
        </ul>
        <button class="btn-settings">Generate Report</button>
    </div>
</div>

<!-- Branding Modal -->
<div id="brandingModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <span class="close" onclick="closeModal('brandingModal')" tabindex="0">&times;</span>
        <h2>Manage Branding & Theme</h2>
        <p>Customize the platform's look and feel to align with your organization's branding. Update logos, colors, and themes.</p>
        <ul>
            <li><strong>Logo:</strong> Upload your organization's logo for display across the platform.</li>
            <li><strong>Color Scheme:</strong> Choose a primary color scheme that matches your brand identity.</li>
            <li><strong>Theme:</strong> Select from light or dark themes or create a custom theme for your users.</li>
        </ul>
        <button class="btn-settings">Save Branding</button>
    </div>
</div>

<!-- Language Modal -->
<div id="languageModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <span class="close" onclick="closeModal('languageModal')" tabindex="0">&times;</span>
        <h2>Language Settings</h2>
        <p>Set the platform's default language and configure multi-language support for users.</p>
        <ul>
            <li><strong>Default Language:</strong> Set the primary language for the system.</li>
            <li><strong>Available Languages:</strong> Enable other languages for users to choose from.</li>
            <li><strong>Translation Management:</strong> Upload or edit translations for the platform's content.</li>
        </ul>
        <button class="btn-settings">Save Language Settings</button>
    </div>
</div>

            <!-- Add more modals for the other buttons as needed -->
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript for opening and closing modals -->
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'block';
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        // Close modal with escape key for accessibility
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.modal').forEach(modal => {
                    if (modal.style.display === 'block') {
                        modal.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>

</html>
