login1.php
<?php

// Verbindung zur SQLite-Datenbank
$db = new SQLite3('mitarbeiterdb1.sqlite');

// Wenn das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['Benutzername']) ? $_POST['Benutzername'] : '';
    $password = isset($_POST['Passwort']) ? $_POST['Passwort'] : '';

    // Prüfung auf leere Felder
    if (empty($username) || empty($password)) {
        echo "<p style='color:black;'>Bitte um Überprüfung von dem Benutzernamen und Passwort.</p>";
    } else {
        // Benutzerdaten abfragen
        $stmt = $db->prepare("SELECT * FROM mitarbeiter WHERE benutzername = :benutzername");
        $stmt->bindValue(':benutzername', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);

        if ($user && password_verify($password, $user['passwort'])) {
            //Nutzerdaten in Session speichern
            session_start();
            $_SESSION['username'] = $user['benutzername'];
            $_SESSION['name'] = $user['name'];

            // Weiterleitung zu auswahl.html
            header("Location: ../auswahl.html");

        exit();
        } else {
            // Fehlermeldung bei falschen Anmeldedaten
            echo "<p style='color:red;'>❌ Benutzername oder Passwort ist falsch.</p>";
        }

    }
}
?>