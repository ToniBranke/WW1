<?php
// Verbindung zur Datenbank und Tabelle (wie in deinem Code)
$db = new SQLite3('projekt.db');
$db->exec("CREATE TABLE IF NOT EXISTS projekt (
    projektname TEXT PRIMARY KEY,
    auftraggeber TEXT,
    projektleiter TEXT,
    laufzeit_beginn DATE,
    laufzeit_ende DATE,
    wirtschaftlicher_bereich TEXT,
    fakultaet TEXT,
    kostenstelle TEXT,
    projekt_kostentraeger TEXT,
    personalkosten_intern_gesamt REAL,
    personalkosten_extern_gesamt REAL,
    personalkosten_imperial REAL,
    imperialkosten_projektbezogen REAL,
    imperialkosten_sachkosten REAL,
    nutzungsgebuehr_inventar_gesamt REAL,
    imperialkosten_inventar REAL
);");

$error = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Beispiel: Pflichtfeld prüfen
    if (empty($_POST['projektname'])) {
        $error = "Das Feld 'Projektname' ist Pflicht!";
    } else {
        $stmt = $db->prepare("INSERT OR REPLACE INTO projekt (
            projektname, auftraggeber, projektleiter, laufzeit_beginn, laufzeit_ende,
            wirtschaftlicher_bereich, fakultaet, kostenstelle, projekt_kostentraeger,
            personalkosten_intern_gesamt, personalkosten_extern_gesamt, personalkosten_imperial,
            imperialkosten_projektbezogen, imperialkosten_sachkosten, nutzungsgebuehr_inventar_gesamt,
            imperialkosten_inventar
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bindValue(1, $_POST['projektname'], SQLITE3_TEXT);
        $stmt->bindValue(2, $_POST['auftraggeber'], SQLITE3_TEXT);
        $stmt->bindValue(3, $_POST['projektleiter'], SQLITE3_TEXT);
        $stmt->bindValue(4, $_POST['laufzeit_beginn'], SQLITE3_TEXT);
        $stmt->bindValue(5, $_POST['laufzeit_ende'], SQLITE3_TEXT);
        $stmt->bindValue(6, $_POST['wirtschaftlicher_bereich'], SQLITE3_TEXT);
        $stmt->bindValue(7, $_POST['fakultaet'], SQLITE3_TEXT);
        $stmt->bindValue(8, $_POST['kostenstelle'], SQLITE3_TEXT);
        $stmt->bindValue(9, $_POST['projekt_kostentraeger'], SQLITE3_TEXT);
        $stmt->bindValue(10, $_POST['personalkosten_intern_gesamt'], SQLITE3_FLOAT);
        $stmt->bindValue(11, $_POST['personalkosten_extern_gesamt'], SQLITE3_FLOAT);
        $stmt->bindValue(12, $_POST['personalkosten_imperial'], SQLITE3_FLOAT);
        $stmt->bindValue(13, $_POST['imperialkosten_projektbezogen'], SQLITE3_FLOAT);
        $stmt->bindValue(14, $_POST['imperialkosten_sachkosten'], SQLITE3_FLOAT);
        $stmt->bindValue(15, $_POST['nutzungsgebuehr_inventar_gesamt'], SQLITE3_FLOAT);
        $stmt->bindValue(16, $_POST['imperialkosten_inventar'], SQLITE3_FLOAT);

        $result = $stmt->execute();

        if ($result) {
            $success = true;
        } else {
            $error = "Fehler beim Speichern des Projekts.";
        }
    }
}

// Daten für Tabelle holen
$results = $db->query("SELECT * FROM projekt ORDER BY projektname ASC");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Projektdaten</title>
</head>
<body>

<h2>Projekt hinzufügen</h2>

<?php if ($error): ?>
    <p style="color: red;">❌ <?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="" method="post">
    Projektname: <input type="text" name="projektname" required><br>
    Auftraggeber: <input type="text" name="auftraggeber"><br>
    Projektleiter: <input type="text" name="projektleiter"><br>
    Laufzeit Beginn (YYYY-MM-DD): <input type="date" name="laufzeit_beginn"><br>
    Laufzeit Ende (YYYY-MM-DD): <input type="date" name="laufzeit_ende"><br>
    Wirtschaftlicher Bereich: <input type="text" name="wirtschaftlicher_bereich"><br>
    Fakultät: <input type="text" name="fakultaet"><br>
    Kostenstelle: <input type="text" name="kostenstelle"><br>
    Projekt-/Kostenträgernummer: <input type="text" name="projekt_kostentraeger"><br>
    Personalkosten intern gesamt: <input type="number" step="10" name="personalkosten_intern_gesamt"><br>
    Personalkosten extern gesamt: <input type="number" step="10" name="personalkosten_extern_gesamt"><br>
    Personalkosten Imperial: <input type="number" step="10" name="personalkosten_imperial"><br>
    Imperialkosten projektbezogen: <input type="number" step="10" name="imperialkosten_projektbezogen"><br>
    Imperialkosten Sachkosten: <input type="number" step="10" name="imperialkosten_sachkosten"><br>
    Nutzungsgebühr Inventar gesamt: <input type="number" step="10" name="nutzungsgebuehr_inventar_gesamt"><br>
    Imperialkosten Inventar: <input type="number" step="10" name="imperialkosten_inventar"><br>
    <input type="submit" value="Speichern">
</form>

<?php if ($success): ?>
    <script>
        // Neues Fenster mit der Tabelle öffnen
        window.open('projektdbrückmeldung.php', 'Tabelle', 'width=800,height=600');
    </script>
<?php endif; ?>

<h2>Alle Projekte</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Projektname</th>
        <th>Auftraggeber</th>
        <th>Projektleiter</th>
        <th>Laufzeit Beginn</th>
        <th>Laufzeit Ende</th>
    </tr>
    <?php while ($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
    <tr>
        <td><?= htmlspecialchars($row['projektname']) ?></td>
        <td><?= htmlspecialchars($row['auftraggeber']) ?></td>
        <td><?= htmlspecialchars($row['projektleiter']) ?></td>
        <td><?= htmlspecialchars($row['laufzeit_beginn']) ?></td>
        <td><?= htmlspecialchars($row['laufzeit_ende']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>