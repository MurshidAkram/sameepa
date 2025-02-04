<?php

class SuperAdmin extends Controller
{

    private $userModel;
    private $facilityModel;
    private $eventModel;
    private $announcementModel;
    
    public function __construct()
    {
        // Load the necessary models
        $this->userModel = $this->model('M_Users');
        $this->facilityModel = $this->model('M_Facilities');
        $this->eventModel = $this->model('M_Events');
        $this->announcementModel = $this->model('M_Announcements');
       
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
        // Get active users count
        $activeCount = $this->userModel->getActiveUsers();
        $todayBookings = $this->facilityModel->getTodayBookings();
        $todayEvents = $this->eventModel->getTodayEvents();
        $announcements = $this->announcementModel->getActiveAnnouncements();

        
        $data = [
            'activeUsers' => $activeCount,
            'bookings' => $todayBookings,
            'todayEvents' => $todayEvents,
            'announcement' => $announcements

        ];

        $this->view('superadmin/dashboard', $data);
    }


    public function reports()
    {
        // Load the Settings view
        $this->view('superadmin/reports');
    }
   
}
