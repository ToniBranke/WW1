<?php
$db = new SQLite3('mitarbeiterdb1.sqlite');

// Create table if not exists (just in case)
$db->exec("
CREATE TABLE IF NOT EXISTS mitarbeiter (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tarif_gruppe TEXT DEFAULT 'TG1',
    entgeltgruppe TEXT DEFAULT 'EG1',
    name TEXT,
    benutzername TEXT UNIQUE,
    email TEXT UNIQUE,
    passwort TEXT,
    entgelt_stunde REAL DEFAULT 20,
    monatsgehalt REAL DEFAULT 2000,
    ag TEXT DEFAULT 'AG1',
    jsz TEXT DEFAULT 'JSZ1',
    is_assigned_to TEXT DEFAULT 'unassigned'
);
");

// Check if POST data from registration form exists
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['registerUsername'] ?? '');
    $email = trim($_POST['registerEmail'] ?? '');
    $password = $_POST['registerPassword'] ?? '';
    $confirmPassword = $_POST['registerConfirmPassword'] ?? '';

    // Basic validation
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        echo "Bitte alle Felder ausfüllen.";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "Passwörter stimmen nicht überein.";
        exit;
    }

    // Check if username already exists
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM mitarbeiter WHERE benutzername = :username");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    if ($result['count'] > 0) {
        echo "Benutzername existiert bereits. Bitte wählen Sie einen anderen.";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user, username = name
    $insert = $db->prepare("
        INSERT INTO mitarbeiter (
            name, benutzername, passwort, email
        ) VALUES (:name, :benutzername, :passwort, :email)
    ");
    $insert->bindValue(':name', $username, SQLITE3_TEXT);
    $insert->bindValue(':benutzername', $username, SQLITE3_TEXT);
    $insert->bindValue(':passwort', $hashedPassword, SQLITE3_TEXT);
    $insert->bindValue(':email', $email, SQLITE3_TEXT);

    if ($insert->execute()) {
        // Redirect to login page or show success message
        header("Location: ../login.html");
        exit;
    } else {
        echo "Fehler bei der Registrierung. Bitte versuchen Sie es erneut.";
        exit;
    }
} else {
    echo "Ungültige Anforderung.";
    exit;
}
?>