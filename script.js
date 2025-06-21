document.addEventListener('DOMContentLoaded', function()
{
    const addButton = document.getElementById('addButton');
    const form = document.getElementById('abschreibungForm');
    const saveButton = document.getElementById('saveButton');
    const summaryList = document.getElementById('summaryList');
    const submitButton = document.getElementById('submitButton');

    // beim Seite öffnen Formular verborgen
    form.style.display = 'none';
    

    // bei + Gegenstand Button Klick Formular anzeigen
    addButton.addEventListener('click', function() 
    {
        form.style.display = 'block';
        submitButton.style.display = 'none';
    });
    
    // klick auf Spichern Button in Liste übertragen
    saveButton.addEventListener('click', function(e)
    {
        e.preventDefault();
        

        // holt die Eingegebenen werte aus dem Formular
        const bezeichnung = document.getElementById('bezeichnung').value;
        const kaufpreis = parseFloat(document.getElementById('kaufpreis').value) || 0;
        const ueberProjekt = parseFloat(document.getElementById('ueberProjektfinanzierung').value) || 0;
        const restbetrag = parseFloat(document.getElementById('restbetrag').value) || 0;
        const folgekosten = parseFloat(document.getElementById('finanzierungRestbetragFolgekosten').value) || 0;

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