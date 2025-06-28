document.addEventListener('DOMContentLoaded', function()
{
    const addbueroButton = document.getElementById('addBueroButton');  
    const addLaborButton = document.getElementById('addLaborButton');
    const addAnderesButton = document.getElementById('addAnderesButton');
    const saveButton = document.getElementById('saveButton');
    const submitButton = document.getElementById('submitButton');

    const bueroForm = document.getElementById('officeUsageFeeContainer');
    const laborForm = document.getElementById('LabUsageContainer');
    const anderesForm = document.getElementById('otherRoomContainer');
    const raeumeForm = document.getElementById('raeumeForm');

    const raeumeList = document.getElementById('raeumeSummaryList');

    // beim Seite öffnen Formular verborgen
    bueroForm.style.display = 'none';
    laborForm.style.display = 'none';
    anderesForm.style.display = 'none';
    raeumeForm.style.display = 'none';
    submitButton.style.display = 'block';

    addbueroButton.addEventListener('click', function()
    {
        bueroForm.style.display = 'block';
        raeumeForm.style.display = 'block';
        // andere ausblenden
        laborForm.style.display = 'none';
        anderesForm.style.display = 'none';
        submitButton.style.display = 'none';
    });

    addLaborButton.addEventListener('click', function()
    {
        laborForm.style.display = 'block';
        raeumeForm.style.display = 'block';
        //andere ausblenden
        bueroForm.style.display = 'none';
        anderesForm.style.display = 'none';
        submitButton.style.display = 'none';
    });

    addAnderesButton.addEventListener('click', function()
    {
        anderesForm.style.display = 'block';
        raeumeForm.style.display = 'block';
        //andere ausblenden 
        bueroForm.style.display = 'none';
        laborForm.style.display = 'none';
        submitButton.style.display = 'none';
    });
        

    saveButton.addEventListener('click', function(e)
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

        // berechung Gesamtbetrag
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

            betrag = laborNutzungWochen * laborNutzungStunden;
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
    });
})