<?php
$db = new SQLite3('../data.db');
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'read') {
        readAllRecords($db);
    } elseif ($action === 'get_locations') {
        readAllRecords($db);
    } else {
        http_response_code(400);
        echo json_encode(array('error' => 'Unknown action'));
    }
} else {
    // Handle the case where the "action" parameter is not set
    http_response_code(400);
    echo json_encode(array('error' => 'action parameter is missing'));
}

function readAllRecords($db) {
    $results = $db->query("
    SELECT 
        record_id, 
        records.name, 
        location, 
        date_start, 
        date_end,
        playtime,
        steam_appid,
        score,
        cover_img_path,
        note,
        records.status,
        replay,
        difficulty,
        score_id,
        gameplay,
        presentation,
        narrative,
        quality,
        sound,
        content,
        pacing,
        balance,
        ui_ux,
        impression,
        sum_target,
        sum_total,
        locations.name location_name
    FROM records
    INNER JOIN score
    ON records.score = score_id
    INNER JOIN locations
    ON records.location = locations.location_id
    ORDER BY date_end DESC
    ");

    $data = array(); // Initialize an array to store the result
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $data[] = $row; // Append each row to the result array
    }
    echo json_encode($data); // Encode the result array as JSON
}
?>
