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

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
        
            <div class="contacts-list-container">
              <!-- Emergency Contact Cards -->
                  <div>
                  <div class="contact-item" id="contact-1">
                        <h4>Police Emergency Hotline</h4>
                        <p>Phone: 119</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Police Emergency Hotline', '119', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                    <div class="contact-item" id="contact-1">
                        <h4>Ambulance Service</h4>
                        <p>Phone: 1990</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Ambulance Service', '1990', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                          
                    <div class="contact-item" id="contact-1">
                        <h4>Fire Brigade</h4>
                        <p>Phone: 110</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Fire Brigade', '110', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                  </div>
                    

                  <div>
                  <div class="contact-item" id="contact-1">
                        <h4>Child Protection Authority</h4>
                        <p>Phone: 1929</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Child Protection Authority', '1929', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>

                    <div class="contact-item" id="contact-1">
                        <h4>Tourist Police</h4>
                        <p>Phone: 1912</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Tourist Police', '1912', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                    <div class="contact-item" id="contact-1">
                        <h4>Electricity Breakdown Service</h4>
                        <p>Phone: 1987</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Electricity Breakdown Service', '1987', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                    
                  </div>
                   
                </div>
            </div>
        </main>
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
                <button type="submit" class="btn save-btn">Save</button>
                <button type="button" class="btn cancel-btn" onclick="closeModal('editContactModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>



    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
    // Open the modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('active');   // Show the modal
    }

    // Close the modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('active'); // Hide the modal
    }

    // Submit the incident form
    function submitIncidentForm() {
        // Collect the form data
        var type = document.getElementById("incident_type").value;
        var date = document.getElementById("incident_date").value;
        var time = document.getElementById("incident_time").value;
        var description = document.getElementById("incident_description").value;

        // Assuming you'd handle the submission to the backend here

        alert("Incident Report Submitted!");
        cancelIncidentForm(); // Close the form after submission
    }

    // Cancel the incident form
    function cancelIncidentForm() {
        document.getElementById("incidentForm").style.display = "none";
    }

    // Create a new contact
    function createContact(event) {
        event.preventDefault();
        const name = document.getElementById('newContactName').value;
        const phone = document.getElementById('newContactPhone').value;

        const id = `contact-${Date.now()}`;
        const contactList = document.querySelector('.contacts-list');
        const newContactHTML = `
            <div class="contact-item" id="${id}">
                <h4>${name}</h4>
                <p>Phone: ${phone}</p>
                <button class="btn call-btn">Hotline</button>
                <button class="btn message-btn">Message</button>
                <button class="btn edit-btn" onclick="openEditModal('${name}', '${phone}', '${id}')">Edit</button>
                <button class="btn delete-btn" onclick="deleteContact('${id}')">Delete</button>
            </div>
        `;
        contactList.insertAdjacentHTML('beforeend', newContactHTML);
        closeModal('newContactModal');
    }

    // Open the edit modal with the contact details
    function openEditModal(name, phone, id) {
        document.getElementById('editContactName').value = name;
        document.getElementById('editContactPhone').value = phone;
        document.getElementById('editContactId').value = id;
        openModal('editContactModal');
    }

    // Save the contact edits
    function saveContactEdits(event) {
        event.preventDefault();  // Prevent form from submitting

        const id = document.getElementById('editContactId').value;
        const name = document.getElementById('editContactName').value;
        const phone = document.getElementById('editContactPhone').value;
       

        const contact = document.getElementById(id);
        contact.innerHTML = `
            <h4>${name}</h4>
            <p>Phone: ${phone}</p>
            <button class="btn call-btn">Hotline</button>
            <button class="btn message-btn">Message</button>
            <button class="btn edit-btn" onclick="openEditModal('${name}', '${phone}', '${id}')">Edit</button>
            <button class="btn delete-btn" onclick="deleteContact('${id}')">Delete</button>
        `;
        closeModal('editContactModal');
    }

    // Delete a contact
    function deleteContact(id) {
        const contact = document.getElementById(id);
        contact.remove();
    }

    // Optional: Open the modal with an "Edit Contact" button
    document.getElementById('openModalButton').addEventListener('click', () => {
        openModal('editContactModal');
    });
</script>

    <style>
        /* Styles for modals */
.contact-item {
    padding: 20px;
    margin: 15px;
    border-radius: 12px;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-item h4 {
    margin: 0 0 10px;
    font-size: 1.5rem;
}

.contact-item p {
    margin: 5px 0;
    font-size: 1rem;
}

/* Specific Styles for Each Card */
#contact-1 {
    background: linear-gradient(135deg, #3498db, #2ecc71);
}

#contact-2 {
    background: linear-gradient(135deg, #e74c3c, #e67e22);
}

#contact-3 {
    background: linear-gradient(135deg, #8e44ad, #3498db);
}

#contact-4 {
    background: linear-gradient(135deg, #f1c40f, #e67e22);
}

/* Button Styles */
.contact-item .btn {
    margin: 5px;
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    color: white;
    transition: background-color 0.3s ease;
}

.contact-item .call-btn {
    background-color: #27ae60;
}

.contact-item .call-btn:hover {
    background-color: #2ecc71;
}

.contact-item .message-btn {
    background-color: #2980b9;
}

.contact-item .message-btn:hover {
    background-color: #3498db;
}

.contact-item .edit-btn {
    background-color: #f39c12;
}

.contact-item .edit-btn:hover {
    background-color: #e67e22;
}

.contact-item .delete-btn {
    background-color: #e74c3c;
}

.contact-item .delete-btn:hover {
    background-color: #c0392b;
}

/* Hover Effect for Cards */
.contact-item:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3);
}

        .dashboard-container{
                  display:flex;
                  

        }
        .contacts-list-container {

            justify-content: space-between;
            display:flex;
    padding: 20px;
    background-color: #ffffff; /* White background for a clean look */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    border-radius: 12px; /* Rounded corners for a modern feel */
    margin-left:20px; /* Adds space around the container */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effects */
    width: 100%;
}


        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
        .modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Dark overlay for background */
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
    background: linear-gradient(135deg, red, yellow); /* Gradient background */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Elevated shadow */
    width: 400px;
    text-align: center;
    color: #fff; /* White text for contrast */
    animation: slide-in 0.4s ease; /* Subtle entry animation */
}

.modal-content h2 {
    margin-bottom: 20px;
    font-size: 1.8rem;
    font-weight: bold;
    color: #fff;
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
    border-color: #4caf50; /* Highlight border on focus */
}

.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.modal-content .btn {
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.save-btn {
    background-color: blue;
    color: white;
}

.save-btn:hover {
    background-color: #45a049;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.cancel-btn {
    background-color: #e74c3c;
    color: white;
}

.cancel-btn:hover {
    background-color: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    cursor: pointer;
    color: blue;
    transition: transform 0.3s ease;
}

.close-btn:hover {
    transform: scale(1.2);
}

/* Keyframe animation for modal slide-in effect */
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


    </style>
</body>

</html>
