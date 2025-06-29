document.addEventListener('DOMContentLoaded', function() {
    
    const tabOrder = ["login.html", "allgemein.html", "personalkosten.html", "leistungen.html", "sachkosten.html", "abschreibungen.html", "raeume.html", "abschlussrechnung.html"];
    const currentPath = window.location.pathname.split("/").pop();
    const currentIndex = tabOrder.indexOf(currentPath);
    const nextPage = (currentIndex >= 0 && currentIndex < tabOrder.length -1) 
    ? tabOrder[currentIndex + 1] 
    : null;

    //(e) zu () machen und preventDefault entfernen wegen post (weiterleitung muss dann auch mit php gemacht werden)
    submitButton.addEventListener('click', function(e)
    {
        e.preventDefault();
        if (nextPage)
        {
            window.location.href = nextPage;
        }
        if(currentPath !== "login.html")
        {
            alert('Daten erfolgreich gespeichert!');    
        }
    });

    const abmelden = document.getElementById('logoutButton');
    abmelden.addEventListener('click', function(e) {
        e.preventDefault();
        alert('Sie wurden erfolgreich abgemeldet!');
        window.location.href = 'login.html';
    });
});