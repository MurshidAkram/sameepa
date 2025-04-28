<?php
class Events extends Controller
{
    private $eventModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            exit();
        }

        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            redirect('users/login');
        }

        $this->eventModel = $this->model('M_Events');
    }

    public function index()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $events = $this->eventModel->getAllEvents($search);

        foreach ($events as $event) {
            $event->participant_count = $this->eventModel->getParticipantCount($event->id);
        }

        $data = [
            'events' => $events,
            'search' => $search
        ];

        $this->view('events/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

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
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($_FILES['image']['type'], $allowed)) {
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG and GIF are allowed.';
                }
            }

            // Validate data
            $this->validateEventData($data);

            // If no errors, create event
            if (empty($data['errors'])) {
                if ($this->eventModel->createEvent($data)) {
                    if ($_SESSION['user_role_id'] == 2) {
                        redirect('events/index');
                    } else {
                        redirect('events/index');
                    }
                } else {
                    die('Something went wrong');
                }
            } else {
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

    private function validateEventData($data)
    {
        // Validate Title
        if (empty($data['title'])) {
            $data['errors'][] = 'Please enter event title';
        } elseif (strlen($data['title']) > 255) {
            $data['errors'][] = 'Title cannot exceed 255 characters';
        }

        // Validate Description
        if (empty($data['description'])) {
            $data['errors'][] = 'Please enter event description';
        }

        // Validate Date
        if (empty($data['date'])) {
            $data['errors'][] = 'Please enter event date';
        } else {
            if (strtotime($data['date']) < strtotime(date('Y-m-d'))) {
                $data['errors'][] = 'Event date cannot be in the past';
            }
            $threeDaysLater = strtotime('+3 days', strtotime(date('Y-m-d')));
            if (strtotime($data['date']) < $threeDaysLater) {
                $data['errors'][] = 'Events must be created at least 3 days in advance';
            } else {
                $originalEvent = $this->eventModel->getEventById($data['id']);
                if ($originalEvent && strtotime($originalEvent['date']) < strtotime(date('Y-m-d'))) {
                    // If the original event is in the past, don't allow changing the date
                    if ($data['date'] != $originalEvent['date']) {
                        $data['errors'][] = 'Cannot change the date of an event that has already passed';
                    }
                }
            }
        }

        if (empty($data['time'])) {
            $data['errors'][] = 'Please enter event time';
        }

        // Validate Location
        if (empty($data['location'])) {
            $data['errors'][] = 'Please enter event location';
        } elseif (strlen($data['location']) > 255) {
            $data['errors'][] = 'Location cannot exceed 255 characters';
        }
    }

    public function image($id)
    {
        $image = $this->eventModel->getEventImage($id);

        if ($image && $image['image_data']) {
            header("Content-Type: " . $image['image_type']);
            echo $image['image_data'];
            exit;
        }


        header("Content-Type: image/png");
        readfile(APPROOT . '/public/img/default-event.png');
    }

    public function viewevent($id)
    {
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

        $this->view('events/viewevent', $data);
    }

    public function join($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $event = $this->eventModel->getEventById($id);

            if (!$event) {
                echo json_encode(['success' => false, 'message' => 'Event not found']);
                exit;
            }

            if (!$event['is_active']) {
                echo json_encode(['success' => false, 'message' => 'This event has already ended and cannot be joined']);
                exit;
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

    public function leave($id)
    {
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

    public function my_events()
    {
        $events = $this->eventModel->getEventsByUser($_SESSION['user_id']);
        foreach ($events as $event) {
            $event->participant_count = $this->eventModel->getParticipantCount($event->id);
        }
        $data = [
            'events' => $events
        ];
        $this->view('events/my_events', $data);
    }

    public function getParticipants($eventId)
    {
        if (!$this->eventModel->isEventCreator($eventId, $_SESSION['user_id'])) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }


        $participants = $this->eventModel->getEventParticipants($eventId);
        echo json_encode($participants);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    public function admindelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!in_array($_SESSION['user_role_id'], [2, 3])) {
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

    public function joined()
    {
        $events = $this->eventModel->getJoinedEvents($_SESSION['user_id']);
        foreach ($events as $event) {
            $event->participant_count = $this->eventModel->getParticipantCount($event->id);
        }
        $data = [
            'events' => $events
        ];
        $this->view('events/joined', $data);
    }

    public function update($id)
    {
        if (
            !$this->eventModel->isEventCreator($id, $_SESSION['user_id']) &&
            !in_array($_SESSION['user_role_id'], [2, 3])
        ) {
            redirect('events/index');
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


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


            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($_FILES['image']['type'], $allowed)) {
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG and GIF are allowed.';
                }
            }


            $this->validateEventData($data);


            if (empty($data['errors'])) {
                if ($this->eventModel->updateEvent($data)) {
                    redirect('events/viewevent/' . $id);
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('events/update', $data);
            }
        } else {
            $event = $this->eventModel->getEventById($id);

            if (!$event) {
                redirect('events/index');
            }

            if (!$event['is_active']) {
                redirect('events/viewevent/' . $id);
            }

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
