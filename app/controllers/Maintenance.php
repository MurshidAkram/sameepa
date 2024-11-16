<?php
class Maintenance extends Controller {

    private $maintenanceModel;
    
    public function __construct() {
        $this->maintenanceModel = $this->model('M_maintenance');
    }

    // Display the maintenance dashboard
    public function index() {
        $members = $this->maintenanceModel->getAllMembers();
        $data = [
            'members' => $members
        ];
        $this->view('maintenance/Team_Scheduling', $data);
    }

    // Add a new member
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'specialization' => trim($_POST['specialization']),
                'experience' => trim($_POST['experience']),
                'certifications' => trim($_POST['certifications']),
                'profile_image' => $_FILES['profileImage']['name']
            ];

            // Handle profile image upload
            if (!empty($_FILES['profileImage']['name'])) {
                $targetDir = APPROOT . "/../public/uploads/";
                $targetFile = $targetDir . basename($_FILES['profileImage']['name']);
                if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFile)) {
                    die('File upload failed.');
                }
            }

            if ($this->maintenanceModel->addMember($data)) {
                // Set a flash message for success
              
            } else {
                die('Something went wrong while adding a new member.');
            }
        } else {
            $this->view('maintenance/add');
        }
    }

    // Edit an existing member
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'specialization' => trim($_POST['specialization']),
                'experience' => trim($_POST['experience']),
                'certifications' => trim($_POST['certifications']),
                'profile_image' => $_FILES['profileImage']['name']
            ];

            // Handle profile image upload
            if (!empty($_FILES['profileImage']['name'])) {
                $targetDir = APPROOT . "/../public/uploads/";
                $targetFile = $targetDir . basename($_FILES['profileImage']['name']);
                if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFile)) {
                    die('File upload failed.');
                }
            }

            if ($this->maintenanceModel->updateMember($data)) {
                // Set a flash message for success
               
            } else {
                die('Something went wrong while updating the member.');
            }
        } else {
            $member = $this->maintenanceModel->getMemberById($id);
            if (!$member) {
               
            }
            $data = [
                'member' => $member
            ];
            $this->view('maintenance/edit', $data);
        }
    }

    // Delete a member
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->maintenanceModel->deleteMember($id)) {
                // Set a flash message for success
              
            } else {
                die('Something went wrong while deleting the member.');
            }
        } else {
           
        }
    }
}
?>
