document.addEventListener('DOMContentLoaded', function() {
    
    const tabOrder = ["login.html", "allgemein.html", "personalkosten.html", "leistungen.html", "sachkosten.html", "abschreibungen.html", "raeume.html", "abschlussrechnung.html"];
    const currentPath = window.location.pathname.split("/").pop();
    const currentIndex = tabOrder.indexOf(currentPath);
    const nextPage = (currentIndex >= 0 && currentIndex < tabOrder.length -1) 
    ? tabOrder[currentIndex + 1] 
    : null;

    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.addEventListener('click', function(e)
    {
        let validationPassed = validateInput();
        if(!validationPassed) { // wenn Validierung fehlgeschlagen
            console.log("Validierung fehlgeschlagen"); // Debug-Ausgabe
            return;
        }

        if (nextPage)
        {
            window.location.href = nextPage + "?projectId=" + new URLSearchParams(window.location.search).get("projectId");
        }
    });
    
    const saveButton = document.querySelectorAll('.weiterButton');
    saveButton.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            let validationPassed = validateInput();
            if(!validationPassed) { // wenn Validierung fehlgeschlagen
                return;
            }
        });
    });

    const abmelden = document.getElementById('logoutButton');
    abmelden.addEventListener('click', function(e) {
        e.preventDefault();
        alert('Sie wurden erfolgreich abgemeldet!');
        window.location.href = 'login.html';
    });
});