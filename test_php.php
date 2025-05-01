<?php

header('Content-Type: text/html');

// Check PHP version
echo "<h2>PHP Environment Test</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// Check if cURL is available (required for form processing)
echo "<p>cURL Support: ";
if (function_exists('curl_version')) {
    $curl_info = curl_version();
    echo "Available (version " . $curl_info['version'] . ")</p>";
} else {
    echo "Not available - cURL is required for the contact form!</p>";
}

// Check if directories are writable (for submissions log)
echo "<p>Submission directory writability: ";
$submissions_dir = "submissions";
if (!is_dir($submissions_dir)) {
    if (mkdir($submissions_dir, 0777, true)) {
        echo "Created successfully</p>";
    } else {
        echo "Failed to create - check permissions</p>";
    }
} else {
    if (is_writable($submissions_dir)) {
        echo "Writable</p>";
    } else {
        echo "Not writable - check permissions</p>";
    }
}

// Test if JSON functions work
echo "<p>JSON Support: ";
if (function_exists('json_encode') && function_exists('json_decode')) {
    echo "Available</p>";
} else {
    echo "Not available - JSON functions are required!</p>";
}

echo "<hr><p>If all tests pass, your PHP environment should be able to handle the contact form.</p>";
?>