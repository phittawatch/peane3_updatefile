// Function to check if a switch is up or down using cURL with error handling for maximum execution time
function isSwitchUp($ip) {
    $url = "http://{$ip}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1); // Set a short connection timeout
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000); // Set a maximum overall timeout in milliseconds (adjust as needed)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    try {
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {
            // If the HTTP status code is not 200, consider the switch as down
            return false;
        }
    } catch (Exception $e) {
        // If an exception occurs (e.g., maximum execution time exceeded), consider the switch as down
        return false;
    } finally {
        curl_close($ch);
    }

    return true;
}
