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

        // For each event, check if the current user has joined
        foreach ($events as &$event) {
            $event->isJoined = $this->eventModel->isUserJoined($event->id, $_SESSION['user_id']);
        }

        $data = [
            'events' => $events,
            'user_id' => $_SESSION['user_id'],
            'is_admin' => in_array($_SESSION['user_role_id'], [2, 3]) // Admin or SuperAdmin
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
                'image' => trim($_FILES['image']['name']),
                'created_by' => $_SESSION['user_id'],
                'errors' => []
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $imageFileName = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                $imagePath = APPROOT . '/public/img/' . $imageFileName;

                if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                    $data['image'] = $imageFileName;
                } else {
                    $data['errors'][] = 'Error uploading image';
                }
            }

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
                'image' => '',
                'errors' => []
            ];

            $this->view('events/create', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isAdmin = in_array($_SESSION['user_role_id'], [2, 3]);

            if ($this->eventModel->deleteEvent($id, $_SESSION['user_id'], $isAdmin)) {
                header('Location: ' . URLROOT . '/events');
            } else {
                die('Something went wrong');
            }
        } else {
            header('Location: ' . URLROOT . '/events');
        }
    }

    public function join($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('/events');
            return;
        }

        // Check if event exists
        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            die('Event not found');
        }

        // Check if already joined
        if ($this->eventModel->isUserJoined($id, $_SESSION['user_id'])) {
            // Return JSON response for AJAX request
            if (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {
                echo json_encode(['status' => 'error', 'message' => 'Already joined']);
                return;
            }
            redirect('/events');
            return;
        }

        // Join the event
        if ($this->eventModel->joinEvent($id, $_SESSION['user_id'])) {
            // Return JSON response for AJAX request
            if (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {
                echo json_encode(['status' => 'success']);
                return;
            }
            redirect('/events');
        } else {
            die('Something went wrong');
        }
    }

    public function viewevent($id)
    {
        $event = $this->eventModel->getEventById($id);

        if (!$event) {
            header('Location: ' . URLROOT . '/events');
            exit();
        }

        $isJoined = $this->eventModel->isUserJoined($id, $_SESSION['user_id']);
        $participantCount = $this->eventModel->getParticipantCount($id);

        $data = [
            'event' => $event,
            'is_joined' => $isJoined,
            'participant_count' => $participantCount,
            'is_admin' => in_array($_SESSION['user_role_id'], [2, 3]),
            'is_creator' => ($event['created_by'] == $_SESSION['user_id'])
        ];

        $this->view('events/viewevent', $data);
    }
}
