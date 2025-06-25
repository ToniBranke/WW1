<?php
/**
 * Backend – Endabrechnung (V3‑7EN‑10)
 *  pulls:
 *      3‑2PK‑03, 3‑3PL‑01,
 *      3‑4SK‑01, 3‑5IV‑02, 3‑6RF‑01,
 *      V0‑7EN‑07_plannedPercentProfit
 *  feeds:
 *      V0‑7EN‑01_endimperialOneTwo
 *      V0‑7EN‑02_endimperialTreeFourFive
 *      V0‑7EN‑03_centralGKZ
 *      V0‑7EN‑04_decentralGKZ
 *      V0‑7EN‑05_endimperialNet
 *      V0‑7EN‑06_plannedProfit
 *      V0‑7EN‑08_plannedNet
 *      V0‑7EN‑09_tax
 *      V3‑7EN‑10_endimperial  →  3‑7EN‑01
 */

declare(strict_types=1);

$db = new SQLite3('deine_datenbank.sqlite');

//––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
// Hilfsfunktionen
//––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––

/**
 * Holt den Wert eines Feldes.
 */
function pull(string $feldId): float
{
    global $db;
    $stmt = $db->prepare('SELECT wert FROM felder WHERE id = :id LIMIT 1');
    $stmt->bindValue(':id', $feldId, SQLITE3_TEXT);
    $row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    return $row ? (float)$row['wert'] : 0.0;
}

/**
 * Schreibt einen Wert in ein Feld (upsert).
 */
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

//––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
//Kostenblöcke
//––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––

// V0‑7EN‑01_endimperialOneTwo ← SUM[3‑2PK‑03; 3‑3PL‑01]
$V0_7EN_01_endimperialOneTwo = pull('3-2PK-03') + pull('3-3PL-01');
feed('V0-7EN-01_endimperialOneTwo', $V0_7EN_01_endimperialOneTwo);

// V0‑7EN‑02_endimperialTreeFourFive ← SUM[3‑4SK‑01; 3‑5IV‑02; 3‑6RF‑01]
$V0_7EN_02_endimperialTreeFourFive = pull('3-4SK-01') + pull('3-5IV-02') + pull('3-6RF-01');
feed('V0-7EN-02_endimperialTreeFourFive', $V0_7EN_02_endimperialTreeFourFive);

// V0‑7EN‑03_centralGKZ ← V0‑7EN‑01 * 19.32 %
$V0_7EN_03_centralGKZ = round($V0_7EN_01_endimperialOneTwo * 0.1932, 2);
feed('V0-7EN-03_centralGKZ', $V0_7EN_03_centralGKZ);

// V0‑7EN‑04_decentralGKZ ← V0‑7EN‑01 * 5.64 %
$V0_7EN_04_decentralGKZ = round($V0_7EN_01_endimperialOneTwo * 0.0564, 2);
feed('V0-7EN-04_decentralGKZ', $V0_7EN_04_decentralGKZ);

// V0‑7EN‑05_endimperialNet ← SUM[V0‑7EN‑01; V0‑7EN‑02]
$V0_7EN_05_endimperialNet = $V0_7EN_01_endimperialOneTwo + $V0_7EN_02_endimperialTreeFourFive;
feed('V0-7EN-05_endimperialNet', $V0_7EN_05_endimperialNet);

// Gewinnprozentsatz (V0‑7EN‑07_plannedPercentProfit) wird vom User erfasst
$V0_7EN_07_plannedPercentProfit = pull('V0-7EN-07_plannedPercentProfit'); // z. B. 0.15 für 15 %

// V0‑7EN‑06_plannedProfit ← V0‑7EN‑05 * V0‑7EN‑07
$V0_7EN_06_plannedProfit = round($V0_7EN_05_endimperialNet * $V0_7EN_07_plannedPercentProfit, 2);
feed('V0-7EN-06_plannedProfit', $V0_7EN_06_plannedProfit);

// V0‑7EN‑08_plannedNet ← SUM[V0‑7EN‑05; V0‑7EN‑06]
$V0_7EN_08_plannedNet = $V0_7EN_05_endimperialNet + $V0_7EN_06_plannedProfit;
feed('V0-7EN-08_plannedNet', $V0_7EN_08_plannedNet);

// V0‑7EN‑09_tax ← V0‑7EN‑08 * 19 %
$V0_7EN_09_tax = round($V0_7EN_08_plannedNet * 0.19, 2);
feed('V0-7EN-09_tax', $V0_7EN_09_tax);

// V3‑7EN‑10_endimperial ← SUM[V0‑7EN‑08; V0‑7EN‑09]
$V3_7EN_10_endimperial = $V0_7EN_08_plannedNet + $V0_7EN_09_tax;
feed('V3-7EN-10_endimperial', $V3_7EN_10_endimperial);

// 3‑7EN‑01 erhält die finale Bruttosumme
feed('3-7EN-01', $V3_7EN_10_endimperial);