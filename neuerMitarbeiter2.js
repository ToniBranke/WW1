document.addEventListener('DOMContentLoaded', function() {
    // Buttons und Formulare
    const addButton2 = document.getElementById('addButton2');    // + haushaltfinanz. Mitarbeiter
    const form2 = document.getElementById('personalForm2');
    const saveButton2 = document.getElementById('saveButton2');  // Für personalForm2
    const summaryList = document.getElementById('summaryList');
    const submitButtons = document.querySelectorAll('#saveButton'); // Alle Weiter-Buttons
    const form = document.getElementById('personalForm');

    // Mapping für Entgeltgruppe zu Stundensatz pro Jahr
    const stundensatzMapping = {
        "E 01 - 04": { "2025": 24.55, "2026": 25.28, "2027": 26.06 },
        "E 05 - 08": { "2025": 29.28, "2026": 30.15, "2027": 31.05 },
        "E 09 - 12": { "2025": 42.70, "2026": 43.98, "2027": 45.30 },
        "E 13 - 15": { "2025": 51.80, "2026": 53.35, "2027": 54.95 }
    };

    // Referenz auf das Dropdown und das Input-Feld im 2. Formular
    const entgeltDropdown2 = form2.querySelector('select[name="entgeltgr"]');
    const stundensatzInput2025 = document.getElementById('stundensatz2025');

    // Formular 2 anzeigen und Standardwerte setzen
    addButton2.addEventListener('click', function() {
        form2.style.display = 'block';
        submitButtons.forEach(btn => btn.style.display = 'none');
        // Standardwert für Entgeltgruppe und Stundensatz setzen
        entgeltDropdown2.value = "E 09 - 12";
        if (stundensatzInput2025) {
            stundensatzInput2025.value = stundensatzMapping[entgeltDropdown2.value]["2025"] || '';
        }

        form.style.display = 'none'; // Verstecke das erste Formular
    });

    // Wenn Entgeltgruppe geändert wird, Stundensatz setzen
    entgeltDropdown2.addEventListener('change', function() 
    {
        if (stundensatzInput2025) {
            stundensatzInput2025.value = stundensatzMapping[this.value]["2025"] || '';
        }
    });

    // Klick auf "Hinzufügen" im zweiten Formular (haushaltsfinanzierte MA)
    saveButton2.addEventListener('click', function(e) 
    {
        e.preventDefault();
        let validationPassed = typeof validateInput === "function" ? validateInput() : true;
        if(!validationPassed) return;

        const entgeltgr = entgeltDropdown2.value;
        if (!entgeltgr) {
            alert('Bitte Entgeltgruppe auswählen.');
            return;
        }

        // Werte für Personen und Stunden je Jahr holen
        const anzahl2025 = parseFloat(document.getElementById('anzahlPersonen2025').value.replace(",", ".") || "0");
        const stunden2025 = parseFloat(document.getElementById('gesamtStunden2025').value.replace(",", ".") || "0");
        const anzahl2026 = parseFloat(document.getElementById('anzahlPersonen2026').value.replace(",", ".") || "0");
        const stunden2026 = parseFloat(document.getElementById('gesamtStunden2026').value.replace(",", ".") || "0");
        const anzahl2027 = parseFloat(document.getElementById('anzahlPersonen2027').value.replace(",", ".") || "0");
        const stunden2027 = parseFloat(document.getElementById('gesamtStunden2027').value.replace(",", ".") || "0");

        // Stundensätze holen
        const satz2025 = stundensatzMapping[entgeltgr]["2025"];
        const satz2026 = stundensatzMapping[entgeltgr]["2026"];
        const satz2027 = stundensatzMapping[entgeltgr]["2027"];

        // Kosten berechnen (je Jahr, falls Eintrag vorhanden)
        let kosten = 0;
        if (anzahl2025 && stunden2025) kosten += anzahl2025 * stunden2025 * satz2025;
        if (anzahl2026 && stunden2026) kosten += anzahl2026 * stunden2026 * satz2026;
        if (anzahl2027 && stunden2027) kosten += anzahl2027 * stunden2027 * satz2027;

        // Falls keine Werte: Hinweis
        if (kosten === 0) {
            alert('Bitte alle relevanten Werte eingeben.');
            return;
        }

        // Formatieren (z.B. 12.345,67 €)
        const kostenString = kosten.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Nur das Geld anzeigen!
        const li = document.createElement('li');
        li.textContent = `Haush.finanz.: ${kostenString} €`;
        summaryList.appendChild(li);

        form.reset();
        form2.style.display = 'none';
        submitButtons.forEach(btn => btn.style.display = 'block');
    });
});