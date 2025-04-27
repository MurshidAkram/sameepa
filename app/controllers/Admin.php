<?php

class Admin extends Controller
{

    private $announcementModel;
    private $eventModel;
    private $facilityModel;
    private $complaintModel;
    private $securityModel;
    private $adminModel;

    public function __construct()
    {
        $this->checkAdminAuth();

        // Initialize models
        $this->announcementModel = $this->model('M_Announcements');
        $this->eventModel = $this->model('M_Events');
        $this->facilityModel = $this->model('M_Facilities');
        $this->complaintModel = $this->model('M_Complaints');
        $this->adminModel = $this->model('M_admin_security_duties');
        $this->securityModel = $this->model('M_security');
    }

    private function checkAdminAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is an admin (role_id = 2)
        if ($_SESSION['user_role_id'] != 2) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

    public function dashboard()
    {
        // Get announcements
        $announcements = $this->announcementModel->getActiveAnnouncements();

        // Get upcoming events and sort by date and time
        $events = $this->eventModel->getEventsByStatus('upcoming');

        // Sort events by date and time (nearest first)
        usort($events, function ($a, $b) {
            $datetimeA = strtotime($a->date . ' ' . $a->time);
            $datetimeB = strtotime($b->date . ' ' . $b->time);
            $now = time();

            // Calculate time differences from now
            $diffA = $datetimeA - $now;
            $diffB = $datetimeB - $now;

            // Only consider future events
            if ($diffA < 0 && $diffB < 0) return 0;
            if ($diffA < 0) return 1;
            if ($diffB < 0) return -1;

            return $diffA - $diffB;
        });

        // Take only the first 5 nearest upcoming events
        $events = array_slice($events, 0, 5);

        // Get today's specific bookings
        $todayBookingsList = $this->facilityModel->getTodayBookings();

        // Get complaint stats
        $complaintStats = $this->complaintModel->getDashboardStats();
        $openComplaints = $complaintStats['pending'];
        $resolvedComplaints = $complaintStats['resolved'];

        // Get open and in-progress complaints
        $openComplaintsList = $this->complaintModel->getComplaintsByStatus('pending');
        $inProgressComplaintsList = $this->complaintModel->getComplaintsByStatus('in_progress');

        // Prepare data for the view
        $data = [
            'announcements' => $announcements,
            'events' => $events,
            'today_bookings_list' => $todayBookingsList,
            'open_complaints' => $openComplaints,
            'resolved_complaints' => $resolvedComplaints,
            'open_complaints_list' => $openComplaintsList,
            'in_progress_complaints_list' => $inProgressComplaintsList
        ];

        // Load admin dashboard view with data
        $this->view('admin/dashboard', $data);
    }


    //********************************** Security Duty Management **********************************

    public function Manage_security_duties()
    {
        // Get all security officers, shifts, and today's schedule
        $officers = $this->securityModel->getSecurityOfficers();
        $shifts = $this->securityModel->getShifts();
        $todaySchedule = $this->securityModel->getTodaySchedule();

        $data = [
            'officers' => $officers,
            'shifts' => $shifts,
            'todaySchedule' => $todaySchedule
        ];

        // Load the view with the schedule data
        $this->view('admin/Manage_security_duties', $data);
    }

    public function getOfficerDuties($officerId)
    {
        $duties = $this->securityModel->getOfficerDuties($officerId);

        header('Content-Type: application/json');
        echo json_encode($duties);
        exit;
    }

    public function addDuty()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'officer_id' => trim($_POST['officer_id']),
                'duty_date' => trim($_POST['duty_date']),
                'shift_id' => trim($_POST['shift_id']),
                'officer_id_err' => '',
                'duty_date_err' => '',
                'shift_id_err' => ''
            ];

            // Validate data
            if (empty($data['officer_id'])) {
                $data['officer_id_err'] = 'Please select an officer';
            }

            if (empty($data['duty_date'])) {
                $data['duty_date_err'] = 'Please select a date';
            } elseif (strtotime($data['duty_date']) < strtotime(date('Y-m-d'))) {
                $data['duty_date_err'] = 'Cannot assign duties for past dates';
            }

            if (empty($data['shift_id'])) {
                $data['shift_id_err'] = 'Please select a shift';
            }

            // Check if officer already has a duty on this date
            if ($this->securityModel->isOfficerScheduled($data['officer_id'], $data['duty_date'])) {
                $data['duty_date_err'] = 'This officer already has a duty on this date';
            }

            // Check if shift already has 3 officers
            if ($this->securityModel->getShiftCount($data['duty_date'], $data['shift_id']) >= 3) {
                $data['shift_id_err'] = 'This shift already has 3 officers assigned';
            }

            // Make sure no errors
            if (empty($data['officer_id_err']) && empty($data['duty_date_err']) && empty($data['shift_id_err'])) {
                // Add duty
                if ($this->securityModel->addDuty($data)) {
                    // Return success JSON
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Duty added successfully']);
                    exit;
                } else {
                    // Return error JSON
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
                    exit;
                }
            } else {
                // Return error JSON with validation messages
                $errors = [];
                if (!empty($data['officer_id_err'])) $errors[] = $data['officer_id_err'];
                if (!empty($data['duty_date_err'])) $errors[] = $data['duty_date_err'];
                if (!empty($data['shift_id_err'])) $errors[] = $data['shift_id_err'];

                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
                exit;
            }
        } else {
            // Redirect to security page if not POST
            redirect('admin/Manage_Duty_Schedule');
        }
    }

    public function editShift()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $officer_id = isset($_POST['officer_id']) ? $_POST['officer_id'] : null;
            $duty_date = isset($_POST['duty_date']) ? $_POST['duty_date'] : null;
            $new_shift_id = isset($_POST['new_shift_id']) ? $_POST['new_shift_id'] : null;

            if (!$officer_id || !$duty_date || !$new_shift_id) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                exit;
            }

            // Check if the new shift is already full
            if ($this->securityModel->isShiftFull($new_shift_id, $duty_date)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'This shift is already full']);
                exit;
            }

            if ($this->securityModel->UpdateShift($officer_id, $duty_date, $new_shift_id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Duty updated successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            }
            exit;
        } else {
            redirect('admin/Manage_Duty_Schedule');
        }
    }

    public function deleteDuty()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $officer_id = isset($_POST['officer_id']) ? $_POST['officer_id'] : null;
            $duty_date = isset($_POST['duty_date']) ? $_POST['duty_date'] : null;

            if (!$officer_id || !$duty_date) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                exit;
            }

            if ($this->securityModel->DeleteDuty($officer_id, $duty_date)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Duty removed successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            }
            exit;
        } else {
            redirect('admin/Manage_Duty_Schedule');
        }
    }

    public function getCalendarData($startDate, $endDate)
    {
        $schedule = $this->securityModel->getScheduleForPeriod($startDate, $endDate);

        header('Content-Type: application/json');
        echo json_encode($schedule);
        exit;
    }
}
