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
    transition: padding-bottom 0.3s ease;
    margin-left: 20px;
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
    position: relative;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.category-card.active {
    background: linear-gradient(135deg, rgb(96, 17, 85) 0%, rgb(128, 33, 147) 100%);
    z-index: 10;
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
    display: flex;
    flex-direction: column;
    gap: 15px;
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
    transform-origin: top;
    animation: fadeIn 0.3s ease;
}

.category-card.active .contacts-grid {
    display: grid;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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

    .contacts-container {
        grid-template-columns: 1fr;
    }
    
    .contacts-grid {
        grid-template-columns: 1fr;
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
                        
                            <div class="category-icon">
                                <i class="fas fa-<?php echo $categoryData['category']->icon; ?>"></i>
                            </div>
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
                                   
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

   
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
    
      
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

    </script>
</body>
</html>