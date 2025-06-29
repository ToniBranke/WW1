document.addEventListener('DOMContentLoaded', function()
{
    const addbueroButton = document.getElementById('addBueroButton');  
    const addLaborButton = document.getElementById('addLaborButton');
    const addAnderesButton = document.getElementById('addAnderesButton');
    //const saveButton = document.getElementById('saveButton');
    const submitButton = document.getElementById('submitButton');
    const backButton = document.getElementById('backButton');

    const bueroForm = document.getElementById('officeUsageFeeContainer');
    const laborForm = document.getElementById('LabUsageContainer');
    const anderesForm = document.getElementById('otherRoomContainer');
    const raeumeForm = document.getElementById('raeumeForm');

    //save buttons 
    const saveBueroButton = document.getElementById('bueroSaveButton');
    const saveLabButton = document.getElementById('labSaveButton');
    const saveOtherButton = document.getElementById('andereSaveButton');

    const raeumeList = document.getElementById('raeumeSummaryList');

    // beim Seite öffnen Formular verborgen
    bueroForm.style.display = 'none';
    laborForm.style.display = 'none';
    anderesForm.style.display = 'none';
    raeumeForm.style.display = 'none';
    submitButton.style.display = 'block';
    backButton.style.display = 'none';

    addbueroButton.addEventListener('click', function()
    {
        bueroForm.style.display = 'block';
        raeumeForm.style.display = 'block';
        // andere ausblenden
        laborForm.style.display = 'none';
        anderesForm.style.display = 'none';
        submitButton.style.display = 'none';
        backButton.style.display = 'block';
    });

    addLaborButton.addEventListener('click', function()
    {
        laborForm.style.display = 'block';
        raeumeForm.style.display = 'block';
        //andere ausblenden
        bueroForm.style.display = 'none';
        anderesForm.style.display = 'none';
        submitButton.style.display = 'none';
        backButton.style.display = 'block';
    });

    addAnderesButton.addEventListener('click', function()
    {
        anderesForm.style.display = 'block';
        raeumeForm.style.display = 'block';
        //andere ausblenden 
        bueroForm.style.display = 'none';
        laborForm.style.display = 'none';
        submitButton.style.display = 'none';
        backButton.style.display = 'block';
    });

    backButton.addEventListener('click', function()
    {
        bueroForm.style.display = 'none';
        laborForm.style.display = 'none';
        anderesForm.style.display = 'none';
        raeumeForm.style.display = 'none';
        submitButton.style.display = 'block';
        backButton.style.display = 'none';
    });
        

    /*saveButton.addEventListener('click', function(e)
    {
        e.preventDefault();
        
        let validationPassed = validateInput(); // Validierung für raeume.html
        if(!validationPassed) {
            console.log("Validierung fehlgeschlagen");
            return;
        }


        const LaborNamme = document.getElementById('LabName').value;
        const anderesName = document.getElementById('otherRoomName').value;
        const bueroNutzungsGebuehrName = "büro";

        //save buttons
        const bueroSaveButton = document.getElementById('bueroSaveButton');
        const labSaveButton = document.getElementById('labSaveButton');
        const andereSaveButton = document.getElementById('andereSaveButton');

        // holt die Eingegebenen werte aus dem Formular
        const bueroNutzungsGebuehr = parseFloat(document.getElementById('officeUsageFee').value) || 0;
  
        //Labor Werte 
        const laborNutzungWochen = parseFloat(document.getElementById('labUsageFeeWeeksAmount').value) || 0;
        const laborNutzungStunden = parseFloat(document.getElementById('labUsageFeeHours').value) || 0;

        // Anderes Werte
        const anderesQm = parseFloat(document.getElementById('otherRoomSize').value) || 0;
        const anderesMiete = parseFloat(document.getElementById('otherRoomRent').value) || 0;
        const anderesDauer = parseFloat(document.getElementById('otherRoomDuration').value) || 0;

        /* allert falls keine werte eingegeben wurden
        if (!bezeichnung &&( kaufpreis+ restbetrag + folgekosten === 0))
        {
            alert('Bitte geben Sie einen Wert ein.');
            return;
        } */
         


        /* berechung Gesamtbetrag
        let betrag = 0;
        let bezeichnung = " ";

        if (bueroForm.style.display === 'block') 
        {
        bezeichnung = bueroNutzungsGebuehrName;
        betrag = bueroNutzungsGebuehr;
            }
        else if (laborForm.style.display === 'block')
        {
            bezeichnung = LaborNamme;

            betrag = laborNutzungWochen * laborNutzungStunden *2,18;
        }
        else if (anderesForm.style.display === 'block')
        {
            bezeichnung = anderesName;
            betrag = anderesQm * anderesMiete * anderesDauer;
        }

        

        // neues Listenelement erstellen
        const li = document.createElement('li');
        li.textContent = `${bezeichnung}: ${betrag.toFixed(2)} €`;
        raeumeList.appendChild(li);

        raeumeForm.reset();
        raeumeForm.style.display = 'none';
        submitButton.style.display = 'block';
        backButton.style.display = 'none';
    });
*/

// Büro speichern
    saveBueroButton.addEventListener('click', function() {
        const gebuehr = parseFloat(document.getElementById('officeUsageFee').value) || 0;
        if (gebuehr > 0) {
            const li = document.createElement('li');
            li.textContent = `Büro: ${gebuehr.toFixed(2)} €`;
            raeumeList.appendChild(li);
        }
        raeumeForm.reset();
        raeumeForm.style.display = 'none';
        submitButton.style.display = 'block';
        backButton.style.display = 'none';
    });

    // Labor speichern
    saveLabButton.addEventListener('click', function() {
        const name = document.getElementById('LabName').value;
        const wochen = parseFloat(document.getElementById('labUsageFeeWeeksAmount').value) || 0;
        const stunden = parseFloat(document.getElementById('labUsageFeeHours').value) || 0;
        const betrag = wochen * stunden * 2.18;
        if (name && betrag > 0) {
            const li = document.createElement('li');
            li.textContent = `${name} (Labor): ${betrag.toFixed(2)} €`;
            raeumeList.appendChild(li);
        }
        raeumeForm.reset();
        raeumeForm.style.display = 'none';
        submitButton.style.display = 'block';
        backButton.style.display = 'none';
    });

    // Anderes speichern
    saveOtherButton.addEventListener('click', function() {
        const name = document.getElementById('otherRoomName').value;
        const qm = parseFloat(document.getElementById('otherRoomSize').value) || 0;
        const miete = parseFloat(document.getElementById('otherRoomRent').value) || 0;
        const dauer = parseFloat(document.getElementById('otherRoomDuration').value) || 0;
        const betrag = qm * miete * dauer;
        if (name && betrag > 0) 
            {
            const li = document.createElement('li');
            li.textContent = `${name} (Anderes): ${betrag.toFixed(2)} €`;
            raeumeList.appendChild(li);
        }
                raeumeForm.reset();
        raeumeForm.style.display = 'none';
        submitButton.style.display = 'block';
        backButton.style.display = 'none';
    });
})