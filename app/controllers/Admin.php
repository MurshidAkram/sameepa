<?php

class Admin extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->checkAdminAuth();

        // Initialize any resident-specific models if needed
        // $this->residentModel = $this->model('M_Resident');
    }

    private function checkAdminAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 2) {
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
        $this->view('admin/dashboard', $data);
    }

    public function facilities()
    {
        // Load admin dashboard view
        $this->view('admin/facilities');
    }

    

    /*public function announcements()
    {
        // Load admin dashboard view
        $this->view('admin/announcements');
    }*/

    public function payments()
    {
        // Load admin dashboard view
        $this->view('admin/payments');
    }

    public function complaints()
    {
        // Load admin dashboard view
        $this->view('admin/complaints');
    }

    public function forums()
    {
        // Load admin dashboard view
        $this->view('admin/forums');
    }


    public function users()
    {
        // Load admin dashboard view
        $this->view('admin/users');
    }

    public function groups()
    {
        // Load admin dashboard view
        $this->view('admin/groups');
    }

    public function exchange()
    {
        // Load admin dashboard view
        $this->view('admin/exchange');
    }

    public function create_booking() {
        $this->view('admin/create_booking');
    }
    
    public function view_complaint_history(){
        $this->view('admin/view_complaint_history');
    }

    public function viewAnnouncementHistory() {
        $data = [
            'title' => 'Announcement History'
        ];
        $this->view('admin/view_announcement_history', $data);
    }

    public function view_event_history(){
        $this->view('admin/view_event_history');
    }

    public function view_facilities_history(){
        $this->view('admin/view_facilities_history');
    }
    public function create_announcement() {
         $this->view('admin/create_announcement');
    }
    public function create_facility() {
        $this->view('admin/create_facility');
    }
    public function create_event() {
        $this->view('admin/create_event');
    }
    public function create_new_user(){
        $this->view('admin/create_new_user');
    }
    public function create_forum(){
        $this->view('admin/create_forum');
    }

    public function create_group(){
        $this->view('admin/create_group');
    }

    public function view_forum(){
        $this->view('admin/view_forum');
    }
    public function view_group(){
        $this->view('admin/view_group');
    }

}


