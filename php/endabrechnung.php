<?php
/**
 * Backend – Endabrechnung (V3-7EN-10)
 * Stand: 25‑06‑2025 · auf Basis der haus­eigenen ID-Konvention
 *
 *  pulls (Projektdatenbank):
 *      3-2PK-03  Personalkosten Imperial
 *      3-3PL-01  Imperialkosten projekt­bez. Leistungen
 *      3-4SK-01  Imperialkosten Sachkosten
 *      3-5IV-01  Imperialkosten Inventar
 *      3-6RF-04  Imperialkosten Räume/Flächen
 *      V0-7EN-07_plannedPercentProfit  (Gewinn‑% – frei einzugeben, Default 3 %)
 *      V0-7EN_taxPercent               (Steuer‑% – frei einzugeben, Default 19 %)
 *
 *  feeds (Zwischen- & Ergebnisfelder):
 *      V0-7EN-01_endimperialOneTwo
 *      V0-7EN-02_endimperialTreeFourFive
 *      V0-7EN-03_centralGKZ
 *      V0-7EN-04_decentralGKZ
 *      V0-7EN-05_endimperialNet
 *      V0-7EN-06_plannedProfit
 *      V0-7EN-08_plannedNet
 *      V0-7EN-09_tax
 *      V3-7EN-10_endimperial → 3-7EN-01
 */

declare(strict_types=1);

$db = new SQLite3('deine_datenbank.sqlite');

//-----------------------------------------------------------------
// Helper
//-----------------------------------------------------------------

function pull(string $feldId): ?float
{
    global $db;
    $stmt = $db->prepare('SELECT wert FROM felder WHERE id = :id LIMIT 1');
    $stmt->bindValue(':id', $feldId, SQLITE3_TEXT);
    $row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    return $row ? (float) $row['wert'] : null;   // null ⇒ nicht gesetzt
}

function feed(string $feldId, float $wert): void
{
    global $db;
    $stmt = $db->prepare('INSERT INTO felder (id, wert)
                          VALUES (:id, :wert)
                          ON CONFLICT(id) DO UPDATE SET wert = :wert');
    $stmt->bindValue(':id',   $feldId, SQLITE3_TEXT);
    $stmt->bindValue(':wert', $wert);
    $stmt->execute();
}

//-----------------------------------------------------------------
// 1) Imperiale Kostenblöcke
//-----------------------------------------------------------------

$endimperialOneTwo = (pull('3-2PK-03') ?? 0.0) + (pull('3-3PL-01') ?? 0.0);
feed('V0-7EN-01_endimperialOneTwo', $endimperialOneTwo);

$endimperialTreeFourFive = (pull('3-4SK-01') ?? 0.0)
                         + (pull('3-5IV-01') ?? 0.0)
                         + (pull('3-6RF-04') ?? 0.0);
feed('V0-7EN-02_endimperialTreeFourFive', $endimperialTreeFourFive);

//-----------------------------------------------------------------
// 2) Gemeinkostenzuschläge (zentral / dezentral)
//-----------------------------------------------------------------

const CENTRAL_RATE   = 0.1932; // 19,32 %
const DECENTRAL_RATE = 0.0564; //  5,64 %

$centralGKZ   = round($endimperialOneTwo * CENTRAL_RATE, 2);
$decentralGKZ = round($endimperialOneTwo * DECENTRAL_RATE, 2);
feed('V0-7EN-03_centralGKZ',   $centralGKZ);
feed('V0-7EN-04_decentralGKZ', $decentralGKZ);

//-----------------------------------------------------------------
// 3) Netto ohne / mit Gewinn
//-----------------------------------------------------------------

$endimperialNet = $endimperialOneTwo + $endimperialTreeFourFive + $centralGKZ + $decentralGKZ;
feed('V0-7EN-05_endimperialNet', $endimperialNet);

$plannedPercentProfit = pull('V0-7EN-07_plannedPercentProfit');
if ($plannedPercentProfit === null || $plannedPercentProfit <= 0) {
    $plannedPercentProfit = 0.03; // Default 3 %
}

$plannedProfit = round($endimperialNet * $plannedPercentProfit, 2);
feed('V0-7EN-06_plannedProfit', $plannedProfit);

$plannedNet = $endimperialNet + $plannedProfit;
feed('V0-7EN-08_plannedNet', $plannedNet);

//-----------------------------------------------------------------
// 4) Steuer & Brutto­endpreis
//-----------------------------------------------------------------

$taxPercent = pull('V0-7EN_taxPercent');
if ($taxPercent === null || $taxPercent <= 0) {
    $taxPercent = 0.19; // Default 19 %
}

$tax = round($plannedNet * $taxPercent, 2);
feed('V0-7EN-09_tax', $tax);

$endimperial = $plannedNet + $tax;
feed('V3-7EN-10_endimperial', $endimperial);
feed('3-7EN-01',              $endimperial);

//-----------------------------------------------------------------
// 5) Response für Frontend‑AJAX (optional)
//-----------------------------------------------------------------

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'V0-7EN-01_endimperialOneTwo'       => $endimperialOneTwo,
    'V0-7EN-02_endimperialTreeFourFive' => $endimperialTreeFourFive,
    'V0-7EN-03_centralGKZ'              => $centralGKZ,
    'V0-7EN-04_decentralGKZ'            => $decentralGKZ,
    'V0-7EN-05_endimperialNet'          => $endimperialNet,
    'V0-7EN-06_plannedProfit'           => $plannedProfit,
    'V0-7EN-08_plannedNet'              => $plannedNet,
    'V0-7EN-09_tax'                     => $tax,
    'V3-7EN-10_endimperial'             => $endimperial,
], JSON_PRETTY_PRINT);
?>
