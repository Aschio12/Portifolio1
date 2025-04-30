<?php
// Define variables for email sending
$receiving_email = "aschalewdere2@gmail.com"; // Your email address
$subject = "New Contact Form Submission";

// Collect and sanitize form data
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid email
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

// Prepare email content
$email_content = "You have received a new message from your portfolio website.\n\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// Prepare email headers
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
if (mail($receiving_email, $subject, $email_content, $headers)) {
    // Email sent successfully
    $response = [
        'status' => 'success',
        'message' => 'Your message has been sent. Thank you!'
    ];
} else {
    // Failed to send email
    $response = [
        'status' => 'error',
        'message' => 'Sorry, there was an error sending your message. Please try again later.'
    ];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>