<?php
$db = new SQLite3('mitarbeiterdb1.sqlite');

// Tabelle mit auto-increment integer id als Primärschlüssel
$db->exec("
CREATE TABLE IF NOT EXISTS mitarbeiter (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tarif_gruppe TEXT DEFAULT 'TG1',
    entgeltgruppe TEXT DEFAULT 'EG1',
    name TEXT,
    benutzername TEXT UNIQUE,
    email TEXT UNIQUE,
    passwort TEXT,
    entgelt_stunde REAL DEFAULT 20,
    monatsgehalt REAL DEFAULT 2000,
    ag TEXT DEFAULT 'AG1',
    jsz TEXT DEFAULT 'JSZ1',
    is_assigned_to TEXT DEFAULT 'unassigned'
);
");

// 📥 CSV-Import
if (isset($_FILES['csv']) && $_FILES['csv']['error'] === 0) {
    $ext = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);

    if (strtolower($ext) !== 'csv') {
        echo "<p style='color:red;'>❌ Nur CSV-Dateien erlaubt.</p>";
        exit();
    }

    $csv = fopen($_FILES['csv']['tmp_name'], 'r');
    fgetcsv($csv, 1000, ",");

    $stmt = $db->prepare("
        INSERT OR REPLACE INTO mitarbeiter (
            tarif_gruppe, entgeltgruppe, status, bezeichnungs_id, name,
            adresse, telefonnummer, benutzername, passwort,
            entgelt_stunde, monatsgehalt, ag, jsz, is_assigned_to
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    while (($row = fgetcsv($csv, 1000, ",")) !== false) {
        $row[8] = password_hash($row[8], PASSWORD_DEFAULT);
        for ($i = 0; $i < 14; $i++) {
            $stmt->bindValue($i + 1, $row[$i], SQLITE3_TEXT);
        }
        $stmt->execute();
    }

    fclose($csv);

    if ($stmt->execute()) {
        // JavaScript als Rückmeldung ausgeben
        echo "<script>
                alert('✅ Mitarbeiter erfolgreich gespeichert!');
                window.location.href = 'deine_startseite.html'; // optional Weiterleitung
              </script>";
        exit();
    } else {
        echo "<script>
                alert('❌ Fehler beim Speichern der Mitarbeiterdaten.');
              </script>";
    }
}

// ✍️ Manuelle Eingabe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['benutzername'], $_POST['passwort'])) {
    $stmt = $db->prepare("
        INSERT OR REPLACE INTO mitarbeiter (
            tarif_gruppe, entgeltgruppe, status, bezeichnungs_id, name,
            adresse, telefonnummer, benutzername, passwort,
            entgelt_stunde, monatsgehalt, ag, jsz, is_assigned_to
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bindValue(1, $_POST['tarif_gruppe'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(2, $_POST['entgeltgruppe'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(3, $_POST['status'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(4, $_POST['bezeichnungs_id'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(5, $_POST['name'], SQLITE3_TEXT);
    $stmt->bindValue(6, $_POST['adresse'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(7, $_POST['telefonnummer'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(8, $_POST['benutzername'], SQLITE3_TEXT);
    $stmt->bindValue(9, password_hash($_POST['passwort'], PASSWORD_DEFAULT), SQLITE3_TEXT);
    $stmt->bindValue(10, $_POST['entgelt_stunde'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(11, $_POST['monatsgehalt'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(12, $_POST['ag'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(13, $_POST['jsz'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(14, $_POST['is_assigned_to'] ?? '', SQLITE3_TEXT);

    if ($stmt->execute()) {
        // JavaScript als Rückmeldung ausgeben
        echo "<script>
                alert('✅ Mitarbeiter erfolgreich gespeichert!');
                window.location.href = 'deine_startseite.html'; // optional Weiterleitung
              </script>";
        exit();
    } else {
        echo "<script>
                alert('❌ Fehler beim Speichern der Mitarbeiterdaten.');
              </script>";
    }
}
?>