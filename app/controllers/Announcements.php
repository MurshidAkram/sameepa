<?php
class Announcements extends Controller
{
    private $announcementModel;

    public function __construct()
    {
        $this->announcementModel = $this->model('M_Announcements');
    }

    public function index()
    {
        $this->view('announcements/index');
    }
}
