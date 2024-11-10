<?php
class Events extends Controller
{
    private $eventModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Only allow residents (1), admins (2), and superadmins (3)
        $allowedRoles = [1, 2, 3];
        if (!in_array($_SESSION['user_role_id'], $allowedRoles)) {
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }

        $this->eventModel = $this->model('M_Events');
    }

    public function index()
    {
        $events = $this->eventModel->getAllEvents();
        $data = [
            'events' => $events,
            'user_id' => $_SESSION['user_id']
        ];

        $this->view('events/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'date' => trim($_POST['date']),
                'time' => trim($_POST['time']),
                'location' => trim($_POST['location']),
                'created_by' => $_SESSION['user_id'],
                'errors' => []
            ];

            // Validate input
            if (empty($data['title'])) {
                $data['errors'][] = 'Title is required';
            }
            if (empty($data['date'])) {
                $data['errors'][] = 'Date is required';
            }
            if (empty($data['time'])) {
                $data['errors'][] = 'Time is required';
            }
            if (empty($data['location'])) {
                $data['errors'][] = 'Location is required';
            }

            if (empty($data['errors'])) {
                if ($this->eventModel->createEvent($data)) {
                    //flash('event_message', 'Event Created Successfully');
                    header('Location: ' . URLROOT . '/events');
                    exit();
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('events/create', $data);
            }
        } else {
            $data = [
                'title' => '',
                'description' => '',
                'date' => '',
                'time' => '',
                'location' => '',
                'max_participants' => '',
                'errors' => []
            ];

            $this->view('events/create', $data);
        }
    }
}
