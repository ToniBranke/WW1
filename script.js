const addButton = document.getElementById('addButton');
const form = document.getElementById('abschreibungForm');
const saveButton = document.getElementById('saveButton');
const summaryList = document.getElementById('summaryListDepreciation');
const submitButton = document.getElementById('submitButton');
const backButton = document.getElementById('backButton');
const abschreibungForm2 = document.getElementById('abschreibungForm2');
const addButton2 = document.getElementById('addAbschtButton');
const saveButton69 = document.getElementById('saveButton69');


// beim Seite öffnen Formular verborgen
form.style.display = 'none';
abschreibungForm2.style.display = 'none';

// bei + Gegenstand Button Klick Formular anzeigen
addButton.addEventListener('click', function () {
    form.style.display = 'block';
    submitButton.style.display = 'none';
    backButton.style.display = 'block';
    abschreibungForm2.style.display = 'none'; // Verstecke das zweite Formular
});

backButton.addEventListener('click', function () {
    form.style.display = 'none';
    submitButton.style.display = 'block';
    backButton.style.display = 'none';
});

addButton2.addEventListener('click', function () {
    abschreibungForm2.style.display = 'block';
    submitButton.style.display = 'none';
    backButton.style.display = 'block';
    form.style.display = 'none'; // Verstecke das erste Formular

});

// klick auf Speichern Button in Liste übertragen
saveButton.addEventListener('click', function (e) {
    e.preventDefault();

    let validationPassed = validateInput(); // Validierung für abschreibungen.html
    if (!validationPassed) {
        console.log("Validierung fehlgeschlagen");
        return;
    }


    // holt die Eingegebenen werte aus dem Formular
    const bezeichnung = document.getElementById('labelBezeichnung').value;
    const kaufpreis = parseFloat(document.getElementById('purchasePrice').value) || 0;
    const ueberProjekt = parseFloat(document.getElementById('projectFinancing').value) || 0;
    const restbetrag = parseFloat(document.getElementById('remainingAmount').value) || 0;
    const folgekosten = parseFloat(document.getElementById('financingRemainingAmount').value) || 0;

    // alert falls keine werte eingegeben wurden
    if (!bezeichnung && (kaufpreis + restbetrag + folgekosten === 0)) {
        alert('Bitte geben Sie einen Wert ein.');
        return;
    }

    // berechung Gesamtbetrag
    const summe = kaufpreis - ueberProjekt;

    // neues Listenelement erstellen
    const li = document.createElement('li');
    li.textContent = `${bezeichnung ? bezeichnung + ': ' : ''}${summe.toFixed(2)} €`;
    summaryList.appendChild(li);

    form.reset();
    form.style.display = 'none';
    submitButton.style.display = 'block';
    backButton.style.display = 'none';
});

saveButton69.addEventListener('click', function (e) {
    e.preventDefault();
    let validationPassed = validateInput(); // Validierung für abschreibungen.html
    if (!validationPassed) {
        console.log("Validierung fehlgeschlagen");
        return;
    }

    // holt die Eingegebenen werte aus dem Formular
    const itemName = document.getElementById('itemName').value;
    var depreciationRateMonth = document.getElementById('depreciationRateMonth').value || 0;
    depreciationRateMonth = depreciationRateMonth.replace(',', '.');
    depreciationRateMonth = parseFloat(depreciationRateMonth);
    const usageHours = parseFloat(document.getElementById('usageHours').value) || 0;



    // alert falls keine werte eingegeben wurden
    if (!itemName && (itemEuroHour + usageHours === 0)) {
        alert('Bitte geben Sie einen Wert ein.');
        return;
    }

    // berechung Gesamtbetrag
    const summe3 = depreciationRateMonth * usageHours;

    // neues Listenelement erstellen
    const li = document.createElement('li');
    li.textContent = `${itemName ? itemName + ': ' : ''}${summe3.toFixed(2)} €`;
    summaryList.appendChild(li);



    form.reset();
    abschreibungForm2.style.display = 'none';
    submitButton.style.display = 'block';
    backButton.style.display = 'none';
});