<?php
// IP address of the FortiGate firewall
$ipAddress = '172.22.217.241';

// SNMP community string (default is 'public' for read-only access)
$community = 'public';

// SNMP OID for system uptime
$sysUpTimeOID = '.1.3.6.1.2.1.1.3.0';

// SNMP OID for system description
$sysDescrOID = '.1.3.6.1.2.1.1.1.0';

// Create SNMP session
$session = new SNMP(SNMP::VERSION_2C, $ipAddress, $community);

// Get system uptime
$sysUpTime = $session->get($sysUpTimeOID);

// Get system description
$sysDescr = $session->get($sysDescrOID);

// Close SNMP session
$session->close();

// Output results
echo "System Uptime: $sysUpTime\n";
echo "System Description: $sysDescr\n";
?>
