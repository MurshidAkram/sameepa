<?php
class Events extends Controller {
    private $eventModel;

    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            exit();
        }

        // Check if user has appropriate role (1: Resident, 2: Admin, 3: SuperAdmin)
        if(!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            flash('error', 'Unauthorized access');
            redirect('users/login');
        }

        $this->eventModel = $this->model('M_Events');
    }

    public function index() {
        $events = $this->eventModel->getAllEvents(); 
        foreach($events as $event) {
            $event->participant_count = $this->eventModel->getParticipantCount($event->id);
        }
        $data = [
            'events' => $events
        ];
        $this->view('events/index', $data);
    }

    public function create() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Initialize data array
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'date' => trim($_POST['date']),
                'time' => trim($_POST['time']),
                'location' => trim($_POST['location']),
                'image_data' => null,
                'image_type' => null,
                'created_by' => $_SESSION['user_id'],
                'errors' => []
            ];

            // Handle image upload if present
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                
                if(in_array($_FILES['image']['type'], $allowed)) {
                    // Read image data
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG and GIF are allowed.';
                }
            }

            // Validate data
            $this->validateEventData($data);

            // If no errors, create event
            if(empty($data['errors'])) {
                if($this->eventModel->createEvent($data)) {
                    //flash('event_message', 'Event Created Successfully');
                    redirect('events');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('events/create', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => '',
                'description' => '',
                'date' => '',
                'time' => '',
                'location' => '',
                'errors' => []
            ];

            $this->view('events/create', $data);
        }
    }

    private function validateEventData(&$data) {
        // Validate Title
        if(empty($data['title'])) {
            $data['errors'][] = 'Please enter event title';
        } elseif(strlen($data['title']) > 255) {
            $data['errors'][] = 'Title cannot exceed 255 characters';
        }

        // Validate Description
        if(empty($data['description'])) {
            $data['errors'][] = 'Please enter event description';
        }

        // Validate Date
        if(empty($data['date'])) {
            $data['errors'][] = 'Please enter event date';
        } elseif(strtotime($data['date']) < strtotime(date('Y-m-d'))) {
            $data['errors'][] = 'Event date cannot be in the past';
        }

        // Validate Time
        if(empty($data['time'])) {
            $data['errors'][] = 'Please enter event time';
        }

        // Validate Location
        if(empty($data['location'])) {
            $data['errors'][] = 'Please enter event location';
        } elseif(strlen($data['location']) > 255) {
            $data['errors'][] = 'Location cannot exceed 255 characters';
        }
    }

    // Method to display event images
    public function image($id) {
        $image = $this->eventModel->getEventImage($id);
        
        if($image && $image['image_data']) {
            header("Content-Type: " . $image['image_type']);
            echo $image['image_data'];
            exit;
        }
        
        // Return default image if no image found
        header("Content-Type: image/png");
        readfile(APPROOT . '/public/img/default-event.png');
    }
}