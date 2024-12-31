<?php
class Listings extends Controller {
    private $listingModel;

    public function __construct() {
        $this->listingModel = $this->model('M_listing'); // Load the Listing model
    }

    // Display all listings
    public function index() {
        $listings = $this->listingModel->getListings();
        $data = [
            'listings' => $listings
        ];
        $this->view('resident/exchange', $data); // Load the exchange view with data
    }

    // Add a new listing
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form submission
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            $image = '';
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $target_dir = APPROOT . "/public/img/";
                $image = time() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
            }

            $data = [
                'title' => trim($_POST['title']),
                'type' => trim($_POST['type']),
                'description' => trim($_POST['description']),
                'image' => $image,
                'posted_by' => 'John Doe', // Replace with actual logged-in user
            ];

            if ($this->listingModel->addListing($data)) {
                redirect('listings'); // Redirect to the listings page
            } else {
                die('Something went wrong');
            }
        } else {
            // Load the create listing form
            $this->view('resident/create_listing');
        }
    }
}
