// Function to check if a switch is up or down using cURL with error handling for maximum execution time
function isSwitchUp($ip) {
    $url = "http://{$ip}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1); // Set a short connection timeout
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Set a maximum overall timeout in seconds (adjust as needed)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $errorCode = curl_errno($ch);

    curl_close($ch);

    if ($errorCode === CURLE_OPERATION_TIMEDOUT) {
        // If the request timed out, consider the switch as down
        return false;
    } elseif ($httpCode != 200) {
        // If the HTTP status code is not 200, consider the switch as down
        return false;
    }

    return true;
}
