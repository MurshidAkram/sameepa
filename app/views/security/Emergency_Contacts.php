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
            <!-- Emergency Contacts List -->
            <div class="contacts-list-container">
                <!-- <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3>Emergency Contacts List</h3>
                    <button class="btn new-btn" onclick="openModal('newContactModal')">New Contact</button>
                </div>
                <div class="contacts-list"> -->

                    <!-- Emergency Contact Cards -->
                  <div>
                  <div class="contact-item" id="contact-1">
                        <h4>Police Hotline</h4>
                        <p>Phone: 911</p>
                        <p>Location: National Emergency Center</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Police Hotline', '911', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                          
                    <div class="contact-item" id="contact-1">
                        <h4>Hospital</h4>
                        <p>Phone: 1990</p>
                        <p>Location: National Hospital</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Police Hotline', '911', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                  </div>
                    

                  <div>
                  <div class="contact-item" id="contact-1">
                        <h4>CID</h4>
                        <p>Phone: 11111</p>
                        <p>Location: National Police</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Police Hotline', '911', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>

                    <div class="contact-item" id="contact-1">
                        <h4>Fire Point</h4>
                        <p>Phone: 333333</p>
                        <p>Location: National Fire</p>
                        <button class="btn call-btn">Hotline</button>
                        <button class="btn message-btn">Message</button>
                        <button class="btn edit-btn" onclick="openEditModal('Police Hotline', '911', 'National Emergency Center', 'contact-1')">Edit</button>
                        <button class="btn delete-btn" onclick="deleteContact('contact-1')">Delete</button>
                    </div>
                  </div>
                   
                </div>
            </div>
        </main>
    </div>

    
<!-- Edit Contact Modal -->
<div id="editContactModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('editContactModal')">&times;</span>
        <h2>Edit Emergency Contact</h2>
        <form id="editContactForm" onsubmit="saveContactEdits(event)">
            <label for="editContactName">Name:</label>
            <input type="text" id="editContactName" required>
            
            <label for="editContactPhone">Phone:</label>
            <input type="text" id="editContactPhone" required>
            
            <label for="editContactLocation">Location:</label>
            <input type="text" id="editContactLocation" required>
            
            <input type="hidden" id="editContactId">

            <button type="submit" class="btn save-btn">Save</button>
            <button type="button" class="btn cancel-btn" onclick="closeModal('editContactModal')">Cancel</button>
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
        var location = document.getElementById("incident_location").value;
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
        const location = document.getElementById('newContactLocation').value;

        const id = `contact-${Date.now()}`;
        const contactList = document.querySelector('.contacts-list');
        const newContactHTML = `
            <div class="contact-item" id="${id}">
                <h4>${name}</h4>
                <p>Phone: ${phone}</p>
                <p>Location: ${location}</p>
                <button class="btn call-btn">Hotline</button>
                <button class="btn message-btn">Message</button>
                <button class="btn edit-btn" onclick="openEditModal('${name}', '${phone}', '${location}', '${id}')">Edit</button>
                <button class="btn delete-btn" onclick="deleteContact('${id}')">Delete</button>
            </div>
        `;
        contactList.insertAdjacentHTML('beforeend', newContactHTML);
        closeModal('newContactModal');
    }

    // Open the edit modal with the contact details
    function openEditModal(name, phone, location, id) {
        document.getElementById('editContactName').value = name;
        document.getElementById('editContactPhone').value = phone;
        document.getElementById('editContactLocation').value = location;
        document.getElementById('editContactId').value = id;
        openModal('editContactModal');
    }

    // Save the contact edits
    function saveContactEdits(event) {
        event.preventDefault();  // Prevent form from submitting

        const id = document.getElementById('editContactId').value;
        const name = document.getElementById('editContactName').value;
        const phone = document.getElementById('editContactPhone').value;
        const location = document.getElementById('editContactLocation').value;

        const contact = document.getElementById(id);
        contact.innerHTML = `
            <h4>${name}</h4>
            <p>Phone: ${phone}</p>
            <p>Location: ${location}</p>
            <button class="btn call-btn">Hotline</button>
            <button class="btn message-btn">Message</button>
            <button class="btn edit-btn" onclick="openEditModal('${name}', '${phone}', '${location}', '${id}')">Edit</button>
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
        /* General Modal Styling */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Overlay background */
    display: flex; /* Flexbox to center content */
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Ensure it appears on top of other content */
    opacity: 0; /* Start with hidden modal */
    visibility: hidden; /* Start with hidden modal */
    transition: opacity 0.3s ease, visibility 0.3s ease; /* Smooth transition */
}

/* Make modal visible when it has 'display: block' */
.modal.active {
    opacity: 1;
    visibility: visible;
}

/* Modal Content Styling */
.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Title */
.modal-content h2 {
    margin-bottom: 20px;
    font-size: 1.5rem;
    color: #333;
}

/* Labels */
.modal-content label {
    font-size: 1rem;
    margin-bottom: 5px;
    text-align: left;
    width: 100%;
}

/* Input fields */
.modal-content input,
.modal-content select {
    width: 90%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

/* Button Styling */
.modal-content button {
    width: 45%;
    margin: 10px;
    padding: 10px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Save Button */
.save-btn {
    background-color: #27ae60;
    color: white;
    transition: background-color 0.3s ease;
}

.save-btn:hover {
    background-color: #2ecc71;
}

/* Cancel Button */
.cancel-btn {
    background-color: #e74c3c;
    color: white;
    transition: background-color 0.3s ease;
}

.cancel-btn:hover {
    background-color: #c0392b;
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    cursor: pointer;
}

    </style>
</body>

</html>
