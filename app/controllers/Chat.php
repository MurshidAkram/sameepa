<?php
class Chat extends Controller
{
    protected $chatModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if user has appropriate role
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3, 4, 5])) {
            //flash('error', 'Unauthorized access');
            redirect('users/login');
        }

        $this->chatModel = $this->model('M_Chat');
    }

    public function index()
    {

        $this->view('chat/index');
    }
}
