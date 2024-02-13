<?php
// Include database connection file
include 'connect.php';

try {
    // SQL query to count distinct statuses
    $sql = "SELECT COUNT(DISTINCT CASE WHEN status = 'Up' THEN ip_address END) AS up_count, 
                   COUNT(DISTINCT CASE WHEN status = 'Down' THEN ip_address END) AS down_count 
            FROM ping_results WHERE ip_address IS NOT NULL";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Construct the JSON response
    $response = [
        'down_count' => $result['down_count'],
        'up_count' => $result['up_count']
    ];
    
    // Convert the fetched data to JSON format and output
    echo json_encode($response);
} catch (PDOException $e) {
    // Error handling
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

// Close database connection
$conn = null;
?>
