<?php
$dbFile = 'projectdb.sqlite';

try {
    // Connect to SQLite database
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if projectId is provided
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['projectId'])) {
        $projectId = $_POST['projectId'];
        unset($_POST['projectId']); // remove projectId from the list of fields to update

        if (empty($_POST)) {
            echo "Keine Felder zum Aktualisieren übergeben.";
            exit;
        }

        // Prepare dynamic SQL statement for all received fields
        // the correct names are handled by the frontend
        $fields = [];
        foreach ($_POST as $key => $value) {
            $fields[] = "\"$key\" = :$key";
        }

        $sql = "UPDATE projects SET " . implode(", ", $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);

        // Bind all values and execute statement
        foreach ($_POST as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":id", $projectId, PDO::PARAM_INT);
        $stmt->execute();
        echo "Projekt $projectId erfolgreich aktualisiert.";
    } else {
        echo "Ungültige Anfrage.";
    }

} catch (PDOException $e) {
    echo "Fehler beim Speichern: " . $e->getMessage();
}
?>
