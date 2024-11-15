<?php
class Facilities extends Controller {
    private $facilityModel;

    public function __construct() {
        $this->facilityModel = $this->model('M_Facilities');
    }

    public function index() {
        $facilities = $this->facilityModel->getAllFacilities();
        $data = [
            'facilities' => $facilities
        ];
        $this->view('facilities/index', $data);
    }

    public function create() {
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

    public function viewFacility($id) {
        $facility = $this->facilityModel->getFacilityById($id);
        
        if (!$facility) {
            redirect('facilities');
        }
    
        $data = [
            'facility' => $facility
        ];
    
        $this->view('facilities/viewfacility', $data);
    }
    
    public function getFacilityData($id) {
        $facility = $this->facilityModel->getFacilityById($id);
        header('Content-Type: application/json');
        echo json_encode($facility);
        exit();
    }
    
    public function delete($id) {
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
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get raw posted data
            $data = json_decode(file_get_contents("php://input"));
        
            $facilityData = [
                'id' => $id,
                'name' => $data->name,
                'description' => $data->description,
                'capacity' => $data->capacity,
                'status' => $data->status
            ];

            if ($this->facilityModel->updateFacility($facilityData)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
      public function book($id) {
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
      public function getBookings($facilityId, $date) {
        $bookings = $this->facilityModel->getBookingsByDate($facilityId, $date);
        header('Content-Type: application/json');
        echo json_encode($bookings);
    }
    
    public function getUserBookings($facilityId, $date = null) {
        $bookings = $this->facilityModel->getUserBookings($_SESSION['user_id'], $facilityId, $date);
        header('Content-Type: application/json');
        echo json_encode($bookings);
    }    
}
