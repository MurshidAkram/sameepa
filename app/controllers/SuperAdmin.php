<?php

class SuperAdmin extends Controller
{
    private $superadminModel;
    private $userModel;
    private $eventModel;
    private $announcementModel;
    private $complaintModel;
    private $paymentModel;

    public function __construct()
    {
        // Load the necessary models
        $this->userModel = $this->model('M_Users');
        $this->eventModel = $this->model('M_Events');
        $this->announcementModel = $this->model('M_Announcements');
        // $this->complaintModel = $this->model('ComplaintModel');
        // $this->paymentModel = $this->model('PaymentModel');
    }

    public function index()
    {
        try {
            // Fetch data for the dashboard
            $activeUsers = $this->getActiveUsers();
            $todayEvents = $this->getTodayEvents();
            $announcements = $this->getActiveAnnouncements();
            $complaintsStats = $this->getMonthlyComplaintStats();
            $payments = $this->getPaymentStats();
            $bookings = $this->getTodaysBookings();

            // Prepare data array
            $data = [
                'activeUsers' => $activeUsers,
                'todayEvents' => $todayEvents,
                'announcements' => $announcements,
                'complaintsStats' => $complaintsStats,
                'payments' => $payments,
                'bookings' => $bookings
            ];

            // Load the view
            $this->view('admin_dashboard', $data);
        } catch (Exception $e) {
            die("An error occurred: " . $e->getMessage());
        }
    }

    private function getActiveUsers()
{
    $users = $this->userModel->getActiveUsers();
    var_dump($users); // Debug: Check the returned count
    die; // Ensure it stops here for testing
    return $users;
}



    private function getTodayEvents()
    {
        return $this->eventModel->getTodayEvents();
    }

    private function getActiveAnnouncements()
    {
        return $this->announcementModel->getActiveAnnouncements();
    }

    private function getMonthlyComplaintStats()
    {
        return $this->complaintModel->getMonthlyComplaintStats();
    }

    private function getPaymentStats()
    {
        return $this->paymentModel->getPaymentStats();
    }

    private function getTodaysBookings()
    {
        return $this->eventModel->getTodaysBookings();
    }
    


    private function checkSuperAdminAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 3) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

    public function dashboard()
    {
        // Get any necessary data for the dashboard
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];

        // Load resident dashboard view with data
        $this->view('superadmin/dashboard', $data);
    }


    public function reports()
    {
        // Load the Settings view
        $this->view('superadmin/reports');
    }
   
}
