<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css" rel="stylesheet" />
    <title>Team Scheduling | <?php echo SITENAME; ?></title>


    <style>
        /* General Styles */
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
        }

        /* Side Panel Styling */


        /* Main Content Styling */
        main {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 20px;
        }

        h1,
        h2 {
            color: #800080;
        }

        /* Profile Cards */
        .team-profile {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .team-profile-card {
            flex: 1 1 calc(25% - 20px);
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 15px;
            border: 4px solid transparent;
            background-clip: padding-box;
        }

        .profile-details {
            text-align: center;
        }

        .profile-details h3 {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #34495e;
        }

        .profile-details p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .edit-btn {
            background-color: #1abc9c;
        }

        .edit-btn:hover {
            background-color: #16a085;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        /* Unique Card Styles */
        .card-hvac {
            background: linear-gradient(135deg, #3498db, #2ecc71);
        }

        .card-electrical {
            background: linear-gradient(135deg, #f1c40f, #e67e22);
        }

        .card-plumbing {
            background: linear-gradient(135deg, #9b59b6, #34495e);
        }

        .card-general {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .card-hvac .profile-img {
            border-color: #2ecc71;
        }

        .card-electrical .profile-img {
            border-color: #e67e22;
        }

        .card-plumbing .profile-img {
            border-color: #9b59b6;
        }

        .card-general .profile-img {
            border-color: #c0392b;
        }

        /* Button Styling */
        .btn {
            background-color: #336699;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(1px);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .edit-btn {
            background-color: #3498db;
            /* Blue color */
            color: white;
            /* Text color */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth transition for hover effects */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        /* Edit Button Hover Effect */
        .edit-btn:hover {
            background-color: #2980b9;
            /* Darker blue on hover */
            transform: translateY(-2px);
            /* Lift effect */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            /* Stronger shadow on hover */
        }

        .delete-btn {
            background-color: lightcoral;
            /* Blue color */
            color: white;
            /* Text color */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth transition for hover effects */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        /* Edit Button Hover Effect */
        .delete-btn:hover {
            /* Darker blue on hover */
            transform: translateY(-2px);
            /* Lift effect */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            /* Stronger shadow on hover */
        }


        /* Profile Card Styles */
        .team-profile-card {
            display: flex;
            align-items: center;
            background-color: #f6e4f7;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease, transform 0.2s ease;
            gap: 20px;
        }

        .team-profile-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .profile-img img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #3498db;
            object-fit: cover;
        }

        .profile-details {
            flex-grow: 1;
            color: #34495e;
        }

        .profile-details p {
            margin: 5px 0;
            font-size: 1rem;
            line-height: 1.5;
            color: black;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
        }

        .alert.critical {
            background-color: #e74c3c;
        }

        .alert.warning {
            background-color: #f39c12;
            color: #2c3e50;
        }

        /* Modal */
        /* Modal background and position */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            max-width: 400px;
            background-color: #ffffff;
            /* Dark Violet */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            z-index: 1000;
            display: none;
        }

        /* Modal active state (visible) */
        .modal.active {
            display: block;

        }

        /* Modal header */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            color: #fff;
            /* Light text color */
        }

        .modal-header .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #e8c8e3;
            /* Light Violet */
            transition: color 0.3s ease;
        }

        .modal-header .close:hover {
            color: #f1d1f6;
            /* Lighter Violet on hover */
        }

        /* Modal form inputs and select */
        .modal-form input,
        .modal-form select {
            width: 90%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid black;
            /* Light Violet border */
            border-radius: 5px;
            background-color: #f6e4f7;
            /* Light Violet background */
            color: black;
            /* Dark Violet text */
        }

        /* Form input and select focus effects */
        .modal-form input:focus,
        .modal-form select:focus {
            outline: none;
            border-color: #e8c8e3;
            /* Light Violet border on focus */
            box-shadow: 0 0 5px rgba(232, 200, 227, 0.5);
            /* Subtle shadow */
        }

        /* Form submit button */
        .modal-form button {
            background-color: #7a4d9c;
            /* Medium Violet */
            color: #fff;
            border: none;
            padding: 12px;
            width: 95%;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-form button:hover {
            background-color: #9b66c9;
            /* Lighter Violet on hover */
        }



        .h1position {
            padding-left: 300px;
        }



        .shift-allocation,
        .alerts {

            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            padding-left: 300px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 80%;
        }

        /* Container for the search bar */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        /* Input field for the search bar */
        .search-input {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 30px;
            outline: none;
            transition: border 0.3s;
        }

        /* Focus effect on the input field */
        .search-input:focus {
            border-color: #4caf50;
        }

        /* Button to trigger search */
        .search-btn {
            position: absolute;
            right: 5px;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Hover effect for the search button */
        .search-btn:hover {
            background-color: #45a049;
        }

        /* FontAwesome icon style */
        .search-btn i {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <main>
            <h1>Team Scheduling</h1>
            <div class="search-container">
                <input type="text" id="searchBar" class="search-input" placeholder="Search for members specialization ....">
                <button class="search-btn" id="searchBtn">
                    <i class="fas fa-search"></i> <!-- FontAwesome search icon -->
                </button>
            </div>

            <!-- Add New Maintenance Member -->
            <div class="button-container">
                <button class="btn" id="addMemberBtn">Add New Maintenance Member</button>
            </div>

            <h2>Team Profiles</h2>
            <!-- Team Profiles Section -->
            <section class="team-profile">
                <?php foreach ($data['members'] as $member): ?>
                    <div class="team-profile-card" data-id="<?php echo $member->id; ?>">
                        <div class="profile-img">
                            <img src="<?php echo URLROOT . '/img/' . $member->profile_image; ?>" alt="<?php echo $member->specialization; ?>">
                        </div>
                        <div class="profile-details">
                            <h3 class="member-name"><?php echo $member->name; ?></h3>
                            <p class="member-specialization">Specialization: <?php echo $member->specialization; ?></p>
                            <p class="member-experience">Experience: <?php echo $member->experience; ?> years</p>
                            <p class="member-phone_number">Phone Number: <?php echo $member->phone_number; ?></p>
                        </div>
                        <div class="action-buttons">
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

        </main>
    </div>

    <!-- Modal for Adding/Editing Member -->
    <div class="modal" id="memberModal">
        <div class="modal-header">
            <h2 id="modalTitle">Add New Member</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <form class="modal-form" id="memberForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="specialization">Specialization:</label>
            <select id="specialization" name="specialization" required>
                <option value="HVAC">HVAC</option>
                <option value="Electrical">Electrical</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Carpentry">Carpentry</option>
                <option value="Painting">Painting</option>
                <option value="Welding">Welding</option>
                <option value="Elevator Maintenance">Elevator Maintenance</option>
                <option value="Fire Safety Systems">Fire Safety Systems</option>
                <option value="Security Systems">Security Systems</option>
                <option value="Waste Management">Waste Management</option>
                <option value="Water Treatment">Water Treatment</option>
                <option value="Generator Maintenance">Generator Maintenance</option>
                <option value="CCTV Installation & Maintenance">CCTV Installation & Maintenance</option>


            </select>

            <label for="experience">Experience (Years):</label>
            <input type="number" id="experience" name="experience" required min="1" max="35" step="1">


            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required
                pattern="^\d{10}$" title="Phone number must be exactly 10 digits" maxlength="10">

            <label for="profileImage">Profile Image:</label>
            <input type="file" id="profileImage" name="profileImage" accept="image/*">

            <div class="modal-buttons">

                <button type="submit" class="btn save-btn">Save</button>

            </div>
        </form>
    </div>

    <!-- Placeholder for success message -->
    <div id="successMessage" class="success-message" style="display: none;">
        Member has been saved successfully!
    </div>


    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addMemberBtn = document.getElementById('addMemberBtn');
            const memberModal = document.getElementById('memberModal');
            const closeModal = document.getElementById('closeModal');
            const memberForm = document.getElementById('memberForm');
            const teamProfileSection = document.querySelector('.team-profile');
            const phoneInput = document.getElementById('phone_number');
            const phoneRegex = /^\d{10}$/; // Regex for exactly 10 digits
            let editingMemberId = null;

            // Open modal for adding a new member
            addMemberBtn.addEventListener('click', () => {
                editingMemberId = null; // Reset editing mode
                memberModal.classList.add('active');
                memberForm.reset(); // Reset the form
                document.getElementById('modalTitle').textContent = 'Add New Member';
            });

            // Open modal for editing an existing member
            teamProfileSection.addEventListener('click', (e) => {
                if (e.target.classList.contains('edit-btn')) {
                    const card = e.target.closest('.team-profile-card');
                    editingMemberId = card.dataset.id;

                    // Populate the form with existing data
                    const name = card.querySelector('.member-name').textContent;
                    const specialization = card.querySelector('.member-specialization').textContent.split(': ')[1];
                    const experience = card.querySelector('.member-experience').textContent.split(': ')[1].replace(' years', '');
                    const phone_number = card.querySelector('.member-phone_number').textContent.split(': ')[1];

                    document.getElementById('name').value = name;
                    document.getElementById('specialization').value = specialization;
                    document.getElementById('experience').value = experience;
                    document.getElementById('phone_number').value = phone_number;
                    document.getElementById('modalTitle').textContent = 'Edit Member';

                    memberModal.classList.add('active');
                }
            });

            // Close modal
            closeModal.addEventListener('click', () => {
                memberModal.classList.remove('active');
            });

            // Real-time phone number validation
            phoneInput.addEventListener('input', function() {
                if (!phoneRegex.test(this.value.trim())) {
                    this.setCustomValidity('Phone number must be exactly 10 digits.');
                } else {
                    this.setCustomValidity('');
                }
            });

            // Handle form submission for adding/editing a member
            memberForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const phoneNumber = phoneInput.value.trim();

                // Final validation before submitting
                if (!phoneRegex.test(phoneNumber)) {
                    alert('Phone number must be exactly 10 digits.');
                    return; // Stop form submission
                }

                const formData = new FormData(this); // Collect form data, including files
                const url = editingMemberId ?
                    `<?php echo URLROOT; ?>/maintenance/editMember/${editingMemberId}` :
                    `<?php echo URLROOT; ?>/maintenance/addMember`;

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (editingMemberId) {
                                // Update the existing card
                                const card = document.querySelector(`.team-profile-card[data-id="${editingMemberId}"]`);
                                card.querySelector('.member-name').textContent = data.name;
                                card.querySelector('.member-specialization').textContent = `Specialization: ${data.specialization}`;
                                card.querySelector('.member-experience').textContent = `Experience: ${data.experience} years`;
                                card.querySelector('.member-phone_number').textContent = `Phone Number: ${data.phone_number}`;

                                // Update profile image if provided
                                if (data.profile_image) {
                                    card.querySelector('.profile-img img').src = data.profile_image;
                                }
                            } else {
                                // Add a new card
                                const newCard = `
                            <div class="team-profile-card" data-id="${data.id}">
                                <div class="profile-img">
                                    <img src="${data.profile_image}" alt="${data.specialization}">
                                </div>
                                <div class="profile-details">
                                    <h3 class="member-name">${data.name}</h3>
                                    <p class="member-specialization">Specialization: ${data.specialization}</p>
                                    <p class="member-experience">Experience: ${data.experience} years</p>
                                    <p class="member-phone_number">Phone Number: ${data.phone_number}</p>
                                </div>
                                <div class="action-buttons">
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </div>
                            </div>`;
                                teamProfileSection.innerHTML += newCard;
                            }
                            // Close the modal after success
                            memberModal.classList.remove('active');
                        } else {
                            alert(data.message || 'Error saving member');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Delete functionality
            teamProfileSection.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-btn')) {
                    const card = e.target.closest('.team-profile-card');
                    const memberId = card.getAttribute('data-id');

                    if (confirm('Are you sure you want to delete this member?')) {
                        fetch(`<?php echo URLROOT; ?>/maintenance/deleteMember/${memberId}`, {
                                method: 'DELETE'
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    card.remove(); // Remove card from the DOM
                                } else {
                                    alert('Error deleting member');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                }
            });
        });

        document.getElementById('searchBtn').addEventListener('click', function() {
            const query = document.getElementById('searchBar').value.trim().toLowerCase();

            if (query) {
                // Add your search functionality here (e.g., filtering members)
                console.log(`Searching for: ${query}`);
                // For example, you could filter a list of team members based on this search term
            } else {
                alert('Please enter a search term');
            }
        });
    </script>
</body>

</html>