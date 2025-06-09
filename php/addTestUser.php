<?php
$db = new SQLite3('mitarbeiterdb1.sqlite');

// Insert test user
$stmt = $db->prepare("
    INSERT INTO mitarbeiter (
        tarif_gruppe, entgeltgruppe, status, bezeichnungs_id, name,
        adresse, telefonnummer, benutzername, passwort,
        entgelt_stunde, monatsgehalt, ag, jsz, is_assigned_to
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bindValue(1, '1');
$stmt->bindValue(2, '1');
$stmt->bindValue(3, 'intern');
$stmt->bindValue(4, '0');
$stmt->bindValue(5, 'Test User');
$stmt->bindValue(6, 'Testadresse 1');
$stmt->bindValue(7, '0123456789');
$stmt->bindValue(8, 'testuser');
$stmt->bindValue(9, password_hash('test', PASSWORD_DEFAULT)); // ⚠️ use same password to test
$stmt->bindValue(10, 20.0);
$stmt->bindValue(11, 3000.0);
$stmt->bindValue(12, 'AG1');
$stmt->bindValue(13, 'JSZ1');
$stmt->bindValue(14, '');

if ($stmt->execute()) {
    echo "✅ Test user added successfully.";
} else {
    echo "❌ Failed to insert test user.";
}
