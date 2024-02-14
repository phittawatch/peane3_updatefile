// Function to check if a switch is up or down using cURL with a maximum timeout
function isSwitchUp($ip) {
    $url = "http://{$ip}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1); // Set a short connection timeout
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Set a maximum overall timeout (adjust as needed)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode != 200) {
        // If the HTTP status code is not 200, consider the switch as down
        return false;
    }

    curl_close($ch);

    return true;
}
