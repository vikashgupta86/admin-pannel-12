<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once './appcode/globals.inc.php'; 

try {
    $conn = db_connect(); 

    if (!$conn || $conn->connect_error) {
        throw new Exception("Database connection failed.");
    }

    $events = [];
    
    // Vibrant colors to ensure lines are distinct
    $lineColors = ['#E74C3C', '#2ECC71', '#3498DB', '#F1C40F', '#9B59B6', '#1ABC9C', '#E67E22'];
    $colorCount = count($lineColors);
    $i = 0;

    $sql = "SELECT event_id, event_name, event_start_date, event_end_date 
            FROM web_events 
            WHERE status = 'Active'
            ORDER BY event_start_date ASC"; // Ordering helps keep colors consistent
    
    $result = $conn->query($sql);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $start_ts = strtotime($row['event_start_date']);
            $end_ts = !empty($row['event_end_date']) ? strtotime($row['event_end_date']) : $start_ts;

            // Pick a color based on the current loop index
            $eventColor = $lineColors[$i % $colorCount];

            $events[] = [
                'id'    => $row['event_id'],
                'title' => $row['event_name'],
                'start' => date('Y-m-d', $start_ts),
                'end'   => date('Y-m-d', $end_ts),
                'allDay' => true,
                // These properties tell FullCalendar exactly what color to make the line
                'backgroundColor' => $eventColor,
                'borderColor' => $eventColor, 
                'textColor' => 'transparent', // Extra safety to hide text
                'extendedProps' => [
                    'tooltip' => "Event: " . $row['event_name'] . 
                                 "\nStart: " . date('M d, Y', $start_ts) . 
                                 "\nEnd: " . date('M d, Y', $end_ts)
                ]
            ];
            $i++;
        }
    }

    echo json_encode($events);

} catch (Throwable $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>