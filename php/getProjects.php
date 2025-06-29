<?php
$db = new SQLite3('projectdb.sqlite');

$results = $db->query("SELECT id, A_projectName FROM projects");

$projects = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $projects[] = $row;
}

header('Content-Type: application/json');
echo json_encode($projects);