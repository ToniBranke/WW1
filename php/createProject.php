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
        B_summaryList TEXT,
        C_workContract25 REAL,
        C_workContract26 REAL,
        C_workContract27 REAL,
        C_scientificService25 REAL,
        C_scientificService26 REAL,
        C_scientificService27 REAL,
        C_thirdPartyService25 REAL,
        C_thirdPartyService26 REAL,
        C_thirdPartyService27 REAL,
        D_officeSupplies REAL,
        D_softwareLicenses REAL,
        D_advertisingCost REAL,
        D_postagePhoneComm REAL,
        D_storageDevices REAL,
        D_maintenance REAL,
        D_devicesBelow150 REAL,
        D_magazinesLiterature REAL,
        D_materials REAL,
        D_travelCost REAL,
        D_otherExpenses REAL,
        E_summaryList TEXT,
        F_summaryList TEXT,
        G_sumLeistungen REAL,
        G_sumSachkosten REAL
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
            'B_summaryList' => $_POST['summaryList'] ?? null,
            'C_workContract25' => $_POST['workContract25'] ?? null,
            'C_workContract26' => $_POST['workContract26'] ?? null,
            'C_workContract27' => $_POST['workContract27'] ?? null,
            'C_scientificService25' => $_POST['scientificService25'] ?? null,
            'C_scientificService26' => $_POST['scientificService26'] ?? null,
            'C_scientificService27' => $_POST['scientificService27'] ?? null,
            'C_thirdPartyService25' => $_POST['thirdPartyService25'] ?? null,
            'C_thirdPartyService26' => $_POST['thirdPartyService26'] ?? null,
            'C_thirdPartyService27' => $_POST['thirdPartyService27'] ?? null,
            'D_officeSupplies' => $_POST['officeSupplies'] ?? null,
            'D_softwareLicenses' => $_POST['softwareLicenses'] ?? null,
            'D_advertisingCost' => $_POST['advertisingCost'] ?? null,
            'D_postagePhoneComm' => $_POST['postagePhoneComm'] ?? null,
            'D_storageDevices' => $_POST['storageDevices'] ?? null,
            'D_maintenance' => $_POST['maintenance'] ?? null,
            'D_devicesBelow150' => $_POST['devicesBelow150'] ?? null,
            'D_magazinesLiterature' => $_POST['magazinesLiterature'] ?? null,
            'D_materials' => $_POST['materials'] ?? null,
            'D_travelCost' => $_POST['travelCost'] ?? null,
            'D_otherExpenses' => $_POST['otherExpenses'] ?? null,
            'E_summaryList' => $_POST['summaryList'] ?? null,
            'F_summaryList' => $_POST['raeumeSummaryList'] ?? null,
            'G_sumLeistungen' => $_POST['sumLeistungen'] ?? null,
            'G_sumSachkosten' => $_POST['sumSachkosten'] ?? null
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

