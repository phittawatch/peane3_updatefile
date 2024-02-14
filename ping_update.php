<?php
include 'connect.php';

try {
    // Function to check if a server is up or down using cURL
    function isServerUp($ip) {
        $url = "http://{$ip}";

        // Initialize cURL session
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // Set connection timeout to 3 seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Set overall timeout to 5 seconds
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        // Execute cURL request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Check for errors and timeout
        if ($response === false) {
            // Handle cURL errors
            $error = curl_error($ch);
            if (empty($error)) {
                return false; // Timeout occurred
            } else {
                error_log("cURL error: " . $error);
                return false; // Other cURL errors
            }
        }

        // Close cURL session
        curl_close($ch);

        // Check HTTP status code to determine server status
        return $httpCode == 200; // You can adjust the condition based on your server's response
    }

    // Your existing code for database queries and updating records goes here...

} catch (PDOException $e) {
    // Log database errors
    error_log("Database error: " . $e->getMessage(), 0);
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    // Log general errors
    error_log("General error: " . $e->getMessage(), 0);
    echo "Error: " . $e->getMessage();
}
?>
