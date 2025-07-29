login1.php
<?php
$db = new SQLite3('mitarbeiterdb1.sqlite');

// Check if POST data from login form exists
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['Benutzername']) ? $_POST['Benutzername'] : '';
    $password = isset($_POST['Passwort']) ? $_POST['Passwort'] : '';

    //check for empty inputs
    if (empty($username) || empty($password)) {
        echo "<p style='color:black;'>Bitte um Überprüfung von dem Benutzernamen und Passwort.</p>";
    } else {
        //verify user credentials
        $stmt = $db->prepare("SELECT * FROM mitarbeiter WHERE benutzername = :benutzername");
        $stmt->bindValue(':benutzername', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);

        if ($user && password_verify($password, $user['passwort'])) {
            // Start session and store user information
            session_start();
            $_SESSION['username'] = $user['benutzername'];
            $_SESSION['name'] = $user['name'];

            // Redirect to the project selection page
            header("Location: ../auswahl.html");

        exit();
        } else {
            echo "<p style='color:red;'>❌ Benutzername oder Passwort ist falsch.</p>";
        }
    }
}
?>