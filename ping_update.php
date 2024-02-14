<?php
include 'connect.php';

try {
    // Function to check if a server is up or down using cURL
    function isServerUp($ip) {
        $url = "http://{$ip}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Set connection timeout to 5 seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Set overall timeout to 5 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true); // Send a HEAD request
        
        // Execute the cURL request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Check for errors and timeouts
        if ($response === false || $httpCode !== 200) {
            // Mark server as 'Down' if there's an error or timeout
            return false;
        }

        curl_close($ch);
        return true; // Server is up
    }

    // Query to retrieve specific columns from the place_ne3 table
    $sql = "SELECT name_place, dell_name, dell_ip, riujie_name, riujie_ip, watchguard_name, watchguard_ip, zerotrust_name, zerotrust_ip, fortigate_name, fortigate_ip FROM place_ne3";
    $query = $conn->prepare($sql);
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    // Prepare for the update
    $updateSql = "UPDATE ping_results SET status = :status, timestamp = CURRENT_TIMESTAMP WHERE name_place_device = :name_place_device AND device_name = :device_name";
    $updateQuery = $conn->prepare($updateSql);

    // Bind parameters outside the loop
    $updateQuery->bindParam(':name_place_device', $namePlaceDevice, PDO::PARAM_STR);
    $updateQuery->bindParam(':device_name', $deviceName, PDO::PARAM_STR);
    $updateQuery->bindParam(':status', $status, PDO::PARAM_STR);

    foreach ($rows as $row) {
        // Update records for each device
        $namePlaceDevice = $row['name_place'];

        try {
            // Check the status of each server
            $dellStatus = isServerUp($row['dell_ip']);
            $riujieStatus = isServerUp($row['riujie_ip']);
            $watchguardStatus = isServerUp($row['watchguard_ip']);
            $zerotrustStatus = isServerUp($row['zerotrust_ip']);
            $fortigateStatus = isServerUp($row['fortigate_ip']);

            // Dell Device
            $deviceName = $row['dell_name'];
            $status = $dellStatus ? 'Up' : 'Down';
            $updateQuery->execute();

            // Riujie Device
            $deviceName = $row['riujie_name'];
            $status = $riujieStatus ? 'Up' : 'Down';
            $updateQuery->execute();

            // Watchguard Device
            $deviceName = $row['watchguard_name'];
            $status = $watchguardStatus ? 'Up' : 'Down';
            $updateQuery->execute();

            // Zerotrust Device
            $deviceName = $row['zerotrust_name'];
            $status = $zerotrustStatus ? 'Up' : 'Down';
            $updateQuery->execute();

            // Fortigate Device
            $deviceName = $row['fortigate_name'];
            $status = $fortigateStatus ? 'Up' : 'Down';
            $updateQuery->execute();
        } catch (Exception $e) {
            // Handle individual timeouts or errors
            // Log the error message or perform other actions if necessary
            // For now, we continue to the next iteration of the loop
            continue;
        }
    }

    // Commit the transaction
    $conn->commit();

    // Log success message
    error_log("Ping and update script ran successfully.", 0);
} catch (PDOException $e) {
    // Log the database error message
    error_log("Database error: " . $e->getMessage(), 0);
    // Optionally, you can also echo or log the error for debugging purposes
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    // Log the general error message
    error_log("General error: " . $e->getMessage(), 0);
    // Optionally, you can also echo or log the error for debugging purposes
    echo "Error: " . $e->getMessage();
}
?>
