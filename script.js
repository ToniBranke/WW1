document.addEventListener('DOMContentLoaded', function()
{
    const addButton = document.getElementById('addButton');
    const form = document.getElementById('abschreibungForm');
    const saveButton = document.getElementById('saveButton');
    const summaryList = document.getElementById('summaryListDepreciation');
    const submitButton = document.getElementById('submitButton');
    const backButton = document.getElementById('backButton');

    // beim Seite öffnen Formular verborgen
    form.style.display = 'none';
    

    // bei + Gegenstand Button Klick Formular anzeigen
    addButton.addEventListener('click', function() 
    {
        form.style.display = 'block';
        submitButton.style.display = 'none';
        backButton.style.display = 'block';
    });

    backButton.addEventListener('click', function()
    {
        form.style.display = 'none';
        submitButton.style.display = 'block';
        backButton.style.display = 'none';
    });
    
    // klick auf Speichern Button in Liste übertragen
    saveButton.addEventListener('click', function(e)
    {
        e.preventDefault();

        let validationPassed = validateInput(); // Validierung für abschreibungen.html
        if(!validationPassed) {
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
        if (!bezeichnung &&( kaufpreis+ restbetrag + folgekosten === 0))
        {
            alert('Bitte geben Sie einen Wert ein.');
            return;
        }

        // berechung Gesamtbetrag
        const summe = kaufpreis - ueberProjekt ;

        // neues Listenelement erstellen
        const li = document.createElement('li');
        li.textContent = `${bezeichnung ? bezeichnung + ': ' : ''}${summe.toFixed(2)} €`;
        summaryList.appendChild(li);

        form.reset();
        form.style.display = 'none';
        submitButton.style.display = 'block';
    });
});