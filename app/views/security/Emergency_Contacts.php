<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Emergency Contacts | <?php echo SITENAME; ?></title>
    <style>
        .dashboard-container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

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

        .main-content {
            flex: 1;
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            
        }

        .category-card {
            background: linear-gradient(135deg, rgb(128, 33, 147) 0%, rgb(130, 37, 154) 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .category-card.active {
            background: linear-gradient(135deg, rgb(96, 17, 85) 0%, rgb(128, 33, 147) 100%);
        }

        .category-header {
            display: flex;
            align-items: center;
        }

        .category-icon {
            font-size: 1.8rem;
            margin-right: 15px;
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-title {
            font-size: 1.3rem;
            margin: 0;
        }

        .contacts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .contacts-grid {
            display: none;
            grid-column: 1 / -1;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .category-card.active .contacts-grid {
            display: grid;
        }

        .contact-item {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,0.15);
        }

        .contact-name {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .contact-phone {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .contact-description {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .contact-actions {
            display: flex;
            gap: 8px;
        }

        .btn-call {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-call:hover {
            background: #3d8b40;
        }

        /* Modal styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: rgb(186, 57, 237);
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            color: #fff;
            position: relative;
        }

        .modal-content .close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.8rem;
            cursor: pointer;
            color: white;
        }

        .modal-content h3 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background: rgba(255,255,255,0.9);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        .btn.save-btn {
            background: #450d8f;
            color: white;
        }

        .btn.save-btn:hover {
            background: rgb(96, 17, 85);
        }

        .btn.cancel-btn {
            background: #e74c3c;
            color: white;
        }

        .btn.cancel-btn:hover {
            background: #c0392b;
        }

        @media (max-width: 768px) {
            .contacts-container {
                grid-template-columns: 1fr;
            }
            
            .main-content {
                margin-left: 0;
                margin-top: 70px;
            }
            
            .side-panel {
                width: 100%;
                height: auto;
                position: fixed;
                top: 0;
                z-index: 99;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <div class="main-content">
            <h1>Emergency Contacts</h1>

            <div class="contacts-container">
                <?php foreach ($data['contactsByCategory'] as $categoryData): ?>
                    <div class="category-card" onclick="toggleContacts(this, <?php echo $categoryData['category']->id; ?>)">
                        <div class="category-header">
                            <!-- <div class="category-icon">
                                <i class="fas fa-<?php echo $categoryData['category']->icon; ?>"></i>
                            </div> -->
                            <h2 class="category-title"><?php echo $categoryData['category']->name; ?></h2>
                        </div>
                        
                        <div class="contacts-grid">
                            <?php foreach ($categoryData['contacts'] as $contact): ?>
                                <div class="contact-item">
                                    <div class="contact-name"><?php echo htmlspecialchars($contact->name); ?></div>
                                    <div class="contact-phone"><?php echo htmlspecialchars($contact->phone); ?></div>
                                    <?php if (!empty($contact->description)): ?>
                                        <div class="contact-description"><?php echo htmlspecialchars($contact->description); ?></div>
                                    <?php endif; ?>
                                    <!-- <div class="contact-actions">
                                        <a href="tel:<?php echo htmlspecialchars($contact->phone); ?>" class="btn-call">
                                            <i class="fas fa-phone"></i> Call
                                        </a>
                                        <button class="btn-edit" onclick="openEditModal(
                                            '<?php echo $contact->id; ?>',
                                            '<?php echo htmlspecialchars($contact->name); ?>', 
                                            '<?php echo htmlspecialchars($contact->phone); ?>',
                                            '<?php echo htmlspecialchars($contact->description); ?>',
                                            event
                                        )">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div> -->
                                </div>
                            <?php endforeach; ?>
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
            <form id="editContactForm">
                <div class="form-group">
                    <label for="editContactName">Name:</label>
                    <input type="text" id="editContactName" required>
                </div>
                
                <div class="form-group">
                    <label for="editContactPhone">Phone:</label>
                    <input type="text" id="editContactPhone" required>
                </div>
                
                <div class="form-group">
                    <label for="editContactDescription">Description:</label>
                    <textarea id="editContactDescription" rows="3"></textarea>
                </div>
                
                <input type="hidden" id="editContactId">
                
                <div class="form-actions">
                    <button type="button" class="btn cancel-btn" onclick="closeModal('editContactModal')">Cancel</button>
                    <button type="submit" class="btn save-btn">Save</button>
                </div>
            </form>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
      // Store all contacts data from PHP
const allContacts = <?php echo json_encode($data['contactsByCategory']); ?>;
let currentCategoryId = null;

// Toggle contacts visibility when clicking a category card
function toggleContacts(card, categoryId, categoryName, categoryIcon) {
    // Close all other open category cards
    document.querySelectorAll('.category-card').forEach(item => {
        item.classList.remove('active');
    });

    // Toggle the clicked card
    card.classList.add('active');

    // Show contacts
    showCategoryContacts(categoryId, categoryName, categoryIcon);
}

// Show contacts for a specific category
function showCategoryContacts(categoryId, categoryName, categoryIcon) {
    // Update display header
    document.getElementById('displayCategoryTitle').textContent = categoryName;
    document.getElementById('displayCategoryIcon').className = `fas fa-${categoryIcon}`;

    // Find and show contacts
    const categoryData = allContacts.find(cat => cat.category.id == categoryId);
    const contacts = categoryData ? categoryData.contacts : [];
    const contactsList = document.getElementById('contactsList');
    contactsList.innerHTML = '';

    contacts.forEach(contact => {
        const contactItem = document.createElement('div');
        contactItem.className = 'contact-item';
        contactItem.innerHTML = `
            <div class="contact-name">${contact.name}</div>
            <div class="contact-phone">${contact.phone}</div>
            ${contact.description ? `<div class="contact-description">${contact.description}</div>` : ''}
            <div class="contact-actions">
                <a href="tel:${contact.phone}" class="btn-call">
                    <i class="fas fa-phone"></i> Call
                </a>
                <button class="btn-edit" onclick="openEditModal(
                    '${contact.id}',
                    '${contact.name.replace(/'/g, "\\'")}',
                    '${contact.phone}',
                    '${contact.description ? contact.description.replace(/'/g, "\\'") : ''}',
                    event
                )">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </div>
        `;
        contactsList.appendChild(contactItem);
    });

    document.getElementById('contactsDisplay').style.display = 'block';
    document.getElementById('contactsDisplay').scrollIntoView({ behavior: 'smooth' });

    currentCategoryId = categoryId;
}

// Open a modal
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
    document.getElementById(modalId).style.display = 'block';
}

// Close a modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    document.getElementById(modalId).style.display = 'none';
}

// Open the edit modal with contact details
function openEditModal(id, name, phone, description, event) {
    event.stopPropagation();
    document.getElementById('editContactId').value = id;
    document.getElementById('editContactName').value = name;
    document.getElementById('editContactPhone').value = phone;
    document.getElementById('editContactDescription').value = description || '';
    openModal('editContactModal');
}

// Save edited contact
document.getElementById('editContactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('editContactId').value;
    const name = document.getElementById('editContactName').value;
    const phone = document.getElementById('editContactPhone').value;
    const description = document.getElementById('editContactDescription').value;

    const data = { id, name, phone, description };

    fetch(`<?php echo URLROOT; ?>/security/Edit_Contact/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Contact updated successfully');
            closeModal('editContactModal');

            // Refresh contacts for current category
            if (currentCategoryId) {
                const currentCategory = allContacts.find(cat => cat.category.id == currentCategoryId);
                if (currentCategory) {
                    showCategoryContacts(
                        currentCategoryId,
                        currentCategory.category.name,
                        currentCategory.category.icon
                    );
                }
            }
        } else {
            alert('Failed to update contact');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the contact.');
    });
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        closeModal('editContactModal');
    }
});

     
    </script>
</body>
</html>