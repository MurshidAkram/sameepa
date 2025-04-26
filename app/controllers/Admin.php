<?php

class Admin extends Controller
{

    private $announcementModel;
    private $eventModel;
    private $facilityModel;
    private $complaintModel;


    public function __construct()
    {
        $this->checkAdminAuth();

        // Initialize models
        $this->announcementModel = $this->model('M_Announcements');
        $this->eventModel = $this->model('M_Events');
        $this->facilityModel = $this->model('M_Facilities');
        $this->complaintModel = $this->model('M_Complaints');
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
        usort($events, function($a, $b) {
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

        // Get facility stats
        $todayBookings = $this->facilityModel->getActiveBookingsCount();
        $totalFacilities = $this->facilityModel->getAllFacilities();
        $totalFacilities = count($totalFacilities);

        // Get complaint stats
        $complaintStats = $this->complaintModel->getDashboardStats();
        $openComplaints = $complaintStats['pending'];
        $resolvedComplaints = $complaintStats['resolved'];

        // Prepare data for the view
        $data = [
            'announcements' => $announcements,
            'events' => $events,
            'today_bookings' => $todayBookings,
            'total_facilities' => $totalFacilities,
            'open_complaints' => $openComplaints,
            'resolved_complaints' => $resolvedComplaints
        ];

        // Load admin dashboard view with data
        $this->view('admin/dashboard', $data);
    }


}


