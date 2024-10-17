<?php

class Admin extends Controller
{
    public function dashboard()
    {
        // Load admin dashboard view
        $this->view('admin/dashboard');
    }

    public function facilities()
    {
        // Load admin dashboard view
        $this->view('admin/facilities');
    }

    public function events()
    {
        // Load admin dashboard view
        $this->view('admin/events');
    }

    public function announcements()
    {
        // Load admin dashboard view
        $this->view('admin/announcements');
    }

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

    public function viewEventHistory(){
        $this->view('admin/view_event_history');
    }

}