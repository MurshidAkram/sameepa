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
        // Get all polls from the database
        $polls = $this->pollsModel->getAllPolls();

        // Prepare data for each poll
        foreach ($polls as &$poll) {
            // Check if poll has ended
            $poll->has_ended = $this->pollsModel->hasPollEnded($poll->end_date);

            // Check if current user has voted
            if (isset($_SESSION['user_id'])) {
                $userVote = $this->pollsModel->getUserVote($poll->id, $_SESSION['user_id']);
                $poll->user_has_voted = !empty($userVote);
            } else {
                $poll->user_has_voted = false;
            }
        }

        $data = [
            'polls' => $polls,
            'title' => 'Community Polls'
        ];

        $this->view('polls/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data array
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'end_date' => trim($_POST['end_date']),
                'choices' => isset($_POST['choices']) ? $_POST['choices'] : [],
                'created_by' => $_SESSION['user_id'],
                'title_err' => '',
                'description_err' => '',
                'end_date_err' => '',
                'choices_err' => ''
            ];

            // Validate Title
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter a poll title';
            } elseif (strlen($data['title']) > 255) {
                $data['title_err'] = 'Title cannot exceed 255 characters';
            }

            // Validate Description (optional)
            if (!empty($data['description']) && strlen($data['description']) > 1000) {
                $data['description_err'] = 'Description cannot exceed 1000 characters';
            }

            // Validate End Date
            if (empty($data['end_date'])) {
                $data['end_date_err'] = 'Please select an end date';
            } else {
                $end_date = new DateTime($data['end_date']);
                $today = new DateTime();
                if ($end_date <= $today) {
                    $data['end_date_err'] = 'End date must be in the future';
                }
            }

            // Validate Choices
            if (empty($data['choices'])) {
                $data['choices_err'] = 'Please add at least two choices';
            } else {
                // Remove empty choices
                $data['choices'] = array_filter($data['choices'], 'trim');

                if (count($data['choices']) < 2) {
                    $data['choices_err'] = 'Please add at least two choices';
                } elseif (count($data['choices']) > 5) {
                    $data['choices_err'] = 'Maximum 5 choices allowed';
                }
            }

            // Make sure no errors
            if (
                empty($data['title_err']) && empty($data['description_err']) &&
                empty($data['end_date_err']) && empty($data['choices_err'])
            ) {

                // Validated
                if ($this->pollsModel->createPoll($data)) {
                    flash('poll_message', 'Poll Created Successfully');
                    redirect('polls');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('polls/create', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => '',
                'description' => '',
                'end_date' => '',
                'choices' => [],
                'title_err' => '',
                'description_err' => '',
                'end_date_err' => '',
                'choices_err' => ''
            ];

            // Load view
            $this->view('polls/create', $data);
        }
    }
    public function mypolls()
    {
        $this->view('polls/mypolls');
    }

    public function viewpoll($id)
    {
        // Get poll details
        $poll = $this->pollsModel->getPollById($id);

        if (!$poll) {
            redirect('polls');
        }

        // Get poll choices with vote counts
        $choices = $this->pollsModel->getPollChoices($id);

        // Calculate percentages and get voters for each choice
        $totalVotes = 0;
        foreach ($choices as &$choice) {
            $totalVotes += $choice->vote_count;
        }

        foreach ($choices as &$choice) {
            $choice->percentage = $totalVotes > 0 ?
                round(($choice->vote_count / $totalVotes) * 100, 1) : 0;
            $choice->voters = $this->pollsModel->getVotersByChoice($choice->id);
        }

        // Check if user has voted
        $userVote = null;
        if (isset($_SESSION['user_id'])) {
            $userVote = $this->pollsModel->getCurrentUserVote($id, $_SESSION['user_id']);
        }

        // Check if poll has ended
        $hasEnded = strtotime($poll['end_date']) < strtotime('today');

        $data = [
            'poll' => $poll,
            'choices' => $choices,
            'user_vote' => $userVote,
            'has_ended' => $hasEnded,
            'total_votes' => $totalVotes
        ];

        $this->view('polls/viewpoll', $data);
    }

    public function vote($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect('polls');
        }

        $pollId = $id;
        $choiceId = $_POST['choice_id'] ?? null;

        if (!$choiceId) {
            flash('poll_error', 'Please select an option to vote');
            redirect("polls/viewpoll/$pollId");
        }

        $poll = $this->pollsModel->getPollById($pollId);

        // Check if poll has ended
        if (strtotime($poll['end_date']) < strtotime('today')) {
            flash('poll_error', 'This poll has ended');
            redirect("polls/viewpoll/$pollId");
        }

        // Record the vote
        if ($this->pollsModel->votepoll($pollId, $choiceId, $_SESSION['user_id'])) {
            flash('poll_message', 'Your vote has been recorded');
        } else {
            flash('poll_error', 'Something went wrong recording your vote');
        }

        redirect("polls/viewpoll/$pollId");
    }

    public function edit()
    {
        $this->view('polls/edit');
    }
}
