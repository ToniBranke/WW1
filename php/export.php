<?php
session_start();

//Export nur wenn eingeloggt, zum testen einfach kurz rausnehmen

if (!isset($_SESSION['user'])) {
    http_response_code(403); 
    echo "❌ Zugriff verweigert. Bitte zuerst einloggen.";
    exit;
}
//DB
$db = new SQLite3('mitarbeiterdb1.sqlite');

//Name Datei
$filename = 'mitarbeiter_export_' . date('Y-m-d_H-i-s') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

//Passwort wird nicht exportiert!
$headers = [
    'id',
    'tarif_gruppe',
    'entgeltgruppe',
    'name',
    'benutzername',
    'email',
    'entgelt_stunde',
    'monatsgehalt',
    'ag',
    'jsz',
    'is_assigned_to'
];


fputcsv($output, $headers);

// Daten DB, ohne Passwort
$results = $db->query('SELECT * FROM mitarbeiter');

while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    fputcsv($output, [
        $row['id'],
        $row['tarif_gruppe'],
        $row['entgeltgruppe'],
        $row['name'],
        $row['benutzername'],
        $row['email'],
        $row['entgelt_stunde'],
        $row['monatsgehalt'],
        $row['ag'],
        $row['jsz'],
        $row['is_assigned_to']
    ]);
}

fclose($output);
exit;
?>