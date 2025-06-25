<?php
// Verbindung zur DB
$db = new SQLite3('projekt.db');

// Tabelle "felder" erstellen, falls sie nicht existiert
$db->exec("
    CREATE TABLE IF NOT EXISTS felder (
        id TEXT PRIMARY KEY,
        wert REAL
    );
");
//TEstwerte
$db->exec("INSERT OR REPLACE INTO felder (id, wert) VALUES 
    ('3-2PK-03', 1000),
    ('3-3PL-01', 500),
    ('3-4SK-01', 200),
    ('3-5IV-02', 300),
    ('3-6RF-01', 100)
");

// DB Daten
function getFeldwert($feldId) {
    global $db;
    $stmt = $db->prepare("SELECT wert FROM felder WHERE id = :id");
    $stmt->bindValue(':id', $feldId);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    return $row ? floatval($row['wert']) : 0.0;
}

// Gewinnaufschlag
$geplanterProzentGewinn = isset($_POST['V0-7EN-07']) ? floatval($_POST['V0-7EN-07']) : 0.0;

//Berechnungsschritte
$db->exec("INSERT OR REPLACE INTO felder (id, wert) VALUES ('V0-7EN-07_plannedPercentProfit', 0.15)"); //Fester Gewinnsatz von 15%

$personalkosten = getFeldwert('3-2PK-03');
$projektleistungen = getFeldwert('3-3PL-01');
$sonstigeKosten = getFeldwert('3-4SK-01') + getFeldwert('3-5IV-02') + getFeldwert('3-6RF-01');

$endimperialOneTwo = $personalkosten + $projektleistungen; // V0-7EN-01
$endimperialTreeFourFive = $sonstigeKosten;                // V0-7EN-02

$zentralGKZ = $endimperialOneTwo * 0.1932;                 // V0-7EN-03
$dezentralGKZ = $endimperialOneTwo * 0.0564;               // V0-7EN-04

$endimperialNet = $endimperialOneTwo + $endimperialTreeFourFive; // V0-7EN-05

$geplanterGewinn = $endimperialNet * ($geplanterProzentGewinn / 100); // V0-7EN-06
$geplantesNetto = $endimperialNet + $geplanterGewinn;                 // V0-7EN-08

$steuer = $geplantesNetto * 0.19;                                      // V0-7EN-09

$endabrechnung = $geplantesNetto + $steuer;                           // V3-7EN-10

// Ergebnis 
$stmt = $db->prepare("REPLACE INTO felder (id, wert) VALUES (:id, :wert)");
$stmt->bindValue(':id', '3-7EN-01');
$stmt->bindValue(':wert', $endabrechnung);
$stmt->execute();

echo json_encode([
    'endabrechnung' => round($endabrechnung, 2),
    'steuer' => round($steuer, 2),
    'netto' => round($geplantesNetto, 2),
    'gewinn' => round($geplanterGewinn, 2),
    'zentralGKZ' => round($zentralGKZ, 2),
    'dezentralGKZ' => round($dezentralGKZ, 2)
]);
?>