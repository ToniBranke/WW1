
function validateInput(event) {
    console.log("validateInput called, event: ", event); //Debug-Ausgabe

    let isValid = true; //Validierung wird gespeichert
    const errors = {}; // error messages speichern
    const elementsToValidate = document.querySelectorAll('[data-validate-regex]'); //alle Elemente mit dem Attribut auswählen

    // wählt alle Input-Felder aus
    const allInputFields = document.querySelectorAll('input[type="text"], input[type="numbers"], input[type="email"], input[type="password"]');

    allInputFields.forEach(field => {
        field.style.border= ''; // Rahmen des Feldes wird auf Standard zurückgesetzt
        const errorSpan = document.getElementById(field.id + 'Error'); //findet Element für Fehlermeldungen

        if(errorSpan) { //prüft, ob ErrorSpan existiert
            errorSpan.textContent = ''; // löscht vorherige error-message
            errorSpan.style.display= 'none'; // versteckt Error-Span-Element, falls vorher eins sichtbar war
        }
    });

    elementsToValidate.forEach(element => {
        if(!element) { //falls ein Element nicht gefunden wird, wird es übersprungen
            return;
        }

        const value = element.value.trim(); // nimmt Wert des Feldes
        let fieldError = ''; // Variable zum Speichern der error message für aktuelles Feld
        const regexString = element.dataset.validateRegex; //holt Regex aus Attribut
        const errorMessage = element.dataset.errorMessage || "Eingabe ungültig" // definierte error message oder default error message
        const regex = new RegExp(regexString); // erstellt Ausdrucks-Objekt aus String

        const isRequired = element.dataset.required === 'true'; // prüft, ob Feld als Pflichtfeld markiert ist

        if(isRequired && value.length === 0) { // Feld ist Pflichtfeld und leer
            fieldError = "Feld " + element.name + " darf nicht leer sein.";
            element.style.border = "2px solid red";
            isValid = false;
        } else if(value.length > 0 && !regex.test(value)) { // Feld ist nicht leer und Regex passt nicht
            fieldError = "Feld " + element.name + " hat eine ungültige Eingabe: " + errorMessage;
            element.style.border = "2px solid red";
            isValid = false;
        } else { // wenn keine Fehlerbedingung zutrifft
            element.style.border = ""; //Rahmen zurücksetzen
        }

        const errorSpan = document.getElementById(element.id + 'Error');
        if(errorSpan) {
            if(fieldError) {
                errorSpan.textContent = fieldError; // error message neben Feld anzeigen
                errorSpan.style.display = 'inline'; // Error-Span sichtbar machen
            } else {
                errorSpan.textContent = ''; // error wird gelöscht, falls vorher einer angezeigt wurde
                errorSpan.style.display = 'none'; // Error-Span verstecken
            }
        }
    });

    //Passwörter vergleichen
    const elementsToMatch = document.querySelectorAll('[data-match]'); // alle Elemente mit Attribut
    elementsToMatch.forEach(element => {
        const value = element.value; // holt Wert aus Feld
        const matchId = element.dataset.match;
        const matchElement = document.getElementById(matchId);

        if(matchElement) { // prüft, ob Referenz-Objekt gefunden wurde
            const matchValue = matchElement.value;
            const errorSpan = document.getElementById(element.id + 'Error');

            if(value != matchValue) { // wenn Werte nicht übereinstimmen
                const fieldError = "Eingabe muss mit " + element.name + " übereinstimmen.";
                element.style.border = "2px solid red";
                isValid = false;

                if(errorSpan) {
                    errorSpan.textContent = fieldError;
                    errorSpan.style.display = 'inline';
                }
            } else { // wenn Werte übereinstimmen
                element.style.border = " ";
                if(errorSpan) {
                    errorSpan.textContent = '';
                    errorSpan.style.display = 'none';
                }
            }
        } else {
            console.warn("Element zum Abgleich nicht gefunden"); // Warnung, wenn Referenzfeld fehlt
        }
    });

        if(!isValid) { // wenn es mindestens einen Fehler gibt
            console.log("Validierung fehlgeschlagen."); // Debug-Ausgabe
            if(event) {
                event.preventDefault();
                console.log("event.preventDefault() wurde aufgerufen"); // Debug-Ausgabe
            }
        } else {
            console.log("Alle Felder gültig."); // Debug-Ausgabe
        }

        return isValid;

    }