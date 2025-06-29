document.addEventListener("DOMContentLoaded", function () {
    const selectButton = document.getElementById("selectButton");
    const newProjectButton = document.getElementById("newProjectButton");

    const selectForm = document.getElementById("selectForm");
    const newProjectForm = document.getElementById("newProjectForm");

    const buttonContainer = document.getElementById("buttonContainer");
    const backButton = document.getElementById("backButton");

    function showOnly(formToShow) {
        // Zeige nur das gewünschte Formular
        [selectForm, newProjectForm].forEach(form => {
            form.style.display = (form === formToShow) ? "block" : "none";
        });

        // Buttons ausblenden, Zurück-Button zeigen
        buttonContainer.style.display = "none";
        backButton.style.display = "inline-block";
    }

    function showButtons() {
        // Formulare verstecken
        [selectForm, newProjectForm].forEach(form => {
            form.style.display = "none";
        });

        // Buttons wieder anzeigen
        buttonContainer.style.display = "flex";
        backButton.style.display = "none";
    }

    // Event Listener
    selectButton.addEventListener("click", () => showOnly(selectForm));
    newProjectButton.addEventListener("click", () => showOnly(newProjectForm));    
    backButton.addEventListener("click", showButtons);
});

/*
document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("existingProject");
    const newProjectForm = document.getElementById("newProjectForm");
    const projectNameInput = document.getElementById("projectName");

    // Projekte aus localStorage laden
    function loadProjects() {
        const projects = JSON.parse(localStorage.getItem("projects")) || [];
        // Dropdown leeren
        select.innerHTML = "";
        // Platzhalter einfügen
        const placeholder = document.createElement("option");
        placeholder.textContent = "-";
        placeholder.value = "";
        select.appendChild(placeholder);

        projects.forEach((project) => {
            const option = document.createElement("option");
            option.value = project;
            option.textContent = project;
            select.appendChild(option);
        });
    }

    // Neues Projekt anlegen
    
    
    newProjectForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const projectName = projectNameInput.value.trim();
        if (!projectName) return;

        let projects = JSON.parse(localStorage.getItem("projects")) || [];
        if (!projects.includes(projectName)) {
            projects.push(projectName);
            localStorage.setItem("projects", JSON.stringify(projects));
            loadProjects(); // Dropdown aktualisieren
        }

        projectNameInput.value = "";
        alert(`Projekt "${projectName}" wurde gespeichert.`);
    });

    loadProjects(); // Beim Laden direkt aktualisieren
    
});
*/

/* SPEICHERORT UND DIE OPTIONEN UEBERARBEITEN*/

document.addEventListener('DOMContentLoaded', () => {
    const selectForm = document.getElementById('selectForm');
    const selectButton = document.getElementById('selectButton');
    const existingProjectSelect = document.getElementById('existingProject');

    // Button "Projektauswahl" zeigt das Formular an
    selectButton?.addEventListener('click', (e) => {
        e.preventDefault();
        selectForm.style.display = 'block';
        document.getElementById('newProjectForm').style.display = 'none';
    });

    // Projekte aus DB laden
    fetch('php/getProjects.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(project => {
                const option = document.createElement('option');
                option.value = project.id; // ID als value
                option.textContent = project.A_projectName; // Name anzeigen
                existingProjectSelect.appendChild(option);
            });
        })
        .catch(err => {
            console.error('Fehler beim Laden der Projekte:', err);
            alert('Projekte konnten nicht geladen werden.');
        });

    // Formular "Öffnen" — redirect mit projectId
    selectForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const selectedId = existingProjectSelect.value;
        if (selectedId) {
            localStorage.setItem("projectId", selectedId);
            window.location.href = `allgemein.html?projectId=${encodeURIComponent(selectedId)}`;
        }
    });
});