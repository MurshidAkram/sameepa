<?php
class Announcements extends Controller {
    private $announcementModel;

    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            exit();
        }

        // Check if user has appropriate role (1: Resident, 2: Admin, 3: SuperAdmin)
        if(!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            flash('error', 'Unauthorized access');
            redirect('users/login');
        }

        $this->announcementModel = $this->model('M_Announcements');
    }

    public function index() {
        
        $this->view('announcements/index');
    }
}