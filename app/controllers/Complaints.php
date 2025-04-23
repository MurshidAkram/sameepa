<?php
class Complaints extends Controller
{
    protected $complaintsModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        if (!in_array($_SESSION['user_role_id'], [1, 2, 3, 4, 5])) {
            redirect('users/login');
        }

        $this->complaintsModel = $this->model('M_Complaints');
    }

    public function index()
    {
        // Redirect based on user role
        if (in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('complaints/dashboard');
        } else {
            redirect('complaints/mycomplaints');
        }
    }

    public function dashboard()
    {
        // Only admins and superadmins can access dashboard
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('complaints/mycomplaints');
        }

        $adminId = $_SESSION['user_role_id'] == 2 ? $_SESSION['user_id'] : null;

        $data = [
            'stats' => $this->complaintsModel->getDashboardStats($adminId),
            'complaints' => [
                'resident' => $this->complaintsModel->getComplaintsByRole(1, $adminId),
                'maintenance' => $this->complaintsModel->getComplaintsByRole(4, $adminId),
                'security' => $this->complaintsModel->getComplaintsByRole(5, $adminId)
            ]
        ];

        // Add admin complaints for superadmin
        if ($_SESSION['user_role_id'] == 3) {
            $data['complaints']['admin'] = $this->complaintsModel->getComplaintsByRole(2);
        }

        $this->view('complaints/dashboard', $data);
    }

    public function create()
    {
        // Check if user is allowed to create complaints
        if (!in_array($_SESSION['user_role_id'], [1, 2, 4, 5])) {
            redirect('complaints/mycomplaints');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'title_err' => '',
                'description_err' => ''
            ];

            // Validate title
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            // Validate description
            if (empty($data['description'])) {
                $data['description_err'] = 'Please enter description';
            }

            // Make sure no errors
            if (empty($data['title_err']) && empty($data['description_err'])) {
                $complaintData = [
                    'user_id' => $_SESSION['user_id'],
                    'title' => $data['title'],
                    'description' => $data['description']
                ];

                if ($this->complaintsModel->createComplaint($complaintData)) {
                    flash('complaint_message', 'Complaint Created Successfully');
                    redirect('complaints/mycomplaints');
                } else {
                    flash('complaint_message', 'Something went wrong', 'alert alert-danger');
                    redirect('complaints/create');
                }
            } else {
                // Load view with errors
                $this->view('complaints/create', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => '',
                'description' => '',
                'title_err' => '',
                'description_err' => ''
            ];

            // Load view
            $this->view('complaints/create', $data);
        }
    }

    public function mycomplaints()
    {
        $complaints = $this->complaintsModel->getUserComplaints($_SESSION['user_id']);

        $data = [
            'complaints' => $complaints,
            'title_err' => '',
            'description_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $complaintData = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description'])
            ];

            // Validate
            if (empty($complaintData['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            if (empty($complaintData['description'])) {
                $data['description_err'] = 'Please enter description';
            }

            if (empty($data['title_err']) && empty($data['description_err'])) {
                if ($this->complaintsModel->createComplaint($complaintData)) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    return;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
                    return;
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'errors' => [
                        'title' => $data['title_err'],
                        'description' => $data['description_err']
                    ]
                ]);
                return;
            }
        }

        $this->view('complaints/mycomplaints', $data);
    }

    public function getComplaintDetails($id)
    {
        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $id)) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            return;
        }

        $complaint = $this->complaintsModel->getComplaintDetails($id);

        if ($complaint) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $complaint]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Complaint not found']);
        }
    }

    public function addResponse()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('complaints');
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $data['complaint_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            return;
        }

        $responseData = [
            'complaint_id' => $data['complaint_id'],
            'admin_id' => $_SESSION['user_id'],
            'response' => $data['response'],
            'status' => $data['status'] ?? null
        ];

        if ($this->complaintsModel->addResponse($responseData)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add response']);
        }
    }


    public function viewcomplaint($id = null)
    {
        if (!$id) {
            redirect('complaints/' . (in_array($_SESSION['user_role_id'], [2, 3]) ? 'dashboard' : 'mycomplaints'));
        }

        // Check if user can access this complaint
        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $id)) {
            flash('complaint_message', 'Unauthorized access', 'alert alert-danger');
            redirect('complaints/' . (in_array($_SESSION['user_role_id'], [2, 3]) ? 'dashboard' : 'mycomplaints'));
        }

        $complaint = $this->complaintsModel->getComplaintDetails($id);

        if (!$complaint) {
            flash('complaint_message', 'Complaint not found', 'alert alert-danger');
            redirect('complaints/' . (in_array($_SESSION['user_role_id'], [2, 3]) ? 'dashboard' : 'mycomplaints'));
        }

        $data = [
            'complaint' => $complaint
        ];

        $this->view('complaints/view_complaint', $data);
    }

    public function delete($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect('complaints/mycomplaints');
        }

        // Check if complaint exists and user can access it
        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $id)) {
            redirect('complaints/mycomplaints');
        }

        if ($this->complaintsModel->deleteComplaint($id, $_SESSION['user_id'])) {
        } else {
        }

        redirect('complaints/mycomplaints');
    }
}
