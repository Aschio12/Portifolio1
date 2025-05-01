<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set proper headers for AJAX response
header('Content-Type: application/json');

// Initialize response array
$response = array();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid email address'
        ];
        echo json_encode($response);
        exit;
    }
    
    // Validate message isn't empty
    if (empty($message)) {
        $response = [
            'status' => 'error',
            'message' => 'Message cannot be empty'
        ];
        echo json_encode($response);
        exit;
    }
    
    // Save to local file first (this works based on the test results)
    $submissions_dir = "submissions";
    if (!is_dir($submissions_dir)) {
        mkdir($submissions_dir, 0777, true);
    }
    
    $submission_data = "New message from: " . $email . "\n";
    $submission_data .= "Submitted on: " . date("Y-m-d H:i:s") . "\n";
    $submission_data .= "Message:\n" . $message . "\n";
    $submission_data .= "------------------------------------------------\n\n";
    
    file_put_contents($submissions_dir . "/contact_submissions.txt", $submission_data, FILE_APPEND);
    
    // Formspree submission using file_get_contents instead of cURL
    $formspree_url = "https://formspree.io/f/mzzebvjj";
    
    // Data to send to Formspree
    $formspree_data = http_build_query([
        'email' => $email,
        'message' => $message,
        '_subject' => 'New Contact Form Submission from Portfolio'
    ]);
    
    // Check if allow_url_fopen is enabled
    if (ini_get('allow_url_fopen')) {
        // Setup stream context
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => $formspree_data
            ]
        ];
        
        $context = stream_context_create($options);
        
        // Try to submit to Formspree
        $result = @file_get_contents($formspree_url, false, $context);
        
        // Check if submission was successful
        if ($result !== false) {
            $formspree_success = true;
        } else {
            $formspree_success = false;
        }
    } else {
        // If allow_url_fopen is disabled, we'll need to use a different approach
        $formspree_success = false;
    }
    
    // Response based on Formspree submission
    if ($formspree_success) {
        $response = [
            'status' => 'success',
            'message' => 'Your message has been sent. Thank you!'
        ];
    } else {
        // Even if Formspree fails, we saved locally
        $response = [
            'status' => 'success',
            'message' => 'Your message has been received. Thank you!'
        ];
    }
} else {
    // If not a POST request
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
}

// Return JSON response
echo json_encode($response);
?>