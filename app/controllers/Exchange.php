<?php
class Exchange extends Controller
{
    private $ExchangeModel;

    public function __construct()
    {
        // Check authentication
        $this->checkResidentAuth();
        
        // Initialize listing model
        $this->ExchangeModel = $this->model('M_Exchange');
    }

    private function checkResidentAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }
    }

    public function index()
    {
        try {
            // Get all listings
            $data = [
                'listings' => $this->ExchangeModel->getAllListings() ?: [], // Default to an empty array
                'search' => '' // Keep search if needed later
            ];

            // Load view with data
            $this->view('exchange/index', $data);

        } catch (Exception $e) {
            die('Something went wrong: ' . $e->getMessage());
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Initialize data array
            $data = [
                'title' => trim($_POST['title']),
                'type' => trim($_POST['type']),
                'description' => trim($_POST['description']),
                'image_data' => null,
                'image_type' => null,
                'posted_by' => $_SESSION['user_id'],
                'errors' => []
            ];

            // Handle image upload if present
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif','image/webp'];

                if (in_array($_FILES['image']['type'], $allowed)) {
                    // Read image data
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.';
                }
            }

            // Validate data
            $this->validateData($data);

            // If no errors, create listing
            if (empty($data['errors'])) {
                if ($this->ExchangeModel->createListing($data)) {
                    $_SESSION['message'] = 'Listing Created Successfully';
                    redirect('exchange/my_listings');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('exchange/create', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => '',
                'type' => '',
                'description' => '',
                'errors' => []
            ];

            $this->view('exchange/create', $data);
        }
    }

    private function validateData(&$data)
    {
        // Validate Title
        if (empty($data['title'])) {
            $data['errors'][] = 'Please enter listing title';
        } elseif (strlen($data['title']) > 255) {
            $data['errors'][] = 'Title cannot exceed 255 characters';
        }

        // Validate Description
        if (empty($data['description'])) {
            $data['errors'][] = 'Please enter listing description';
        }

        // Validate Type
        if (empty($data['type'])) {
            $data['errors'][] = 'Please select a listing type';
        }
    }

    // Method to display event images
    public function image($id)
    {
        $image = $this->ExchangeModel->getListingImage($id);

        if ($image && $image['image_data']) {
            header("Content-Type: " . $image['image_type']);
            echo $image['image_data'];
            exit;
        }

        // Return default image if no image found
        header("Content-Type: image/png");
        readfile(APPROOT . '/public/img/default.png');
    }

    public function my_listings() {
        try {
            $userId = $_SESSION['user_id'];
            $data = [
                'listings' => $this->ExchangeModel->getUserListings($userId) ?: []
            ];
            
            $this->view('exchange/my_listings', $data);
        } catch (Exception $e) {
            die('Something went wrong: ' . $e->getMessage());
        }
    }

    // Combined method to handle both displaying the update form and processing updates
    public function update_listing() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Display update form
            $listingId = isset($_GET['listing_id']) ? filter_var($_GET['listing_id'], FILTER_SANITIZE_NUMBER_INT) : null;
            
            if (!$listingId || !$this->ExchangeModel->isListingOwner($listingId, $_SESSION['user_id'])) {
                $_SESSION['error'] = 'Invalid listing or unauthorized access';
                redirect('exchange/my_listings');
                return;
            }
    
            $listing = $this->ExchangeModel->getListingById($listingId);
            
            if (!$listing) {
                $_SESSION['error'] = 'Listing not found';
                redirect('exchange/my_listings');
                return;
            }
    
            $data = [
                'id' => $listing['id'],
                'title' => $listing['title'],
                'description' => $listing['description'],
                'type' => $listing['type'],
                'errors' => []
            ];
    
            // Use the create view but with update data
            $this->view('exchange/create', $data);
        
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process the update
            // Initialize data array
            $data = [
                'id' => filter_var($_POST['listing_id'], FILTER_SANITIZE_NUMBER_INT),
                'title' => trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING)),
                'description' => trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)),
                'type' => trim(filter_var($_POST['type'], FILTER_SANITIZE_STRING)),
                'user_id' => $_SESSION['user_id'],
                'image_data' => null,
                'image_type' => null,
                'errors' => []
            ];
    
            // Validate owner
            if (!$this->ExchangeModel->isListingOwner($data['id'], $data['user_id'])) {
                $_SESSION['error'] = 'Unauthorized access';
                redirect('exchange/my_listings');
                return;
            }
    
            // Validate required fields
            if (empty($data['title'])) {
                $data['errors'][] = 'Title is required';
            }
            if (empty($data['description'])) {
                $data['errors'][] = 'Description is required';
            }
            if (empty($data['type'])) {
                $data['errors'][] = 'Type is required';
            }
    
            // Handle optional image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                
                if (in_array($_FILES['image']['type'], $allowed)) {
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG, GIF and WebP are allowed.';
                }
            }
    
            // Process update if no errors
            if (empty($data['errors'])) {
                if ($this->ExchangeModel->updateListing($data)) {
                    $_SESSION['message'] = 'Listing updated successfully!';
                    redirect('exchange/my_listings');
                } else {
                    $_SESSION['error'] = 'Failed to update listing';
                    // Reuse the create view with update data if error occurs
                    $this->view('exchange/create', $data);
                }
            } else {
                // Reload form with errors
                $this->view('exchange/create', $data);
            }
        } else {
            redirect('exchange/my_listings');
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['listing_id'])) {
            $listingId = filter_var($_POST['listing_id'], FILTER_SANITIZE_NUMBER_INT);
            
            // Check if user owns this listing
            if (!$this->ExchangeModel->isListingOwner($listingId, $_SESSION['user_id'])) {
                $_SESSION['error'] = 'Unauthorized access';
                redirect('exchange/my_listings');
                return;
            }

            if ($this->ExchangeModel->deleteListing($listingId)) {
                $_SESSION['message'] = 'Listing deleted successfully';
            } else {
                $_SESSION['error'] = 'Failed to delete listing';
            }
        }
        redirect('exchange/my_listings');
    }
    public function deleteid($id)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['user_role_id'] == 3) {
        if ($this->ExchangeModel->deleteListing($id)) {
            flash('listing_message', 'Listing removed');
            redirect('exchange/index');
        } else {
            die('Something went wrong');
        }
    } else {
        redirect('exchange/index');
    }
}

    public function view_listing($id) {
        $listing = $this->ExchangeModel->getListingById($id);
        
        if ($listing) {
            $data = [
                'listing' => $listing
            ];
    
            $this->view('exchange/view_listing', $data);
        } else {
            redirect('/exchange/index');
        }
    }

    public function contact_seller($id) {
        // Get the listing details
        $listing = $this->ExchangeModel->getListingById($id);
        
        if (!$listing) {
            // If listing doesn't exist, redirect to listings page
            redirect('/exchange/index');
        }
        
        // If it's a POST request, process the contact form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            // You would add code here to handle the form submission
            // Maybe send an email or create a message in your database
            
            // Redirect back with a success message
            $_SESSION['message'] = 'Your message has been sent!';
            redirect('/exchange/view_listing/' . $id);
        } else {
            // Display the contact form
            $data = [
                'listing' => $listing,
                'message' => '',
                'errors' => []
            ];
            
            $this->view('exchange/contact_seller', $data);
        }
    }
}