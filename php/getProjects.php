<?php
$db = new SQLite3('projectdb.sqlite');
$results = $db->query("SELECT id, A_projectName FROM projects");

// Fetch all projects into an array
$projects = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $projects[] = $row;
}

// Return the projects as a JSON response
header('Content-Type: application/json');
echo json_encode($projects);