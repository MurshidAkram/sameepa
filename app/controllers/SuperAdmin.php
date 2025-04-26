<?php
class SuperAdmin extends Controller {
    private $userModel;
    private $announcementModel;
    private $eventModel;
    private $faciltyModel;
    private $complaintModel;


    
    public function __construct() {
        $this->checkSuperAdminAuth();
        
        // Initialize the SuperAdmin model
        $this->announcementModel = $this->model('M_Announcements');
        $this->eventModel = $this->model('M_Events');
        $this->faciltyModel = $this->model('M_Facilities');
        $this->userModel = $this->model('M_Users');
        $this->complaintModel= $this->model('M_Complaints');


    }
    
    private function checkSuperAdminAuth() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }
        
        // Check if user is a super admin (role_id = 3)
        if ($_SESSION['user_role_id'] != 3) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }
    
    public function dashboard() {
        // Get data for the dashboard
        $bookings = $this->faciltyModel->getTodaysBookings();
        $announcement = $this->announcementModel->getActiveAnnouncements();
        $todayEvents = $this->eventModel->getTodaysEvents();
        // $payments = $this->superadminModel->getPaymentStats();
        $activeUsers = $this->userModel->getActiveUsersCount();
        $complaints=$this->complaintModel->getComplaints();
        
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role'],
            'bookings' => $bookings,
            'announcement' => $announcement,
            'todayEvents' => $todayEvents,
            // 'payments' => $payments,
            'activeUsers' => $activeUsers,
            'complaints'=>$complaints
        ];
        
        // Load super admin dashboard view with data
        $this->view('superadmin/dashboard', $data);
    }
    
    public function payments() {
        // Load the Payments view
        $this->view('superadmin/payments');
    }
    
    public function create_payment() {
        $this->view('superadmin/create_payment');
    }
    
    public function reports() {
        // Load the Reports view
        $this->view('superadmin/reports');
    }
}