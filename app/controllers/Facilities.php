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
                'image_data' => null,
                'image_type' => null,
                'errors' => []
            ];
    
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE || 
                    $_FILES['image']['error'] === UPLOAD_ERR_FORM_SIZE) {
                    $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                } 
                else if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $data['errors'][] = 'There was an error uploading the image. Error code: ' . $_FILES['image']['error'];
                }
                else {
                    $maxSize = 1 * 1024 * 1024; // 1MB 
                    if ($_FILES['image']['size'] > $maxSize) {
                        $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                    } 
                    else {
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                            $data['errors'][] = 'Invalid file type. Only JPG, PNG, and GIF images are allowed.';
                        } 
                        else {
                            try {
                                $fileSize = filesize($_FILES['image']['tmp_name']);
                                
                                //  file size is within MySQL's max_allowed_packet limit
                                if ($fileSize > 1048576) { // 1MB 
                                    $data['errors'][] = 'Image is too large for database storage. Please use an image smaller than 1MB.';
                                } else {
                                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                                    $data['image_type'] = $_FILES['image']['type'];
                                }
                            } catch (Exception $e) {
                                $data['errors'][] = 'Error processing image: ' . $e->getMessage();
                            }
                        }
                    }
                }
            }
    
            if ($this->facilityModel->findFacilityByName($data['name'])) {
                $data['errors'][] = 'A facility with this name already exists';
            }
    
            if (empty($data['name'])) {
                $data['errors'][] = 'Please enter facility name';
            }
            if (empty($data['capacity'])) {
                $data['errors'][] = 'Please enter capacity';
            }
    
            if (empty($data['errors'])) {
                try {
                    if ($this->facilityModel->createFacility($data)) {
                        redirect('facilities/admin_dashboard');
                    }
                } catch (PDOException $e) {
                    if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                        $data['errors'][] = 'The image is too large for the database. Please use a smaller image (less than 1MB).';
                    } else {
                        $data['errors'][] = 'Database error: ' . $e->getMessage();
                    }
                    $this->view('facilities/create', $data);
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
              $facility = $this->facilityModel->getFacilityById($id);
              if (!$facility) {
                  flash('facility_message', 'Facility not found', 'alert alert-danger');
                  redirect('facilities/admin_dashboard');
                  return;
              }

              if ($this->facilityModel->hasActiveBookings($id)) {
                  flash('facility_message', 'Cannot delete facility with active bookings', 'alert alert-danger');
                  redirect('facilities/admin_dashboard');
                  return;
              }

              if ($this->facilityModel->deleteFacility($id)) {
                  flash('facility_message', 'Facility deleted successfully', 'alert alert-success');
                  redirect('facilities/admin_dashboard');
              } else {
                  flash('facility_message', 'Failed to delete facility', 'alert alert-danger');
                  redirect('facilities/admin_dashboard');
              }
          } else {
              redirect('facilities/admin_dashboard');
          }
      }

      public function viewFacilityDetails($id) {
        $facility = $this->facilityModel->getFacilityById($id);
        
        if(!$facility) {
            redirect('facilities');
        }
    
        $data = [
            'facility' => $facility,
            'bookings' => $this->facilityModel->getActiveBookingsForFacility($id),
            'total_bookings' => $this->facilityModel->getTotalBookingsCount($id)
        ];
    
        $this->view('facilities/view', $data);
    }
    
    public function edit($id)
    {
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('facilities');
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'capacity' => trim($_POST['capacity']),
                'status' => trim($_POST['status']),
                'image_data' => null,
                'image_type' => null,
                'errors' => []
            ];
    
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE || 
                    $_FILES['image']['error'] === UPLOAD_ERR_FORM_SIZE-1) {
                    $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                } 
                else if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $data['errors'][] = 'There was an error uploading the image. Error code: ' . $_FILES['image']['error'];
                }
                else {

                    $maxSize = 1 * 1024 * 1024; 
                    if ($_FILES['image']['size'] > $maxSize) {
                        $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                    } 
 
                    else {
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                            $data['errors'][] = 'Invalid file type. Only JPG, PNG, and GIF images are allowed.';
                        } 
                        else {
                            try {
                                $fileSize = filesize($_FILES['image']['tmp_name']);

                                if ($fileSize > 1048576) { 
                                    $data['errors'][] = 'Image is too large for database storage. Please use an image smaller than 1MB.';
                                } else {
                                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                                    $data['image_type'] = $_FILES['image']['type'];
                                }
                            } catch (Exception $e) {
                                $data['errors'][] = 'Error processing image: ' . $e->getMessage();
                            }
                        }
                    }
                }
            }
    
            if (empty($data['name'])) {
                $data['errors'][] = 'Please enter facility name';
            } elseif (strlen($data['name']) < 3) {
                $data['errors'][] = 'Name must be at least 3 characters';
            }
    
            if (empty($data['capacity'])) {
                $data['errors'][] = 'Please enter capacity';
            } elseif (!is_numeric($data['capacity']) || $data['capacity'] < 1) {
                $data['errors'][] = 'Capacity must be a positive number';
            }
    
            if ($this->facilityModel->findFacilityByNameExcept($data['name'], $id)) {
                $data['errors'][] = 'A facility with this name already exists';
            }
    
            if (empty($data['errors'])) {
                try {
                    if ($this->facilityModel->updateFacility($data)) {
                        flash('facility_message', 'Facility updated successfully');
                        redirect('facilities/admin_dashboard');
                    } else {
                        flash('facility_message', 'Something went wrong', 'alert alert-danger');
                        
                        $facility = $this->facilityModel->getFacilityById($id);
                        $data['facility'] = $facility;
                        
                        $this->view('facilities/edit_facility', $data);
                    }
                } catch (PDOException $e) {
                    if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                        $data['errors'][] = 'The image is too large for the database. Please use a smaller image (less than 1MB).';
                    } else {
                        $data['errors'][] = 'Database error: ' . $e->getMessage();
                    }
                    
                    $facility = $this->facilityModel->getFacilityById($id);
                    $data['facility'] = $facility;
                    
                    $this->view('facilities/edit_facility', $data);
                }
            } else {
                $facility = $this->facilityModel->getFacilityById($id);
                $data['facility'] = $facility;
                
                $this->view('facilities/edit_facility', $data);
            }
        } else {
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
    

    public function getImage($id) {
        $facility = $this->facilityModel->getFacilityImage($id);
        if ($facility && $facility['image_data']) {
            header("Content-Type: " . $facility['image_type']);
            echo $facility['image_data'];
            exit();
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
    
                if ($_SESSION['user_role_id'] == 1) {
                    redirect('facilities/index');
                } else if (in_array($_SESSION['user_role_id'], [2, 3])) {
                    redirect('facilities/allmybookings');
                } else {
                    redirect('/'); 
                }
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
            $bookingData = [
                'id' => $id,
                'booking_date' => $_POST['booking_date'],
                'booking_time' => $_POST['booking_time'],
                'duration' => $_POST['duration']
            ];
    
            if ($this->facilityModel->updateBooking($bookingData)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
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

        $name = htmlspecialchars(strip_tags($data['name']));
        $description = htmlspecialchars(strip_tags($data['description']));
        $capacity = filter_var($data['capacity'], FILTER_VALIDATE_INT);

        if (strlen($name) < 3 || strlen($name) > 255) {
            $errors[] = 'Facility name must be between 3 and 255 characters';
        }

        //description
        if (strlen($description) < 10) {
            $errors[] = 'Description must be at least 10 characters long';
        }

        //capacity
        if ($capacity === false || $capacity < 1 || $capacity > 1000) {
            $errors[] = 'Invalid capacity value';
        }

        //duplicate facility name
        $facilityModel = $this->facilityModel;
        if ($facilityModel->findFacilityByName($data['name'])) {
            $errors[] = 'A facility with this name already exists';
        }
        return $errors;
    }
    private function validateEditFacilityData($data, $currentFacilityId)
    {
        $errors = [];

        //new name conflicts with existing facilities 
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
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('pages/error');
        }

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
