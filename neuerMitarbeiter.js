// ---- Stundensatz-Mapping für zu finanzierende Mitarbeiter ----
document.addEventListener('DOMContentLoaded', function() {

    const stundensatzMapping = 
    {
        "E 15": {
            "5": { "2025": 63.30, "2026": 64.77, "2027": 66.30 },
            "4": { "2025": 60.22, "2026": 61.70, "2027": 63.23 },
            "3": { "2025": 57.22, "2026": 58.74, "2027": 60.31 },
            "2": { "2025": 54.27, "2026": 55.81, "2027": 57.41 },
            "1": { "2025": 51.36, "2026": 52.92, "2027": 54.54 }
        },
        "E 14": {
            "5": { "2025": 59.07, "2026": 60.48, "2027": 61.94 },
            "4": { "2025": 56.06, "2026": 57.49, "2027": 58.97 },
            "3": { "2025": 53.12, "2026": 54.59, "2027": 56.11 },
            "2": { "2025": 50.22, "2026": 51.71, "2027": 53.24 },
            "1": { "2025": 47.38, "2026": 48.89, "2027": 50.46 }
        },
        "E 13": {
            "5": { "2025": 54.82, "2026": 56.18, "2027": 57.60 },
            "4": { "2025": 51.95, "2026": 53.34, "2027": 54.78 },
            "3": { "2025": 49.14, "2026": 50.56, "2027": 52.03 },
            "2": { "2025": 46.38, "2026": 47.83, "2027": 49.33 },
            "1": { "2025": 43.67, "2026": 45.14, "2027": 46.67 }
        },
        "E 12": {
            "5": { "2025": 49.60, "2026": 50.93, "2027": 52.31 },
            "4": { "2025": 46.82, "2026": 48.18, "2027": 49.59 },
            "3": { "2025": 44.09, "2026": 45.48, "2027": 46.92 },
            "2": { "2025": 41.41, "2026": 42.83, "2027": 44.31 },
            "1": { "2025": 38.77, "2026": 40.22, "2027": 41.73 }
        },
        "E 11": {
            "5": { "2025": 45.19, "2026": 46.48, "2027": 47.83 },
            "4": { "2025": 42.51, "2026": 43.83, "2027": 45.21 },
            "3": { "2025": 39.89, "2026": 41.24, "2027": 42.64 },
            "2": { "2025": 37.32, "2026": 38.70, "2027": 40.14 },
            "1": { "2025": 34.80, "2026": 36.21, "2027": 37.69 }
        },
        "E 10": {
            "5": { "2025": 41.06, "2026": 42.30, "2027": 43.61 },
            "4": { "2025": 38.47, "2026": 39.74, "2027": 41.08 },
            "3": { "2025": 35.93, "2026": 37.23, "2027": 38.59 },
            "2": { "2025": 33.45, "2026": 34.78, "2027": 36.17 },
            "1": { "2025": 31.02, "2026": 32.38, "2027": 33.80 }
        },
        "E 9b": {
            "5": { "2025": 36.72, "2026": 37.93, "2027": 39.21 },
            "4": { "2025": 34.22, "2026": 35.46, "2027": 36.76 },
            "3": { "2025": 31.77, "2026": 33.04, "2027": 34.37 },
            "2": { "2025": 29.38, "2026": 30.68, "2027": 32.04 },
            "1": { "2025": 27.04, "2026": 28.37, "2027": 29.77 }
        },
        "E 9a": {
            "6": { "2025": 38.04, "2026": 39.34, "2027": 40.71 },
            "5": { "2025": 36.15, "2026": 37.46, "2027": 38.84 },
            "4": { "2025": 34.31, "2026": 35.65, "2027": 37.06 },
            "3": { "2025": 32.52, "2026": 33.88, "2027": 35.30 },
            "2": { "2025": 30.78, "2026": 32.16, "2027": 33.61 },
            "1": { "2025": 29.09, "2026": 30.49, "2027": 31.96 }
        },
        "E 8": {
            "5": { "2025": 32.94, "2026": 34.32, "2027": 35.77 },
            "4": { "2025": 31.30, "2026": 32.70, "2027": 34.17 },
            "3": { "2025": 29.71, "2026": 31.14, "2027": 32.63 },
            "2": { "2025": 28.17, "2026": 29.62, "2027": 31.14 },
            "1": { "2025": 26.68, "2026": 28.16, "2027": 29.71 }
        },
        "E 7": {
            "5": { "2025": 29.70, "2026": 31.13, "2027": 32.62 },
            "4": { "2025": 28.23, "2026": 29.69, "2027": 31.22 },
            "3": { "2025": 26.81, "2026": 28.30, "2027": 29.86 },
            "2": { "2025": 25.44, "2026": 26.96, "2027": 28.55 },
            "1": { "2025": 24.12, "2026": 25.66, "2027": 27.27 }
        },
        "E 6": {
            "5": { "2025": 27.18, "2026": 28.63, "2027": 30.14 },
            "4": { "2025": 25.93, "2026": 27.41, "2027": 28.95 },
            "3": { "2025": 24.72, "2026": 26.22, "2027": 27.78 },
            "2": { "2025": 23.57, "2026": 25.09, "2027": 26.67 },
            "1": { "2025": 22.46, "2026": 24.01, "2027": 25.61 }
        },
        "E 5": {
            "5": { "2025": 24.64, "2026": 26.11, "2027": 27.65 },
            "4": { "2025": 23.52, "2026": 25.02, "2027": 26.58 },
            "3": { "2025": 22.44, "2026": 23.97, "2027": 25.56 },
            "2": { "2025": 21.41, "2026": 22.97, "2027": 24.59 },
            "1": { "2025": 20.42, "2026": 22.01, "2027": 23.65 }
        },
        "E 4": {
            "5": { "2025": 19.60, "2026": 20.62, "2027": 21.69 },
            "4": { "2025": 18.82, "2026": 19.80, "2027": 20.83 },
            "3": { "2025": 18.08, "2026": 19.03, "2027": 20.03 },
            "2": { "2025": 17.37, "2026": 18.29, "2027": 19.26 },
            "1": { "2025": 16.69, "2026": 17.59, "2027": 18.53 }
        },
        "E 3": {
            "5": { "2025": 16.03, "2026": 16.91, "2027": 17.83 },
            "4": { "2025": 15.40, "2026": 16.26, "2027": 17.16 },
            "3": { "2025": 14.80, "2026": 15.64, "2027": 16.52 },
            "2": { "2025": 14.22, "2026": 15.04, "2027": 15.90 },
            "1": { "2025": 13.66, "2026": 14.46, "2027": 15.30 }
        },
        "E 2": {
            "5": { "2025": 13.12, "2026": 13.90, "2027": 14.72 },
            "4": { "2025": 12.59, "2026": 13.35, "2027": 14.15 },
            "3": { "2025": 12.09, "2026": 12.83, "2027": 13.61 },
            "2": { "2025": 11.60, "2026": 12.33, "2027": 13.09 },
            "1": { "2025": 11.13, "2026": 11.84, "2027": 12.59 }
        },
        "E 1": {
            "5": { "2025": 10.68, "2026": 11.37, "2027": 12.09 },
            "4": { "2025": 10.25, "2026": 10.93, "2027": 11.63 },
            "3": { "2025": 9.83, "2026": 10.50, "2027": 11.19 },
            "2": { "2025": 9.43, "2026": 10.09, "2027": 10.77 },
            "1": { "2025": 9.04, "2026": 9.69, "2027": 10.36 }
        }
    };


    const addButton = document.getElementById('addButton');      // + zu finanz. Mitarbeiter
    const form = document.getElementById('personalForm');
    const saveButton1 = document.getElementById('saveButton1');  // Für personalForm
    const summaryList = document.getElementById('summaryList');
    const submitButtons = document.querySelectorAll('#saveButton'); // Alle Weiter-Buttons
    const form2 = document.getElementById('personalForm2');

    addButton.addEventListener('click', function() {
        form.style.display = 'block';
        submitButtons.forEach(btn => btn.style.display = 'none');
        form2.style.display = 'none';
    });

    saveButton1.addEventListener('click', function(e) {
        e.preventDefault();
        let validationPassed = typeof validateInput === "function" ? validateInput() : true;
        if(!validationPassed) return;

        

        const entgeltgr = document.getElementById('entgeltgr').value; // z.B. "E 15"
        const stufe = document.getElementById('stufe').value;         // z.B. "5"

        const jahr2025 = parseFloat(document.getElementById('jahr2025').value.replace(",", ".") || "0");
        const jahr2026 = parseFloat(document.getElementById('jahr2026').value.replace(",", ".") || "0");
        const jahr2027 = parseFloat(document.getElementById('jahr2027').value.replace(",", ".") || "0");
        const wochenstunden = parseFloat(document.getElementById('wochenstunden').value.replace(",", ".") || "0");
        console.log(`Entgeltgruppe: ${entgeltgr}, Stufe: ${stufe}, 2025: ${jahr2025}, 2026: ${jahr2026}, 2027: ${jahr2027}, Wochenstunden: ${wochenstunden}`);


        if (!entgeltgr || !stufe || (!jahr2025 && !jahr2026 && !jahr2027) || !wochenstunden) {
            alert('Bitte alle relevanten Werte eingeben.');
            return;
        }

        // Stundensätze finden
        const entgeltgrFix = entgeltgr.replace(/^E 0*/, "E "); // "E 01" -> "E 1", "E 10" -> "E 10"
        const satzObj = stundensatzMapping[entgeltgrFix] && stundensatzMapping[entgeltgrFix][stufe];
        console.log(`Stundensatz-Objekt:`, stundensatzMapping[entgeltgr]);
        console.log(`Entgeltgruppe: ${entgeltgr}, Stufe: ${stufe}`);
        if (!satzObj) {
            alert('Kein Stundensatz für diese Entgeltgruppe/Stufe gefunden.');
            return;
        }
       

        // Kosten berechnen: Wochenstunden * 52 Wochen * Stundensatz (pro Jahr)
        let kosten = 0;
        if (jahr2025) kosten += jahr2025 * wochenstunden * satzObj["2025"];
        if (jahr2026) kosten += jahr2026 * wochenstunden * satzObj["2026"];
        if (jahr2027) kosten += jahr2027 * wochenstunden * satzObj["2027"];

        if (kosten === 0 || isNaN(kosten)) {
            alert('Bitte gültige Werte eingeben.');
            return;
        }

        const kostenString = kosten.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Nur das Geld anzeigen!
        const li = document.createElement('li');
        li.textContent = `zFM: ${kostenString} €`;
        summaryList.appendChild(li);

        form.reset();
        form.style.display = 'none';
        submitButtons.forEach(btn => btn.style.display = 'block');
    });
});