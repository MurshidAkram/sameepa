<?php
class Facilities extends Controller
{
    private $facilityModel;

    public function __construct()
    {
        $this->facilityModel = $this->model('M_Facilities');
    }

    public function index()
    {
        $facilities = $this->facilityModel->getAllFacilities();
        $data = [
            'facilities' => $facilities
        ];
        $this->view('facilities/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the admin ID for this user
            $adminId = $this->facilityModel->getAdminIdByUserId($_SESSION['user_id']);

            if (!$adminId) {
                flash('facility_message', 'You do not have permission to create facilities', 'alert alert-danger');
                redirect('facilities');
            }

            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'capacity' => trim($_POST['capacity']),
                'status' => 'available',
                'created_by' => $adminId,
                'errors' => []
            ];

            if ($this->facilityModel->findFacilityByName($data['name'])) {
                flash('facility_message', 'A facility with this name already exists', 'alert alert-danger');
                redirect('facilities/create');
            }

            if (empty($data['name'])) {
                $data['errors'][] = 'Please enter facility name';
            }
            if (empty($data['capacity'])) {
                $data['errors'][] = 'Please enter capacity';
            }

            if (empty($data['errors'])) {
                if ($this->facilityModel->createFacility($data)) {
                    redirect('facilities');
                }
            } else {
                $this->view('facilities/create', $data);
            }
        } else {
            $data = [
                'name' => '',
                'description' => '',
                'capacity' => '',
                'errors' => []
            ];
            $this->view('facilities/create', $data);
        }
    }

    public function viewFacility($id)
    {
        $facility = $this->facilityModel->getFacilityById($id);

        if (!$facility) {
            redirect('facilities');
        }

        $data = [
            'facility' => $facility
        ];

        $this->view('facilities/viewfacility', $data);
    }

    public function getFacilityData($id)
    {
        $facility = $this->facilityModel->getFacilityById($id);
        header('Content-Type: application/json');
        echo json_encode($facility);
        exit();
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete facility from database
            if ($this->facilityModel->deleteFacility($id)) {
                redirect('facilities');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('facilities');
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));

            // Check for duplicate name
            if ($this->facilityModel->findFacilityByNameExcept($data->name, $id)) {
                echo json_encode(['success' => false, 'message' => 'A facility with this name already exists']);
                return;
            }

            $facilityData = [
                'id' => $id,
                'name' => $data->name,
                'description' => $data->description,
                'capacity' => $data->capacity,
                'status' => $data->status
            ];

            if ($this->facilityModel->updateFacility($facilityData)) {
                flash('facility_message', 'Facility updated successfully', 'alert alert-success');
                echo json_encode(['success' => true]);
            } else {
                flash('facility_message', 'Failed to update facility', 'alert alert-danger');
                echo json_encode(['success' => false, 'message' => 'Failed to update facility']);
            }
        }
    }
    public function book($id)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get facility details
            $facility = $this->facilityModel->getFacilityById($id);

            $bookingData = [
                'facility_id' => $id,
                'facility_name' => $facility['name'],
                'user_id' => $_SESSION['user_id'],
                'booking_date' => $_POST['booking_date'],
                'booking_time' => $_POST['booking_time'],
                'duration' => $_POST['duration'],
                'booked_by' => $_SESSION['name'] // Get from session
            ];

            if ($this->facilityModel->createBooking($bookingData)) {
                $_SESSION['success_message'] = 'Facility booked successfully';
                redirect('facilities');
            } else {
                die('Something went wrong');
            }
        }

        $data = [
            'facility' => $this->facilityModel->getFacilityById($id)
        ];

        $this->view('facilities/book', $data);
    }
    public function getBookings($facilityId, $date)
    {
        $bookings = $this->facilityModel->getBookingsByDate($facilityId, $date);
        header('Content-Type: application/json');
        echo json_encode($bookings);
    }

    public function getUserBookings($facilityId, $date)
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([]);
            return;
        }

        $bookings = $this->facilityModel->getUserBookingsByDate(
            $_SESSION['user_id'],
            $facilityId,
            $date
        );

        header('Content-Type: application/json');
        echo json_encode($bookings);
    }


    public function allmybookings()
    {
        $user_id = $_SESSION['user_id'];
        $bookings = $this->facilityModel->getallmyBookings($user_id);

        $data = [
            'bookings' => $bookings
        ];

        $this->view('facilities/allmybookings', $data);
    }

    public function allbookings()
    {
        if ($_SESSION['user_role_id'] != 2) {
            redirect('facilities');
        }

        $bookings = $this->facilityModel->getAllBookings();
        $data = [
            'bookings' => $bookings
        ];

        $this->view('facilities/allbookings', $data);
    }
    public function updateBooking($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the POST data
            $data = json_decode(file_get_contents("php://input"));

            $bookingData = [
                'id' => $id,
                'booking_date' => $data->booking_date,
                'booking_time' => $data->booking_time,
                'duration' => $data->duration
            ];

            // Update booking in database through model
            if ($this->facilityModel->updateBooking($bookingData)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    public function cancelBooking($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->facilityModel->deleteBooking($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    public function getBookedTimeSlots($facilityId, $date)
    {
        $bookings = $this->facilityModel->getBookingsForDate($facilityId, $date);
        $occupiedSlots = [];

        foreach ($bookings as $booking) {
            $startTime = strtotime($booking->booking_time);
            $duration = $booking->duration;

            // Mark all slots within the duration as occupied
            for ($i = 0; $i < $duration; $i++) {
                $timeSlot = date('H:i', $startTime + ($i * 3600));
                $occupiedSlots[] = $timeSlot;
            }
        }

        return $occupiedSlots;
    }
    private function validateFacilityData($data)
    {
        $errors = [];

        // Sanitize inputs
        $name = htmlspecialchars(strip_tags($data['name']));
        $description = htmlspecialchars(strip_tags($data['description']));
        $capacity = filter_var($data['capacity'], FILTER_VALIDATE_INT);

        // Validate name
        if (strlen($name) < 3 || strlen($name) > 255) {
            $errors[] = 'Facility name must be between 3 and 255 characters';
        }

        // Validate description
        if (strlen($description) < 10) {
            $errors[] = 'Description must be at least 10 characters long';
        }

        // Validate capacity
        if ($capacity === false || $capacity < 1 || $capacity > 1000) {
            $errors[] = 'Invalid capacity value';
        }

        // Check for duplicate facility name
        $facilityModel = $this->facilityModel;
        if ($facilityModel->findFacilityByName($data['name'])) {
            $errors[] = 'A facility with this name already exists';
        }
        return $errors;
    }
    private function validateEditFacilityData($data, $currentFacilityId)
    {
        $errors = [];

        // Check if new name conflicts with existing facilities (excluding current facility)
        $facilityModel = $this->facilityModel;
        $existingFacility = $facilityModel->findFacilityByNameExcept($data['name'], $currentFacilityId);

        if ($existingFacility) {
            $errors[] = 'A facility with this name already exists';
        }

        return $errors;
    }
    public function checkOverlap()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));

            $overlappingBookings = $this->facilityModel->checkOverlappingBookings(
                $data->facilityId,
                $data->date,
                $data->startTime,
                $data->duration
            );

            header('Content-Type: application/json');
            echo json_encode([
                'hasOverlap' => !empty($overlappingBookings),
                'overlappingBookings' => $overlappingBookings
            ]);
        }
    }
}
