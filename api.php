<?php

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $json_data = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($json_data);

    // Check if the JSON data is valid
    if ($data !== null) {
        // Make a request to Artbreeder API
        $url = 'https://www.artbreeder.com/api/realTimeJobs';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the request was successful
        if ($response !== false) {
            // Return the response
            echo $response;
        } else {
            // Error making the request
            http_response_code(500); // Internal Server Error
            echo json_encode(array('error' => 'Error making request to Artbreeder API'));
        }
    } else {
        // Invalid JSON data
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Invalid JSON data'));
    }
} else {
    // Not a POST request
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method Not Allowed'));
}

?>
