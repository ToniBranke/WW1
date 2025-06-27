document.addEventListener('DOMContentLoaded', function()
{
    const addButton = document.getElementById('addButton');
    const addButton2 = document.getElementById('addButton2');
    const form = document.getElementById('personalForm');
    const form2 = document.getElementById('personalForm2');
    const saveButton = document.getElementById('saveButton');
    const summaryList = document.getElementById('summaryList');
    const submitButton = document.getElementById('submitButton');

    // beim Seite öffnen Formular verborgen
    form.style.display = 'none';
    

    // bei + zu finanz. Mitarbeiter Button Klick Formular anzeigen
    addButton.addEventListener('click', function() 
    {
        form.style.display = 'block';
        form2.style.display = 'none';
        submitButton.style.display = 'none';
    });

    // bei + Hochschul Mitarbeiter Button Klick Formular anzeigen
    addButton2.addEventListener('click', function() 
    {
        form.style.display = 'none';
        form2.style.display = 'block';
        submitButton.style.display = 'none';
    });
    
    // klick auf Spichern Button in Liste übertragen
    saveButton.addEventListener('click', function(e)
    {
        e.preventDefault();

        let validationPassed = validateInput();

        if(!validationPassed) { // wenn Validierung fehlgeschlagen
            return;
        }
        

        // holt die Eingegebenen werte aus dem Formular
        const hk = document.getElementById('hk').value;
        const entgeltgr = document.getElementById('entgeltgr').value;
        const stufe = document.getElementById('stufe').value;
        const jahr2025 = document.getElementById('jahr2025').value;
        const jahr2026 = document.getElementById('jahr2026').value;
        const jahr2027 = document.getElementById('jahr2027').value;
        const wochenstunden = document.getElementById('wochenstunden').value;

        // alert falls keine werte eingegeben wurden
        if (!entgeltgr || ( jahr2025+ jahr2026 + jahr2027 === 0) || !stufe)
        {
            alert('Bitte geben Sie einen Wert ein.');
            return;
        }

        // berechung Gesamtbetrag - muss noch angepasst werden!
        const summe = kaufpreis - ueberProjekt ;

        // neues Listenelement erstellen - muss noch angepasst werden!
        const li = document.createElement('li');
        li.textContent = `${bezeichnung ? bezeichnung + ': ' : ''}${summe.toFixed(2)} €`;
        summaryList.appendChild(li);

        form.reset();
        form.style.display = 'none';
        form2.reset();
        form2.style.display = 'none';
        submitButton.style.display = 'block';
    });
});