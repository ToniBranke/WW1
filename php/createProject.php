<?php
// Set the database file path
$dbFile = 'projectdb.sqlite';

try {
    // Connect to SQLite database
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS projects (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        A_projectName TEXT NOT NULL,
        A_sponsor TEXT,
        A_faculty TEXT,
        A_responsible TEXT,
        A_costCenter TEXT,
        A_trainingDays INTEGER,
        A_timeframeFrom TEXT,
        A_timeframeUntil TEXT,
        A_economicArea TEXT,
        A_projectCostObjectNumber TEXT,
        B_shk INTEGER,
        B_whk INTEGER,
        B_level INTEGER,
        B_2025 INTEGER,
        B_2026 INTEGER,
        B_2027 INTEGER,
        B_weeklyHours INTEGER,
        C_workContract25 INTEGER,
        C_workContract26 INTEGER,
        C_workContract27 INTEGER,
        C_scientificService25 INTEGER,
        C_scientificService26 INTEGER,
        C_scientificService27 INTEGER,
        C_thirdPartyServices25 INTEGER,
        C_thirdPartyServices26 INTEGER,
        C_thirdPartyServices27 INTEGER
    )");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['projectName'])) {
        // Collect POST values (use null coalescing operator for optional fields)
        $fields = [
            'A_projectName' => $_POST['projectName'],
            'A_sponsor' => $_POST['sponsor'] ?? null,
            'A_faculty' => $_POST['faculty'] ?? null,
            'A_responsible' => $_POST['responsible'] ?? null,
            'A_costCenter' => $_POST['costCenter'] ?? null,
            'A_trainingDays' => $_POST['trainingDays'] ?? null,
            'A_timeframeFrom' => $_POST['timeframeFrom'] ?? null,
            'A_timeframeUntil' => $_POST['timeframeUntil'] ?? null,
            'A_economicArea' => $_POST['economicArea'] ?? null,
            'A_projectCostObjectNumber' => $_POST['projectCostObjectNumber'] ?? null,
            'B_shk' => $_POST['shk'] ?? null,
            'B_whk' => $_POST['whk'] ?? null,
            'B_level' => $_POST['level'] ?? null,
            'B_2025' => $_POST['2025'] ?? null,
            'B_2026' => $_POST['2026'] ?? null,
            'B_2027' => $_POST['2027'] ?? null,
            'B_weeklyHours' => $_POST['weeklyHours'] ?? null,
            'C_workContract25' => $_POST['workContract25'] ?? null,
            'C_workContract26' => $_POST['workContract26'] ?? null,
            'C_workContract27' => $_POST['workContract27'] ?? null,
            'C_scientificService25' => $_POST['scientificService25'] ?? null,
            'C_scientificService26' => $_POST['scientificService26'] ?? null,
            'C_scientificService27' => $_POST['scientificService27'] ?? null,
            'C_thirdPartyServices25' => $_POST['thirdPartyServices25'] ?? null,
            'C_thirdPartyServices26' => $_POST['thirdPartyServices26'] ?? null,
            'C_thirdPartyServices27' => $_POST['thirdPartyServices27'] ?? null
        ];

        // Prepare the insert statement dynamically
        $columns = implode(', ', array_keys($fields));
        $placeholders = ':' . implode(', :', array_keys($fields));
        $stmt = $db->prepare("INSERT INTO projects ($columns) VALUES ($placeholders)");

        // Bind parameters
        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        $projectId = $db->lastInsertId();
        header("Location: ../allgemein.html?projectId=" . urlencode($projectId));
        exit;
    } else {
        echo "Ungültige Anfrage: Projekttitel fehlt.";
    }

} catch (PDOException $e) {
    echo "Fehler bei der Datenbankverbindung oder beim Einfügen: " . $e->getMessage();
}
?>

