<?php
    header('Content-Type: application/json');
    require_once './appcode/globals.inc.php'; 
try {
    $events = [];
    
    $lineColors = ['#E74C3C', '#2ECC71', '#3498DB', '#F1C40F', '#9B59B6', '#1ABC9C', '#E67E22'];
    $colorCount = count($lineColors);
    $i = 0;

    $sql = "SELECT event_id, event_name, event_desc, event_start_date, event_end_date FROM web_events WHERE status = 'Active' ORDER BY event_start_date ASC"; 
    $result = simplefetch($sql);

    if ($result && isset($result[1])) {
        $rows = $result[1];
        foreach ($rows as $row) {
            $start_ts = strtotime($row['event_start_date']);
            $end_ts = !empty($row['event_end_date']) ? strtotime($row['event_end_date']) : $start_ts;
            $start_date = date('d-m-Y', $start_ts);
            $end_date = date('d-m-Y', $end_ts);
            $eventColor = $lineColors[$i % $colorCount];
            $textColor = ($eventColor === '#F1C40F') ? '#000000' : '#ffffff';
            $events[] = [
                'id'    => $row['event_id'],
                'title' => $row['event_name'],
                'start' => date('Y-m-d', $start_ts),
                'end'   => date('Y-m-d', $end_ts),
                'allDay' => true,
                'backgroundColor' => $eventColor,
                'borderColor' => $eventColor, 
                'textColor' => $textColor,
                'url' => 'event_calendar.php?view-event=' . md5($row['event_id']),
                'extendedProps' => [
                    'description' => nl2br(htmlspecialchars($row['event_desc'] ?? 'No description available.')),
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'tooltip' => "Event: " . $row['event_name']
                ]
            ];
            $i++;
        }
    }
    echo json_encode($events, JSON_PRETTY_PRINT);
} catch (Throwable $e) {
#    echo json_encode(["error" => $e->getMessage()]);
    echo json_encode(["error" => "Please contact web administrator."]);
}
?>