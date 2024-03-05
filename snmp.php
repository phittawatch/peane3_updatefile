<?php
// SNMP community string (default is "public")
$community = "public";

// IP address of the switch
$switch_ip = "172.22.217.241";

// SNMP OID for system description (sysDescr)
$oid_sys_descr = "1.3.6.1.2.1.1.1.0"; // Numeric OID for sysDescr

// SNMP OID for system uptime
$oid_sys_uptime = "1.3.6.1.2.1.1.3.0"; // OID for sysUpTime

// Interval between SNMP queries (in seconds)
$interval = 5; // adjust as needed

while (true) {
    // Create an SNMP session
    $session = new SNMP(SNMP::VERSION_2C, $switch_ip, $community);

    // Get the system description
    $sys_descr = $session->get($oid_sys_descr);

    // Get the system uptime
    $sys_uptime = $session->get($oid_sys_uptime);

    // Close the SNMP session
    $session->close();

    // Display the results
    echo "Switch IP: " . $switch_ip . "<br>";
    echo "System Description: " . $sys_descr . "<br>";
    echo "System Uptime: " . formatUptime($sys_uptime) . "<br>"; // Format uptime
    echo "<hr>";

    // Wait for the specified interval before the next SNMP query
    sleep($interval);
}

// Function to format uptime in human-readable format
function formatUptime($uptime) {
    $uptimeSeconds = intval($uptime) / 100; // Convert uptime to seconds (assuming it's in 1/100th of seconds)
    $days = floor($uptimeSeconds / (24 * 3600));
    $hours = floor(($uptimeSeconds % (24 * 3600)) / 3600);
    $minutes = floor(($uptimeSeconds % 3600) / 60);
    $seconds = $uptimeSeconds % 60;
    return "{$days} days, {$hours} hours, {$minutes} minutes, {$seconds} seconds";
}
?>
