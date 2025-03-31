document.addEventListener("DOMContentLoaded", function () {
    showSection('home'); // Show home by default

    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default anchor behavior
            const sectionId = this.getAttribute("href").substring(1);
            showSection(sectionId);
        });
    });
});

function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.style.display = "none"; // Hide all sections
    });

    document.getElementById(sectionId).style.display = "block"; // Show the selected section
}
