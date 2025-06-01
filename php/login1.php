login1.php
<?php

// Verbindung zur SQLite-Datenbank
$db = new SQLite3('mitarbeiterdb1.sqlite');

// Wenn das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Prüfung auf leere Felder
    if (empty($username) || empty($password)) {
        echo "<p style='color:black;'>Bitte um Überprüfung von dem Benutzernamen und Passwort.</p>";
    } else {
        // Benutzerdaten abfragen
        $stmt = $db->prepare("SELECT * FROM mitarbeiterdb1 WHERE benutzername = :benutzername");
        $stmt->bindValue(':benutzername', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            echo "<p style='color:green;'>✅ Anmeldung erfolgreich. Willkommen, " . htmlspecialchars($user['name']) . "!</p>";
        } else {
            echo "<p style='color:red;'>❌ Benutzername oder Passwort ist falsch.</p>";
        }
    }
}
?>