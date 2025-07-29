<?php
$dbFile = 'projectdb.sqlite';
header('Content-Type: application/json');

try {
    // Connect to SQLite database
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if projectId is provided
    if (!isset($_GET['projectId'])) {
        echo json_encode(['error' => 'projectId fehlt']);
        exit;
    }

    // get projectId
    $projectId = (int) $_GET['projectId'];

    // Prepare and execute the query to fetch project data of the corresponding projectId
    $stmt = $db->prepare("SELECT * FROM projects WHERE id = :id");
    $stmt->bindValue(':id', $projectId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    //send back the project data as JSON
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Projekt nicht gefunden']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Fehler: ' . $e->getMessage()]);
}
?>
