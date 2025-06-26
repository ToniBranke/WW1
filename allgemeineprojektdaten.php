<?php
$db = new SQLite3('projektbezeichnung.db');

$db->exec("CREATE TABLE IF NOT EXISTS projekt (
    `3-1MD-01` TEXT PRIMARY KEY,
    `3-1MD-02` TEXT,
    `3-1MD-03` TEXT,
    `3-1MD-04B` DATE,
    `3-1MD-04E` DATE,
    `3-1MD-05` TEXT,
    `3-1MD-06` TEXT,
    `3-1MD-07` TEXT,
    `3-1MD-08` TEXT,
    `3-2PK-01` REAL,
    `3-2PK-02` REAL,
    `3-2PK-03` REAL,
    `3-3PL-01` REAL,
    `3-4SK-01` REAL,
    `3-5IV-01` REAL,
    `3-5IV-02` REAL
);");

$error = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['projektName'])) {
        $error = "Das Feld 'Projektbezeichnung' ist Pflicht!";
    } else {
        $stmt = $db->prepare("INSERT OR REPLACE INTO projekt (
            `3-1MD-01`, `3-1MD-02`, `3-1MD-03`, `3-1MD-04B`, `3-1MD-04E`,
            `3-1MD-05`, `3-1MD-06`, `3-1MD-07`, `3-1MD-08`,
            `3-2PK-01`, `3-2PK-02`, `3-2PK-03`,
            `3-3PL-01`, `3-4SK-01`, `3-5IV-01`, `3-5IV-02`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bindValue(1, $_POST['projektName'], SQLITE3_TEXT);
        $stmt->bindValue(2, $_POST['sponsor'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(3, $_POST['responsible'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(4, $_POST['timeframeFrom'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(5, $_POST['timeframeUntil'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(6, $_POST['economicArea'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(7, $_POST['faculty'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(8, $_POST['costCenter'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(9, $_POST['projectCostObjectNumber'] ?? '', SQLITE3_TEXT);

        // Placeholder-Werte für spätere Seiten
        $stmt->bindValue(10, 0, SQLITE3_FLOAT);
        $stmt->bindValue(11, 0, SQLITE3_FLOAT);
        $stmt->bindValue(12, 0, SQLITE3_FLOAT);
        $stmt->bindValue(13, 0, SQLITE3_FLOAT);
        $stmt->bindValue(14, 0, SQLITE3_FLOAT);
        $stmt->bindValue(15, 0, SQLITE3_FLOAT);
        $stmt->bindValue(16, 0, SQLITE3_FLOAT);

        $result = $stmt->execute();
        $success = $result ? true : false;
        if (!$result) $error = "Fehler beim Speichern.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allgemeine Projektdaten</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <script defer src="buttonScript.js"></script>
</head>
<body class="taskMain">
<div class="logoutButtonContainer">
    <button class="logoutButton" id="logoutButton">Abmelden</button>
</div>

<div class="tabs">
    <a href="allgemein.html" class="tabActive">Allgemeine Projektdaten</a>
    <a href="personalkosten.html" class="tab">Personalkosten</a>
    <a href="leistungen.html" class="tab">Kosten für projektbezogene Leistungen</a>
    <a href="sachkosten.html" class="tab">Sachkosten</a>
    <a href="abschreibungen.html" class="tab">Investitionen/Abschreibungen</a>
    <a href="raeume.html" class="tab">Kosten für Räume und Flächen</a>
</div>

<?php if ($error): ?>
    <p style="color: red; text-align:center;">❌ <?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green; text-align:center;">✅ Projekt erfolgreich gespeichert!</p>
    <script>window.open('projektdbrückmeldung.php', 'Rückmeldung', 'width=800,height=600');</script>
<?php endif; ?>

<form class=projectForm method="POST">
    <div class="formRow">
        <div class="formGroup">
            <label for="projektName">Projekttitel:</label>
            <input type="text" id="projektName" name="projektName" required>
        </div>
        <div class="formGroup">
            <label for="sponsor">Auftraggeber:</label>
            <input type="text" id="sponsor" name="sponsor" required>
        </div>
        <div class="formGroup">
            <label for="faculty">Fakultät:</label>
            <input type="text" id="faculty" name="faculty" required>
        </div>
    </div>
    <div class="formRow">
        <div class="formGroup">
            <label for="responsible">Verantwortlicher:</label>
            <input type="text" id="responsible" name="responsible" required>
        </div>
        <div class="formGroup">
            <label for="costCenter">Kostenstelle:</label>
            <input type="text" id="costCenter" name="costCenter" required>
        </div>
        <div class="formGroup">
            <label for="trainingDays">Anzahl Weiterbildungstage:</label>
            <input type="number" id="trainingDays" name="trainingDays" min="0" required>
        </div>
    </div>
    <div class="formRow">
        <div class="formGroup">
            <label for="timeframeFrom">Geplanter Zeitraum von:</label>
            <input type="date" id="timeframeFrom" name="timeframeFrom" required>
        </div>
        <div class="formGroup">
            <label for="timeframeUntil">bis:</label>
            <input type="date" id="timeframeUntil" name="timeframeUntil" required>
        </div>
        <div class="formGroup">
            <label for="economicArea">Wirtschaftlicher Bereich:</label>
            <input type="text" id="economicArea" name="economicArea" required>
        </div>
    </div>
    <div class="formRow">
        <div class="formGroup wide">
            <label for="projectCostObjectNumber">Projekt-/<br> Kostenträgernummer:</label>
            <input type="text" id="projectCostObjectNumber" name="projectCostObjectNumber" required>
        </div>
    </div>
    <div class="formRow formRowRigth">
        <button type=submit" class="weiterButton" id="submitButton">Weiter</button>
    </div>
</form>
</body>
<footer class="footer">
    <p>&copy; 2025 Hochschule Mittweida</p>
</footer>
</html>
