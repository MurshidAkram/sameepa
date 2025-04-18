<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Emergency_Contacts.css">
    <title>Manage Emergency Contacts | <?php echo SITENAME; ?></title>
</head>


<style>
/* --- Dashboard Container Styles --- */
.dashboard-container {
    display: flex;
    gap: 20px;
    padding: 20px;
    background-color: #f9fafc;
}

/* --- Side Panel Styles --- */
.side-panel {
    width: 250px;
    background: #2c3e50;
    border-radius: 10px;
    padding: 20px;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* --- Main Content Styles --- */
.main-content {
    flex: 1;
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
}

/* --- General Contact List Styles --- */
.contacts-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 20px;
}

/* --- Contact Card Styles --- */
.contact-card, .contact-item {
    background:rgb(170, 84, 204); /* Updated to #9b59b6 */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: white;
}

.contact-card:hover, .contact-item:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* --- Button Group Styles --- */
.button-group {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.button-group .btn {
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.button-group .call-btn {
    background-color: #4caf50;
    color: white;
}
.button-group .call-btn:hover {
    background-color: #388e3c;
}

.button-group .edit-btn {
    background-color: #2196f3;
    color: white;
}
.button-group .edit-btn:hover {
    background-color: #1976d2;
}

.button-group .delete-btn {
    background-color: #f44336;
    color: white;
}
.button-group .delete-btn:hover {
    background-color: #d32f2f;
}

/* --- Modal Styles --- */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.modal.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background:rgb(186, 57, 237); /* Updated to #9b59b6 */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 400px;
    text-align: center;
    color: #fff;
    animation: slide-in 0.4s ease;
}

.modal-content h2 {
    margin-bottom: 20px;
    font-size: 1.8rem;
    font-weight: bold;
}

.modal-content label {
    font-size: 1rem;
    margin-bottom: 10px;
    display: block;
    text-align: left;
    font-weight: 500;
}

.modal-content input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
    transition: border 0.3s ease;
}

.modal-content input:focus {
    border-color: #4caf50;
}

/* --- Modal Buttons --- */
.button-group .save-btn {
    background-color: blue;
    color: white;
}
.button-group .save-btn:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

.button-group .cancel-btn {  
    background-color: rgb(244, 65, 45);
    margin-left: 250px;
    color: white;
}
.button-group .cancel-btn:hover {
    background-color: rgb(100, 31, 23);
    transform: translateY(-2px);
}

/* --- Modal Animation --- */
@keyframes slide-in {
    from {
        transform: translateY(-30%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* --- Additional Card Styling --- */
.contact-card h3, .contact-item h3 {
    color: white;
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.contact-card p, .contact-item p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 10px;
    font-size: 0.95rem;
}

/* --- Responsive Adjustments --- */
@media (max-width: 768px) {
    .contacts-list {
        grid-template-columns: 1fr;
    }
    
    .modal-content {
        width: 90%;
    }
    
    .button-group .cancel-btn {
        margin-left: 0;
    }
}
</style>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <div class="main-content">
            <h1>Emergency Contacts</h1>

            <!-- Create New Contact Button
<button class="btn create-btn" onclick="openAddContactModal()">Create New Contact</button> -->

            <div class="contacts-list">
                <?php foreach ($data['contacts'] as $contacts) : ?>
                    <div class="contact-card" id="contact-<?php echo $contacts->id; ?>">
                        <h4><?php echo htmlspecialchars($contacts->name); ?></h4>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($contacts->phone); ?></p>
                        <div class="button-group">
                            <a href="tel:<?php echo htmlspecialchars($contacts->phone); ?>" class="btn call-btn">Call</a>
                            <button class="btn edit-btn" onclick="openEditModal(
                                '<?php echo htmlspecialchars($contacts->name); ?>', 
                                '<?php echo htmlspecialchars($contacts->phone); ?>', 
                                '<?php echo $contacts->id; ?>'
                            )">Edit</button>
                          
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Edit Contact Modal -->
    <div id="editContactModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editContactModal')">&times;</span>
            <h2>Edit Emergency Contact</h2>
            <form id="editContactForm" onsubmit="saveContactEdits(event)">
                <label for="editContactName">Name:</label>
                <input type="text" id="editContactName" required>

                <label for="editContactPhone">Phone:</label>
                <input type="text" id="editContactPhone" required>

                <input type="hidden" id="editContactId">

                <div class="button-group">
                    
                <button type="button" class="btn save-btn" onclick="saveContactEdits(event)">Save</button>
                    <button type="button" class="btn cancel-btn" onclick="closeModal('editContactModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>


//*****************************************EDIT PART ***************************************************** */
    // Open the modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    // Close the modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    // Open the edit modal with contact details
    function openEditModal(name, phone, id) {
        document.getElementById('editContactName').value = name;
        document.getElementById('editContactPhone').value = phone;
        document.getElementById('editContactId').value = id;
        openModal('editContactModal');
    }

    // Save edited contact
    function saveContactEdits(event) {
        event.preventDefault();
        const id = document.getElementById('editContactId').value;
        const name = document.getElementById('editContactName').value;
        const phone = document.getElementById('editContactPhone').value;

        // Prepare the data to send in the fetch request
        const data = {
            id: id,
            name: name,
            phone: phone
        };

        fetch(`<?php echo URLROOT; ?>/security/Edit_Contact/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Send the data as JSON
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the contact information in the UI
                document.getElementById(`contact-${id}`).innerHTML = `
                    <h4>${data.name}</h4>
                    <p><strong>Phone:</strong> ${data.phone}</p>
                    <div class="button-group">
                        <a href="tel:${data.phone}" class="btn call-btn">Call</a>
                        <button class="btn edit-btn" onclick="openEditModal('${data.name}', '${data.phone}', '${id}')">Edit</button>
                     
                    </div>
                `;
                closeModal('editContactModal');
            } else {
                alert('Failed to update contact');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the contact.');
        });
    }

</script>


</body>

</html>
