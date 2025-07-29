<?php
// Verbindung zu SQLite-Datenbank
$pdo = new PDO('splite:zeiterfassung.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tabelle anlegen, falls nicht vorhanden
$pdo->exec("
    CREATE TABLE IF NOT EXISTS zeiterfassung (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        mitarbeiter_id INTEGER NOT NULL,
        projekt_id TEXT NOT NULL,
        beginn TEXT NOT NULL,
        ende TEXT NOT NULL,
        arbeitszeit_sekunden INTEGER NOT NULL
    )
");

// Formularverarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mitarbeiter_id = (int)$_POST['mitarbeiter_id'];
    $projekt_id = $_POST['projekt_id'];
    $beginn = new DateTime($_POST['beginn']);
    $ende = new DateTime($_POST['ende']);
    $arbeitszeit_sekunden = $ende->getTimestamp() - $beginn->getTimestamp();

    // In DB speichern
    $stmt = $pdo->prepare("
        INSERT INTO zeiterfassung (mitarbeiter_id, projekt_id, beginn, ende, arbeitszeit_sekunden)
        VALUES (:mitarbeiter_id, :projekt_id, :beginn, :ende, :arbeitszeit)
    ");
    $stmt->execute([
        ':mitarbeiter_id' => $mitarbeiter_id,
        ':projekt_id' => $projekt_id,
        ':beginn' => $beginn->format('Y-m-d H:i:s'),
        ':ende' => $ende->format('Y-m-d H:i:s'),
        ':arbeitszeit' => $arbeitszeit_sekunden
    ]);
}

// Daten abrufen
$eintraege = $pdo->query("SELECT * FROM zeiterfassung ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
    function setJetzt(feldId) {
        const now = new Date();
        const iso = now.toISOString().slice(0,16); // Format: YYYY-MM-DDTHH:MM
        document.getElementById(feldId).value = iso;
    }
</script>

