const isInPages = window.location.pathname.includes('/pages/');
const pathPrefix = isInPages ? '' : 'pages/';

const searchIndex = [
    { label: "Developpement Digital", page: "development.html", id: "null" },
    { label: "Infrastructure & Systemes", page: "infra.html", id: "null" },
    { label: "Gestion des Entreprises", page: "formations.html", id: "gestion" },
    { label: "Contact", page: "contact.html", id: "contact-section" },
    { label: "Inscription", page: "inscrire.html", id: "inscription-form" }
];

const input = document.getElementById("searchInput");
const suggestions = document.getElementById("searchSuggestions");

if (input) {
    input.addEventListener("input", () => {
        const query = input.value.toLowerCase();
        suggestions.innerHTML = "";

        if (query.length < 2) return;

        const matches = searchIndex.filter(item =>
            item.label.toLowerCase().includes(query)
        );

        matches.forEach(item => {
            const li = document.createElement("li");
            li.className = "list-group-item list-group-item-action";
            li.textContent = item.label;

            li.onclick = () => {
                // If id is "null" (string) or null, just go to page
                const hash = item.id && item.id !== "null" ? `#${item.id}` : '';
                window.location.href = `${pathPrefix}${item.page}${hash}`;
            };

            suggestions.appendChild(li);
        });
    });

    // Hide suggestions on click outside
    document.addEventListener("click", e => {
        if (!e.target.closest("form")) {
            suggestions.innerHTML = "";
        }
    });
}

