<?php
$dbFile = 'projectdb.sqlite';

try {
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['projectId'])) {
        $projectId = $_POST['projectId'];
        unset($_POST['projectId']); // remove it from the update list

        if (empty($_POST)) {
            echo "Keine Felder zum Aktualisieren übergeben.";
            exit;
        }

        // Prepare dynamic SQL statement
        $fields = [];
        foreach ($_POST as $key => $value) {
            // Use double quotes for column names like "1_projektTitel"
            $fields[] = "\"$key\" = :$key";
        }

        $sql = "UPDATE projects SET " . implode(", ", $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);

        // Bind all values
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
