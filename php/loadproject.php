<?php
$dbFile = 'projectdb.sqlite';

header('Content-Type: application/json');

try {
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['projectId'])) {
        echo json_encode(['error' => 'projectId fehlt']);
        exit;
    }

    $projectId = (int) $_GET['projectId'];

    $stmt = $db->prepare("SELECT * FROM projects WHERE id = :id");
    $stmt->bindValue(':id', $projectId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Projekt nicht gefunden']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Fehler: ' . $e->getMessage()]);
}
?>
