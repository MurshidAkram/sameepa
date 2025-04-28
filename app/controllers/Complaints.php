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
        if (in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('complaints/dashboard');
        } else {
            redirect('complaints/mycomplaints');
        }
    }

    public function dashboard()
    {
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

        if ($_SESSION['user_role_id'] == 3) {
            $data['complaints']['admin'] = $this->complaintsModel->getComplaintsByRole(2);
        }

        $this->view('complaints/dashboard', $data);
    }

    public function create()
    {
        if (!in_array($_SESSION['user_role_id'], [1, 2, 4, 5])) {
            redirect('complaints/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

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
                    redirect('complaints/mycomplaints');
                } else {
                    redirect('complaints/create');
                }
            } else {
                $this->view('complaints/create', $data);
            }
        } else {
            $data = [
                'title' => '',
                'description' => '',
                'title_err' => '',
                'description_err' => ''
            ];

            $this->view('complaints/create', $data);
        }
    }

    public function mycomplaints()
    {
        $complaints = $this->complaintsModel->getUserComplaints($_SESSION['user_id']);

        $data = [
            'complaints' => $complaints
        ];

        $this->view('complaints/mycomplaints', $data);
    }

    public function getComplaintDetails($id)
    {
        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $id)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            return;
        }

        $complaint = $this->complaintsModel->getComplaintDetails($id);

        if ($complaint) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $complaint]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Complaint not found']);
        }
    }
    public function addResponse()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('complaints');
        }

        $complaintId = $_POST['complaint_id'] ?? null;
        $response = $_POST['response'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $complaintId)) {
            redirect('complaints/dashboard');
            return;
        }

        $responseData = [
            'complaint_id' => $complaintId,
            'admin_id' => $_SESSION['user_id'],
            'response' => $response,
            'status' => $status
        ];

        $this->complaintsModel->addResponse($responseData);


        redirect('complaints/viewcomplaint/' . $complaintId);
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('complaints');
        }

        $complaintId = $_POST['complaint_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $complaintId)) {
            redirect('complaints/dashboard');
            return;
        }

        $responseData = [
            'complaint_id' => $complaintId,
            'admin_id' => $_SESSION['user_id'],
            'response' => 'Status updated to: ' . ucfirst($status),
            'status' => $status
        ];

        $this->complaintsModel->addResponse($responseData);

        redirect('complaints/viewcomplaint/' . $complaintId);
    }


    public function viewcomplaint($id = null)
    {
        if (!$id) {
            redirect('complaints/' . (in_array($_SESSION['user_role_id'], [2, 3]) ? 'dashboard' : 'mycomplaints'));
        }

        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $id)) {
            redirect('complaints/' . (in_array($_SESSION['user_role_id'], [2, 3]) ? 'dashboard' : 'mycomplaints'));
        }

        $complaint = $this->complaintsModel->getComplaintDetails($id);

        if (!$complaint) {
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

        if (!$this->complaintsModel->canAccessComplaint($_SESSION['user_id'], $_SESSION['user_role_id'], $id)) {
            redirect('complaints/mycomplaints');
        }

        if ($this->complaintsModel->deleteComplaint($id, $_SESSION['user_id'])) {
        } else {
        }

        redirect('complaints/mycomplaints');
    }
}
