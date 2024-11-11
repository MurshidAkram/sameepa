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

    // Change this method name from 'view' to 'viewEvent'
public function viewevent($id) {
    $event = $this->eventModel->getEventById($id);
    
    if (!$event) {
        redirect('events/index');
    }
    
    $isJoined = $this->eventModel->isUserJoined($id, $_SESSION['user_id']);
    $participantCount = $this->eventModel->getParticipantCount($id);
    
    $data = [
        'event' => $event,
        'isJoined' => $isJoined,
        'participantCount' => $participantCount
    ];
    
    $this->view('events/viewevent', $data);  // This calls the parent Controller::view() method
}
    
    public function join($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $event = $this->eventModel->getEventById($id);
            
            if (!$event) {
                die('Event not found');
            }
            
            if ($this->eventModel->joinEvent($id, $_SESSION['user_id'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to join event']);
            }
            exit;
        }
        redirect('events/viewevent/' . $id);
    }
    
    public function leave($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->eventModel->leaveEvent($id, $_SESSION['user_id'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to leave event']);
            }
            exit;
        }
        redirect('events/viewevent/' . $id);

    }

    public function my_events() {
        $events = $this->eventModel->getEventsByUser($_SESSION['user_id']);
        foreach($events as $event) {
            $event->participant_count = $this->eventModel->getParticipantCount($event->id);
        }
        $data = [
            'events' => $events
        ];
        $this->view('events/my_events', $data);
    }
    
    public function getParticipants($eventId) {
        // Verify that the current user is the event creator
        if (!$this->eventModel->isEventCreator($eventId, $_SESSION['user_id'])) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        $participants = $this->eventModel->getEventParticipants($eventId);
        echo json_encode($participants);
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verify that the current user is the event creator
            if (!$this->eventModel->isEventCreator($id, $_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                return;
            }
    
            if ($this->eventModel->deleteEvent($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete event']);
            }
        }
    }

    public function joined() {
        $events = $this->eventModel->getJoinedEvents($_SESSION['user_id']);
        foreach($events as $event) {
            $event->participant_count = $this->eventModel->getParticipantCount($event->id);
        }
        $data = [
            'events' => $events
        ];
        $this->view('events/joined', $data);
    }

    public function update($id) {
        // Check if user is the event creator
        if (!$this->eventModel->isEventCreator($id, $_SESSION['user_id'])) {
            //flash('error', 'Unauthorized access');
            redirect('events/index');
        }
    
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Initialize data array
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'date' => trim($_POST['date']),
                'time' => trim($_POST['time']),
                'location' => trim($_POST['location']),
                'image_data' => null,
                'image_type' => null,
                'errors' => []
            ];
    
            // Handle image upload if present
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                
                if(in_array($_FILES['image']['type'], $allowed)) {
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG and GIF are allowed.';
                }
            }
    
            // Validate data
            $this->validateEventData($data);
    
            // If no errors, update event
            if(empty($data['errors'])) {
                if($this->eventModel->updateEvent($data)) {
                    //flash('event_message', 'Event Updated Successfully');
                    redirect('events/viewevent/' . $id);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('events/update', $data);
            }
        } else {
            // Get event data
            $event = $this->eventModel->getEventById($id);
            
            if(!$event) {
                redirect('events/index');
            }
    
            // Init data
            $data = [
                'id' => $id,
                'title' => $event['title'],
                'description' => $event['description'],
                'date' => $event['date'],
                'time' => $event['time'],
                'location' => $event['location'],
                'errors' => []
            ];
    
            $this->view('events/update', $data);
        }
    }
}