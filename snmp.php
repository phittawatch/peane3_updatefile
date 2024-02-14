<?php
include 'connect.php';

try {
    // Function to check if a switch is up or down using SNMP
    function isSwitchUp($ip, $community) {
        $session = new SNMP(SNMP::VERSION_2C, $ip, $community, 1000000); // Increase timeout to 1 second
        $response = $session->get('SNMPv2-MIB::sysUpTime.0');

        return $response !== false; // You can adjust the condition based on the response
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
        // Check the status of each switch
        $dellStatus = isSwitchUp($row['dell_ip'], 'public');
        $riujieStatus = isSwitchUp($row['riujie_ip'], 'public');
        $watchguardStatus = isSwitchUp($row['watchguard_ip'], 'public');
        $zerotrustStatus = isSwitchUp($row['zerotrust_ip'], 'public');
        $fortigateStatus = isSwitchUp($row['fortigate_ip'], 'public');

        // Update records for each device
        $namePlaceDevice = $row['name_place'];

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
    }

    // Commit the transaction
    $conn->commit();

    // Log success message
    error_log("SNMP query and update script ran successfully.", 0);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="300"> <!-- Refresh every 300 seconds (adjust as needed) -->
    <title>Switch Status Update</title>
    <h1>Switch Status Update Successfully</h1>
</head>
<body>

<!-- Your HTML content goes here -->

</body>
</html>
