
<?php
class Groups extends Controller
{
    protected $groupsModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if user has appropriate role
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3, 4, 5])) {
            redirect('users/login');
        }

        $this->groupsModel = $this->model('M_Groups');
    }

    public function index()
    {
        $this->view('groups/index');
    }

    public function create()
    {
        $this->view('groups/create');
    }

    public function joined()
    {
        $this->view('groups/joined');
    }
    public function my_groups()
    {
        $this->view('groups/my_groups');
    }
    public function viewgroup()
    {
        $this->view('groups/viewgroup');
    }
    public function update()
    {
        $this->view('groups/update');
    }
    public function chat()
    {
        $this->view('groups/chat');
    }
}
