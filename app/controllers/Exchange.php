
<?php
class Exchange extends Controller
{
    protected $exchangeModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if user has appropriate role
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            redirect('users/login');
        }

        $this->exchangeModel = $this->model('M_Exchange');
    }

    public function index()
    {
        $this->view('exchange/index');
    }

    public function create()
    {
        $this->view('exchange/create');
    }

    public function view_listing($id = null)
    {
        $this->view('exchange/view_listing');
    }

    public function my_listings()
    {
        $this->view('exchange/my_listings');
    }

    public function edit_listing($id = null)
    {
        $this->view('exchange/edit_listing');
    }

    public function delete_listing($id = null)
    {
        $this->view('exchange/delete_listing');
    }

    public function search()
    {
        $this->view('exchange/search');
    }

    public function contact_seller()
    {
    $this->view('exchange/contact_seller');
    }

}
