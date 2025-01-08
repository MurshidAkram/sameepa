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
                    redirect('facilities/admin_dashboard');
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
            redirect('facilities/admin_dashboard');
        }

        $data = [
            'facility' => $facility
        ];

        $this->view('facilities/view', $data);
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
              // Check if facility exists
              $facility = $this->facilityModel->getFacilityById($id);
              if (!$facility) {
                  echo json_encode(['success' => false, 'message' => 'Facility not found']);
                  return;
              }

              // Check for existing bookings
              if ($this->facilityModel->hasActiveBookings($id)) {
                  echo json_encode([
                      'success' => false, 
                      'message' => 'Cannot delete facility with active bookings'
                  ]);
                  return;
              }

              if ($this->facilityModel->deleteFacility($id)) {
                  echo json_encode([
                      'success' => true,
                      'message' => 'Facility deleted successfully'
                  ]);
                  redirect('facilities/admin_dashboard');
              } else {
                  echo json_encode([
                      'success' => false,
                      'message' => 'Failed to delete facility'
                  ]);
              }
          } else {
              redirect('facilities/admin_dashboard');
          }
      }

      public function viewFacilityDetails($id) {
        // Check if facility exists
        $facility = $this->facilityModel->getFacilityById($id);
        
        if(!$facility) {
            redirect('facilities');
        }
    
        // Get additional facility data if needed
        $data = [
            'facility' => $facility,
            'bookings' => $this->facilityModel->getActiveBookingsForFacility($id),
            'total_bookings' => $this->facilityModel->getTotalBookingsCount($id)
        ];
    
        $this->view('facilities/view', $data);
    }
    

    public function edit($id)
    {
        // Check admin permission
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('facilities');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'capacity' => trim($_POST['capacity']),
                'status' => trim($_POST['status']),
                'errors' => []
            ];

            // Validate name
            if (empty($data['name'])) {
                $data['errors'][] = 'Please enter facility name';
            } elseif (strlen($data['name']) < 3) {
                $data['errors'][] = 'Name must be at least 3 characters';
            }

            // Validate capacity
            if (empty($data['capacity'])) {
                $data['errors'][] = 'Please enter capacity';
            } elseif (!is_numeric($data['capacity']) || $data['capacity'] < 1) {
                $data['errors'][] = 'Capacity must be a positive number';
            }

            // Check for duplicate name
            if ($this->facilityModel->findFacilityByNameExcept($data['name'], $id)) {
                $data['errors'][] = 'A facility with this name already exists';
            }

            if (empty($data['errors'])) {
                if ($this->facilityModel->updateFacility($data)) {
                    flash('facility_message', 'Facility updated successfully');
                    redirect('facilities/admin_dashboard');
                } else {
                    flash('facility_message', 'Something went wrong', 'alert alert-danger');
                    $this->view('facilities/edit_facility', $data);
                }
            } else {
                // Load view with errors
                $this->view('facilities/edit_facility', $data);
            }
        } else {
            // GET request - show edit form
            $facility = $this->facilityModel->getFacilityById($id);
            
            if (!$facility) {
                redirect('facilities/admin_dashboard');
            }

            $data = [
                'facility' => $facility,
                'errors' => []
            ];

            $this->view('facilities/edit_facility', $data);
        }
    }

    public function book($id)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $facility = $this->facilityModel->getFacilityById($id);
            
            $bookingData = [
                'facility_id' => $id,
                'facility_name' => $facility['name'],
                'booking_date' => $_POST['booking_date'],
                'booking_time' => $_POST['booking_time'],
                'duration' => $_POST['duration']
            ];

            // Check for overlaps before creating booking
            $overlap = $this->facilityModel->checkBookingOverlap(
                $id,
                $bookingData['booking_date'],
                $bookingData['booking_time'],
                $bookingData['duration']
            );

            if ($overlap) {
                $_SESSION['error_message'] = 'This time slot is already booked';
                redirect('facilities/book/' . $id);
                return;
            }

            if ($this->facilityModel->createBooking($bookingData)) {
                $_SESSION['success_message'] = 'Facility booked successfully';
                redirect('facilities');
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
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('facilities/index');
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

    private function isAdmin()
    {
        return isset($_SESSION['user_role_id']) && 
            in_array($_SESSION['user_role_id'], [2, 3]);
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
    public function getBookedTimes($facilityId, $date) {
        $bookings = $this->facilityModel->getBookedTimesByDate($facilityId, $date);
        header('Content-Type: application/json');
        echo json_encode($bookings);
    }

    public function checkOverlap() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            
            $conflictingBooking = $this->facilityModel->checkBookingOverlap(
                $data->facilityId,
                $data->date,
                $data->time,
                $data->duration
            );
            
            header('Content-Type: application/json');
            echo json_encode([
                'hasOverlap' => !empty($conflictingBooking),
                'conflictingBooking' => $conflictingBooking
            ]);
        }
    }
    public function admin_dashboard()
    {
        // Check for admin access
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('pages/error');
        }

        // Get statistics
        $facilities = $this->facilityModel->getAllFacilities();
        $activeBookings = $this->facilityModel->getActiveBookingsCount();
        $totalCapacity = 0;
        $availableFacilities = 0;

        foreach($facilities as $facility) {
            $totalCapacity += $facility->capacity;
            if($facility->status === 'available') {
                $availableFacilities++;
            }
        }

        $data = [
            'facilities' => $facilities,
            'active_bookings' => $activeBookings,
            'total_capacity' => $totalCapacity,
            'available_facilities' => $availableFacilities
        ];

        $this->view('facilities/admin_dashboard', $data);
    }

    public function searchFacilities()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = trim($_POST['search']);
            $facilities = $this->facilityModel->searchFacilities($searchTerm);
            
            header('Content-Type: application/json');
            echo json_encode($facilities);
        }
    }

    public function filterFacilities()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $facilities = $this->facilityModel->filterFacilitiesByStatus($status);
            
            header('Content-Type: application/json');
            echo json_encode($facilities);
        }
    }
}
