<?php
// Fehleranzeige aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Datei mit DB-Funktion einbinden
require_once 'mitarbeiterdb1.php'; // <- Prüfen, ob diese Datei korrekt vorhanden ist
echo "Datei geladen<br>";

// Projekt-ID abrufen
$projektId = $_GET['projektId'] ?? 'defaultProjekt';

// Interne Mitarbeiter aus der Datenbank laden
$interneMitarbeiter = [];
if (function_exists('getMitarbeiterByProjekt')) {
    $interneMitarbeiter = getMitarbeiterByProjekt($projektId);
} else {
    die("Fehler: Funktion getMitarbeiterByProjekt() ist nicht definiert.");
}

// Session für externe Mitarbeiter initialisieren
if (!isset($_SESSION['externeMitarbeiter'])) {
    $_SESSION['externeMitarbeiter'] = [];
}

// Formularverarbeitung: Externen Mitarbeiter hinzufügen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'extern';

    if ($status === 'extern') {
        $neu = [
            'TarifGruppe'        => $_POST['TarifGruppe'] ?? '',
            'Entgeltgruppe'      => $_POST['Entgeltgruppe'] ?? '',
            'Status'             => 'extern',
            'BezeichnungsID'     => $_POST['BezeichnungsID'] ?? '',
            'Name'               => $_POST['Name'] ?? '',
            'Adresse'            => $_POST['Adresse'] ?? '',
            'Telefonnummer'      => $_POST['Telefonnummer'] ?? '',
            'Benutzername'       => $_POST['Benutzername'] ?? '',
            'Passwort'           => $_POST['Passwort'] ?? '',
            'EntgeltProStunde'   => $_POST['EntgeltProStunde'] ?? '',
            'Monatsgehalt'       => $_POST['Monatsgehalt'] ?? '',
            'AG'                 => $_POST['AG'] ?? '',
            'JSZ'                => $_POST['JSZ'] ?? '',
            'WorkedHours'        => $_POST['WorkedHours'] ?? '',
        ];
        $_SESSION['externeMitarbeiter'][] = $neu;

        // PRG Pattern (Post-Redirect-Get)
        header("Location: " . $_SERVER['PHP_SELF'] . "?projektId=" . urlencode($projektId));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Mitarbeiterliste Projekt <?= htmlspecialchars($projektId) ?></title>
</head>
<body>

<h2>Interne Mitarbeiter (aus Datenbank)</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>V1-2PK-01_empName</th>
        <th>V1-2PK-02_empIdentifier</th>
        <th>V1-2PK-03_empHourPayNet</th>
        <th>V1-2PK-04_empAdditionalCost</th>
        <th>V1-2PK-05_empJZB</th>
        <th>V4-2PK-06_empWorkedHoursInProject</th>
    </tr>
    <?php foreach ($interneMitarbeiter as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['Name'] ?? '') ?></td>
            <td><?= htmlspecialchars($m['BezeichnungsID'] ?? '') ?></td>
            <td><?= htmlspecialchars($m['EntgeltProStunde'] ?? '') ?></td>
            <td><?= htmlspecialchars($m['AG'] ?? '') ?></td>
            <td><?= htmlspecialchars($m['JSZ'] ?? '') ?></td>
            <td><?= htmlspecialchars($m['WorkedHours'] ?? '0') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Externe Mitarbeiter (manuell hinzugefügt)</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>V1-2PK-01_empName</th>
        <th>V1-2PK-02_empIdentifier</th>
        <th>V1-2PK-03_empHourPayNet</th>
        <th>V1-2PK-04_empAdditionalCost</th>
        <th>V1-2PK-05_empJZB</th>
        <th>V4-2PK-06_empWorkedHoursInProject</th>
    </tr>
    <?php foreach ($_SESSION['externeMitarbeiter'] as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['Name']) ?></td>
            <td><?= htmlspecialchars($m['BezeichnungsID']) ?></td>
            <td><?= htmlspecialchars($m['EntgeltProStunde']) ?></td>
            <td><?= htmlspecialchars($m['AG']) ?></td>
            <td><?= htmlspecialchars($m['JSZ']) ?></td>
            <td><?= htmlspecialchars($m['WorkedHours'] ?? '0') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Neuen externen Mitarbeiter hinzufügen</h2>
<form method="post">
    <label>Status:</label>
    <select name="status" disabled>
        <option value="intern">Intern (nicht erlaubt)</option>
        <option value="extern" selected>Extern</option>
    </select><br><br>

    <label>Tarif-Gruppe:</label><input type="text" name="TarifGruppe"><br>
    <label>Entgeltgruppe:</label><input type="text" name="Entgeltgruppe"><br>
    <label>Bezeichnungs ID:</label><input type="text" name="BezeichnungsID"><br>
    <label>Name:</label><input type="text" name="Name"><br>
    <label>Adresse:</label><input type="text" name="Adresse"><br>
    <label>Telefonnummer:</label><input type="text" name="Telefonnummer"><br>
    <label>Benutzername oder E-Mail:</label><input type="text" name="Benutzername"><br>
    <label>Passwort:</label><input type="text" name="Passwort"><br>
    <label>Entgelt pro Stunde:</label><input type="text" name="EntgeltProStunde"><br>
    <label>Monatsgehalt:</label><input type="text" name="Monatsgehalt"><br>
    <label>AG:</label><input type="text" name="AG"><br>
    <label>JSZ:</label><input type="text" name="JSZ"><br>
    <label>Geleistete Stunden im Projekt:</label><input type="text" name="WorkedHours"><br><br>

    <button type="submit">Hinzufügen</button>
</form>

</body>
</html>
