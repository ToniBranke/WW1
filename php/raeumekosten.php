<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $officeFee = floatval($_POST['officeUsageFee'] ?? 0);

    $labName = $_POST['LabName'] ?? '';
    $labWeeks = intval($_POST['labUsageFeeWeeks'] ?? 0);
    $labHours = floatval($_POST['labUsageFeeHours'] ?? 0);
    $labRatePerHour = 2,18; // Festpreis 2,18€

    $otherRoomName = $_POST['otherRoomName'] ?? '';
    $otherRoomSize = floatval($_POST['otherRoomSize'] ?? 0);
    $otherRoomRent = floatval($_POST['otherRoomRent'] ?? 0);
    $otherRoomMonths = intval($_POST['otherRoomDuration'] ?? 0);

    // Kostenberechnung
    $labTotalCost = $labWeeks * $labHours * $labRatePerHour;
    $otherRoomCost = $otherRoomSize * $otherRoomRent * $otherRoomMonths;

    // Gesamtkosten
    $totalRoomCost = $officeFee + $labTotalCost + $otherRoomCost;

    // Ergebnis
    echo "<h1>Raumkosten-Berechnung</h1>";
    echo "<p>Büronutzungsgebühr: €" . number_format($officeFee, 2, ',', '.') . "</p>";
    echo "<p>Laborkosten ($labWeeks Wochen × $labHours h × €$labRatePerHour): €" . number_format($labTotalCost, 2, ',', '.') . "</p>";
    echo "<p>Zusatzraumkosten ($otherRoomSize qm × €$otherRoomRent × $otherRoomMonths Monate): €" . number_format($otherRoomCost, 2, ',', '.') . "</p>";
    echo "<h2>Gesamtkosten: €" . number_format($totalRoomCost, 2, ',', '.') . "</h2>";

} else {
    echo "Ungültige Anfrage.";
}
?>