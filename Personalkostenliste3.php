<?php
session_start();

// Datei mit DB-Verbindung und Funktion einbinden
require_once 'mitarbeiterdb1.php';  // hier steht die Funktion getMitarbeiterByProjekt()

$projektId = $_GET['projektId'] ?? 'defaultProjekt';

// Interne Mitarbeiter aus mitarbeiterdb1.php laden
$interneMitarbeiter = getMitarbeiterByProjekt($projektId);

// Session für externe Mitarbeiter initialisieren
if (!isset($_SESSION['externeMitarbeiter'])) {
    $_SESSION['externeMitarbeiter'] = [];
}

// Formularverarbeitung (externen Mitarbeiter hinzufügen)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'extern';

    if ($status === 'extern') {
        $neu = [
            'TarifGruppe' => $_POST['TarifGruppe'] ?? '',
            'Entgeltgruppe' => $_POST['Entgeltgruppe'] ?? '',
            'Status' => 'extern',
            'BezeichnungsID' => $_POST['BezeichnungsID'] ?? '',
            'Name' => $_POST['Name'] ?? '',
            'Adresse' => $_POST['Adresse'] ?? '',
            'Telefonnummer' => $_POST['Telefonnummer'] ?? '',
            'Benutzername' => $_POST['Benutzername'] ?? '',
            'Passwort' => $_POST['Passwort'] ?? '',
            'EntgeltProStunde' => $_POST['EntgeltProStunde'] ?? '',
            'Monatsgehalt' => $_POST['Monatsgehalt'] ?? '',
            'AG' => $_POST['AG'] ?? '',
            'JSZ' => $_POST['JSZ'] ?? '',
        ];
        $_SESSION['externeMitarbeiter'][] = $neu;

        // Nach POST-Redirect (PRG-Pattern)
        header("Location: " . $_SERVER['PHP_SELF'] . "?projektId=" . urlencode($projektId));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Mitarbeiterliste Projekt <?=htmlspecialchars($projektId)?></title>
</head>
<body>

<h2>Interne Mitarbeiter (aus DB)</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Tarif-Gruppe</th><th>Entgeltgruppe</th><th>Bezeichnungs ID</th><th>Name</th><th>Adresse</th><th>Telefon</th><th>Benutzername</th><th>Entgelt/Stunde</th><th>Monatsgehalt</th><th>AG</th><th>JSZ</th>
    </tr>
    <?php foreach ($interneMitarbeiter as $m): ?>
        <tr>
            <td><?=htmlspecialchars($m['TarifGruppe'] ?? '')?></td>
            <td><?=htmlspecialchars($m['Entgeltgruppe'] ?? '')?></td>
            <td><?=htmlspecialchars($m['BezeichnungsID'] ?? '')?></td>
            <td><?=htmlspecialchars($m['Name'] ?? '')?></td>
            <td><?=htmlspecialchars($m['Adresse'] ?? '')?></td>
            <td><?=htmlspecialchars($m['Telefonnummer'] ?? '')?></td>
            <td><?=htmlspecialchars($m['Benutzername'] ?? '')?></td>
            <td><?=htmlspecialchars($m['EntgeltProStunde'] ?? '')?></td>
            <td><?=htmlspecialchars($m['Monatsgehalt'] ?? '')?></td>
            <td><?=htmlspecialchars($m['AG'] ?? '')?></td>
            <td><?=htmlspecialchars($m['JSZ'] ?? '')?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Externe Mitarbeiter (manuell hinzugefügt)</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Tarif-Gruppe</th><th>Entgeltgruppe</th><th>Bezeichnungs ID</th><th>Name</th><th>Adresse</th><th>Telefon</th><th>Benutzername</th><th>Entgelt/Stunde</th><th>Monatsgehalt</th><th>AG</th><th>JSZ</th>
    </tr>
    <?php foreach ($_SESSION['externeMitarbeiter'] as $m): ?>
        <tr>
            <td><?=htmlspecialchars($m['TarifGruppe'])?></td>
            <td><?=htmlspecialchars($m['Entgeltgruppe'])?></td>
            <td><?=htmlspecialchars($m['BezeichnungsID'])?></td>
            <td><?=htmlspecialchars($m['Name'])?></td>
            <td><?=htmlspecialchars($m['Adresse'])?></td>
            <td><?=htmlspecialchars($m['Telefonnummer'])?></td>
            <td><?=htmlspecialchars($m['Benutzername'])?></td>
            <td><?=htmlspecialchars($m['EntgeltProStunde'])?></td>
            <td><?=htmlspecialchars($m['Monatsgehalt'])?></td>
            <td><?=htmlspecialchars($m['AG'])?></td>
            <td><?=htmlspecialchars($m['JSZ'])?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Neuen Mitarbeiter hinzufügen</h2>
<form method="post">
    <label>Status:</label>
    <select name="status">
        <option value="intern" disabled>Intern (nicht manuell hinzufügen)</option>
        <option value="extern" selected>Extern</option>
    </select><br><br>

    <label>Tarif-Gruppe:</label><input type="text" name="TarifGruppe"><br>
    <label>Entgeltgruppe:</label><input type="text" name="Entgeltgruppe"><br>
    <label>Bezeichnungs ID:</label><input type="text" name="BezeichnungsID"><br>
    <label>Name:</label><input type="text" name="Name"><br>
    <label>Adresse:</label><input type="text" name="Adresse"><br>
    <label>Telefonnummer:</label><input type="text" name="Telefonnummer"><br>
    <label>Benutzername oder eMail:</label><input type="text" name="Benutzername"><br>
    <label>Passwort:</label><input type="text" name="Passwort"><br>
    <label>Entgelt pro Stunde:</label><input type="text" name="EntgeltProStunde"><br>
    <label>Monatsgehalt:</label><input type="text" name="Monatsgehalt"><br>
    <label>AG:</label><input type="text" name="AG"><br>
    <label>JSZ:</label><input type="text" name="JSZ"><br>

    <button type="submit">Hinzufügen</button>
</form>

</body>
</html>
