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
   
}

/* --- Side Panel Styles --- */
.side-panel {
    width: 250px;
    position: fixed;
    height: 100vh;
    background: #2c3e50;
    color: white;
    padding: 20px;
    overflow-y: auto;
    border-radius: 10px 0 0 10px;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    z-index: 100;
}

/* --- Main Content Styles --- */
.main-content {
    flex: 1;
    
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
   
}

/* --- Contact List & Cards --- */
.contacts-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.contact-card, .contact-item {
    background: rgb(170, 84, 204);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: left;
    color: white;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-card:hover, .contact-item:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.contact-card h3, .contact-item h3 {
    color: white;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.contact-card p, .contact-item p {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 10px;
}

/* --- Button Group --- */
.button-group {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.button-group .btn {
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 0.9rem;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
}

.call-btn {
    background-color: #4caf50;
    color: white;
}
.call-btn:hover {
    background-color: #388e3c;
}

.edit-btn {
    background-color: #2196f3;
    color: white;
}
.edit-btn:hover {
    background-color: #1976d2;
}

/* --- Modal Styles --- */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.modal.active {
    display: flex;
}

/* --- Modal Content --- */
.modal-content {
    background: rgb(186, 57, 237);
    padding: 30px;
    border-radius: 12px;
   
    width: 90%;
    max-width: 500px;
    color: #fff;
    
}

.modal-content h3, .modal-content h2 {
    margin-bottom: 20px;
    font-size: 1.8rem;
    font-weight: bold;
    text-align: center;
}

.modal-content .close {
    font-size: 2.5rem;
    cursor: pointer;
    color: rgb(0, 0, 0);
    float: right;
    line-height: 1;
    margin-top: -10px;
    transition: color 0.3s ease;
}
.modal-content .close:hover {
    color: #6c5ce7;
}

.modal-content form {
    display: flex;
    flex-direction: column;
}
.modal-content .form-group {
    margin-bottom: 15px;
}
.modal-content label {
    
    margin-bottom: 5px;
    color: white;
    text-align: left;
}
.modal-content input,
.modal-content select,
.modal-content textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    background-color: #f6e4f7;
    color: #333;
}
.modal-content input:focus,
.modal-content select:focus,
.modal-content textarea:focus {
    outline: none;
    border-color: #e8c8e3;
    box-shadow: 0 0 5px rgba(232, 200, 227, 0.5);
}
.modal-content input:disabled,
.modal-content select:disabled,
.modal-content textarea:disabled {
    background-color: #e9e9e9;
    color: #666;
}
.modal-content textarea {
    resize: vertical;
    min-height: 100px;
}

/* --- Modal Button Group --- */
.modal-content .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}
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

/* --- Responsive Adjustments --- */
@media (max-width: 768px) {
    .contacts-list {
        grid-template-columns: 1fr;
    }
    .modal-content {
        width: 90%;
    }
   
}
.btn.save-btn {
    background-color: #450d8f; /* Medium Violet */
    color: #fff;
    border: none;
    padding: 12px;
    width: 95%;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.save-btn:hover {
    background-color:rgb(96, 17, 85); /* Slightly darker shade on hover */
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
        <span class="close" onclick="closeModal('editContactModal')">&times;</span>
        <h3>Edit Emergency Contact</h3>
        <form id="editContactForm" onsubmit="saveContactEdits(event)">
            <div class="form-group">
                <label for="editContactName">Name:</label>
                <input type="text" id="editContactName" required>
            </div>
            
            <div class="form-group">
                <label for="editContactPhone">Phone:</label>
                <input type="text" id="editContactPhone" required>
            </div>
            
            <input type="hidden" id="editContactId">
            
            <div class="form-actions">
               
                <button type="submit" class="btn save-btn" onclick="saveContactEdits(event)">Save</button>
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
