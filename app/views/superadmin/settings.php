<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/settings.css">
    <title>Super Admin Settings | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>
        <main>
            <h1 >Settings</h1>

            <!-- System Settings -->
            <section class="settings-section">
                <h2>System Settings</h2>
                <div class="setting-option">
                    <label>Community Policies:</label>
                    <button class="btn-settings" onclick="openModal('policiesModal')">Manage Policies</button>
                </div>
                <div class="setting-option">
                    <label>Notification Preferences:</label>
                    <button class="btn-settings" onclick="openModal('notificationModal')">Manage Notifications</button>
                </div>
                <div class="setting-option">
                    <label>Security Settings:</label>
                    <button class="btn-settings" onclick="openModal('securityModal')">Security Settings</button>
                </div>
            </section>

            <!-- Customization Settings -->
            <section class="settings-section">
                <h2>Customization</h2>
                <div class="setting-option">
                    <label>Community Branding:</label>
                    <button class="btn-settings" onclick="openModal('brandingModal')">Manage Branding & Theme</button>
                </div>
                <div class="setting-option">
                    <label>Language:</label>
                    <button class="btn-settings" onclick="openModal('languageModal')">Language Settings</button>
                </div>
            </section>

            <!-- Communication Settings -->
            <section class="settings-section">
                <h2>Communication Settings</h2>
                <div class="setting-option">
                    <label>Email Setup:</label>
                    <button class="btn-settings" onclick="openModal('emailSetupModal')">Manage Email Settings</button>
                </div>
                <div class="setting-option">
                    <label>SMS Configuration:</label>
                    <button class="btn-settings" onclick="openModal('smsConfigModal')">Manage SMS Settings</button>
                </div>
            </section>

            <!-- Advanced Settings -->
            <section class="settings-section">
                <h2>Advanced Settings</h2>
                <div class="setting-option">
                    <label>Audit Logs:</label>
                    <button class="btn-settings" onclick="openModal('auditLogsModal')">View Audit Logs</button>
                </div>
                <div class="setting-option">
                    <label>Data Backup & Restore:</label>
                    <button class="btn-settings" onclick="openModal('backupRestoreModal')">Backup & Restore</button>
                </div>
            </section>

            <!-- Modals -->
            <div id="policiesModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('policiesModal')">&times;</span>
                    <h2>Manage Community Policies</h2>
                    <p>Update community rules and guidelines.</p>
                    <button class="btn-action2">Save Policies</button>
                </div>
            </div>

            <div id="notificationModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('notificationModal')">&times;</span>
                    <h2>Manage Notification Preferences</h2>
                    <p>Set notification preferences for residents and staff.</p>
                    <button class="btn-action2">Save Notifications</button>
                </div>
            </div>

            <div id="securityModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('securityModal')">&times;</span>
                    <h2>Security Settings</h2>
                    <p>Manage security features, including user access levels.</p>
                    <button class="btn-action2">Save Security Settings</button>
                </div>
            </div>

            <div id="brandingModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('brandingModal')">&times;</span>
                    <h2>Manage Community Branding & Theme</h2>
                    <p>Customize the platform's branding and appearance.</p>
                    <button class="btn-action2">Save Branding</button>
                </div>
            </div>

            <div id="languageModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('languageModal')">&times;</span>
                    <h2>Language Settings</h2>
                    <p>Manage available languages for the platform.</p>
                    <button class="btn-action2">Save Language Settings</button>
                </div>
            </div>

            <div id="emailSetupModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('emailSetupModal')">&times;</span>
                    <h2>Email & Notification Setup</h2>
                    <p>Configure email server settings and notifications.</p>
                    <button class="btn-action2">Save Email Settings</button>
                </div>
            </div>

            <div id="smsConfigModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('smsConfigModal')">&times;</span>
                    <h2>SMS Gateway Configuration</h2>
                    <p>Configure SMS gateway for sending community alerts.</p>
                    <button class="btn-action2">Save SMS Settings</button>
                </div>
            </div>

            <div id="auditLogsModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('auditLogsModal')">&times;</span>
                    <h2>View Audit Logs</h2>
                    <p>Review system activity logs.</p>
                    <button class="btn-action2">Close</button>
                </div>
            </div>

            <div id="backupRestoreModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('backupRestoreModal')">&times;</span>
                    <h2>Data Backup & Restore</h2>
                    <p>Backup and restore system data.</p>
                    <button class="btn-action2">Perform Backup</button>
                </div>
            </div>

        </main>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    </script>

</body>

</html>
