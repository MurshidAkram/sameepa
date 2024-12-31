<?php
class Polls extends Controller
{
    protected $pollsModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if user has appropriate role
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            //flash('error', 'Unauthorized access');
            redirect('users/login');
        }

        $this->pollsModel = $this->model('M_Polls');
    }

    public function index()
    {

        $this->view('polls/index');
    }

    public function create()
    {
        $this->view('polls/create');
    }

    public function mypolls()
    {
        $this->view('polls/mypolls');
    }
}
