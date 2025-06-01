<?php

// 🔢 Projektbezogene Angaben
$projektdauer = 6; // z.B. 6 Monate


// 👤 Neueingabe eines Mitarbeiters über Formular
$name = $_POST['name'] ?? '';  // Name des Mitarbeiters
$status = $_POST['status'] ?? '';  // 'intern' oder 'extern'
$monatsgehalt = $_POST['monatsgehalt'] ?? 0.0; // Gehalt pro Monat in €
$projekt_id = $_POST['projekt_id'] ?? '';  // Nur für interne Mitarbeiter
$isExtern = ($status === 'extern');         // TRUE/FALSE für weitere Logik
$entgelt_stunde = $_POST['entgelt_stunde'] ?? 0.0; // Optional: Stundenlohn
$bezeichnungs_id = $_POST['bezeichnungs_id'] ?? ''; // z.B. eindeutige ID

// 💸 Kostenberechnung
$personalkosten_intern = 0.0; // Summe intern * Projektdauer
$personalkosten_extern = 0.0; // Summe extern * Projektdauer

// 📥 CSV-Datei (falls verwendet)
$csv_datei = $_FILES['csv']['tmp_name'] ?? null;

// 🧾 Benutzerlogin (wenn Login verwendet wird)
$benutzername = $_POST['benutzername'] ?? '';
$passwort = $_POST['passwort'] ?? '';


$db = new SQLite3('mitarbeiterdb1.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $gehalt = floatval($_POST['monatsgehalt']);
    $dauer = intval($_POST['projektdauer']);
    $status = $_POST['status'];
    $projekt_id = $_POST['projekt_id'] ?? null;

    $stmt = $db->prepare("INSERT INTO mitarbeiter (name, status, monatsgehalt, projekt_id) VALUES (?, ?, ?, ?)");
    $stmt->bindValue(1, $name);
    $stmt->bindValue(2, $status);
    $stmt->bindValue(3, $gehalt);
    $stmt->bindValue(4, $status === 'intern' ? $projekt_id : null);
    $stmt->execute();
}

$projektdauer = 6; // z. B. 6 Monate, später dynamisch
$kosten_intern = $db->querySingle("SELECT SUM(monatsgehalt) FROM mitarbeiter WHERE status = 'intern' AND projekt_id IS NOT NULL") * $projektdauer;
$kosten_extern = $db->querySingle("SELECT SUM(monatsgehalt) FROM mitarbeiter WHERE status = 'extern'") * $projektdauer;


personalkostenanzeige.html

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personalkosten(Liste)</title>
</head>
<body>
<form method="post" action="personalkostenliste.php">
    <label>Mitarbeitername:</label>
    <input type="text" name="name" required><br>

    <label>Monatsgehalt (€):</label>
    <input type="number" name="monatsgehalt" required><br>

    <label>Projektdauer (Monate):</label>
    <input type="number" name="projektdauer" required><br>

    <label>Status:</label>
    <select name="status">
        <option value="intern">Intern</option>
        <option value="extern">Extern</option>
    </select><br>

    <label>Projekt-ID (nur bei intern):</label>
    <input type="text" name="projekt_id"><br>

    <input type="submit" value="Speichern">
</form>

</body>
</html>